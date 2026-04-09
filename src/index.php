<?php

declare(strict_types=1);

/**
 * @return array<string, array{label:string,tasks:array<int, array{slug:string,title:string,href:string,markdown:string,problemHref:string}>}>
 */
function collectTaskGroups(string $baseDir): array
{
  $groups = [];

  foreach (glob($baseDir . '/part-*', GLOB_ONLYDIR) ?: [] as $partDir) {
    $partName = basename($partDir);
    $groups[$partName] = [
      'label' => partLabel($partName),
      'tasks' => [],
    ];

    foreach (glob($partDir . '/*', GLOB_ONLYDIR) ?: [] as $taskDir) {
      $readmePath = $taskDir . '/README.md';
      if (!is_file($readmePath)) {
        continue;
      }

      $taskName = basename($taskDir);
      $entryFile = null;

      foreach (['index.html', 'index.php'] as $candidate) {
        if (is_file($taskDir . '/' . $candidate)) {
          $entryFile = $candidate;
          break;
        }
      }

      if ($entryFile === null) {
        continue;
      }

      $groups[$partName]['tasks'][] = [
        'slug' => $taskName,
        'title' => readTaskTitle($readmePath, $taskName),
        'href' => sprintf('./%s/%s/%s', $partName, $taskName, $entryFile),
        'markdown' => readTaskMarkdown($readmePath),
        'problemHref' => sprintf('./index.php?part=%s&task=%s', rawurlencode($partName), rawurlencode($taskName)),
      ];
    }
  }

  foreach ($groups as &$group) {
    usort(
      $group['tasks'],
      static fn(array $left, array $right): int => naturalTaskCompare($left['slug'], $right['slug'])
    );
  }
  unset($group);

  return array_filter(
    $groups,
    static fn(array $group): bool => $group['tasks'] !== []
  );
}

function readTaskTitle(string $readmePath, string $fallback): string
{
  $lines = file($readmePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  if ($lines === false) {
    return $fallback;
  }

  foreach ($lines as $line) {
    $trimmed = trim($line);
    if (str_starts_with($trimmed, '# ')) {
      return trim(substr($trimmed, 2));
    }
  }

  return $fallback;
}

function naturalTaskCompare(string $left, string $right): int
{
  if (preg_match('/^([A-Z]+)(\d+)$/', $left, $leftMatches) !== 1) {
    return strnatcasecmp($left, $right);
  }

  if (preg_match('/^([A-Z]+)(\d+)$/', $right, $rightMatches) !== 1) {
    return strnatcasecmp($left, $right);
  }

  $prefixCompare = strcmp($leftMatches[1], $rightMatches[1]);
  if ($prefixCompare !== 0) {
    return $prefixCompare;
  }

  return (int) $leftMatches[2] <=> (int) $rightMatches[2];
}

function partLabel(string $partName): string
{
  return match ($partName) {
    'part-a' => 'Part A',
    'part-b' => 'Part B',
    'part-c' => 'Part C',
    default => strtoupper($partName),
  };
}

function readTaskMarkdown(string $readmePath): string
{
  $markdown = file_get_contents($readmePath);
  if ($markdown === false) {
    return 'README を読み込めませんでした。';
  }

  return preg_replace('/^\h*# .*\R?/u', '', $markdown, 1) ?? $markdown;
}

/**
 * @param array<string, array{label:string,tasks:array<int, array{slug:string,title:string,href:string,markdown:string,problemHref:string}>}> $taskGroups
 * @return array{groupLabel:string,task:array{slug:string,title:string,href:string,markdown:string,problemHref:string}}|null
 */
function findTaskByQuery(array $taskGroups, ?string $partName, ?string $taskName): ?array
{
    if ($partName === null || $taskName === null || !isset($taskGroups[$partName])) {
        return null;
    }

    foreach ($taskGroups[$partName]['tasks'] as $task) {
        if ($task['slug'] === $taskName) {
            return [
                'groupLabel' => $taskGroups[$partName]['label'],
                'task' => $task,
            ];
        }
    }

    return null;
}

$taskGroups = collectTaskGroups(__DIR__);
$selectedTask = findTaskByQuery(
    $taskGroups,
    isset($_GET['part']) && is_string($_GET['part']) ? $_GET['part'] : null,
    isset($_GET['task']) && is_string($_GET['task']) ? $_GET['task'] : null
);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>模擬スピードテスト課題一覧</title>
  <link rel="stylesheet" href="./lib/bootstrap.min.css">
</head>

<body class="bg-body-tertiary">
  <main class="container-xxl py-4 py-lg-5">
    <?php if ($selectedTask !== null): ?>
      <section class="mx-auto" style="max-width: 920px;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
          <div>
            <p class="text-uppercase text-secondary fw-semibold small mb-2"><?= htmlspecialchars($selectedTask['groupLabel'], ENT_QUOTES, 'UTF-8') ?> / <?= htmlspecialchars($selectedTask['task']['slug'], ENT_QUOTES, 'UTF-8') ?></p>
            <h1 class="h3 mb-0"><?= htmlspecialchars($selectedTask['task']['title'], ENT_QUOTES, 'UTF-8') ?></h1>
          </div>
          <a class="btn btn-outline-primary rounded-pill px-4" href="./index.php">一覧へ戻る</a>
        </div>
        <div class="card border-0 shadow-sm">
          <div class="card-body p-4 p-lg-5">
            <div id="problem-body"></div>
          </div>
        </div>
      </section>
    <?php elseif ($taskGroups === []): ?>
      <div class="alert alert-light border text-secondary">表示できる課題がまだ見つかっていません。</div>
    <?php else: ?>
      <?php foreach ($taskGroups as $group): ?>
        <section class="mb-4 mb-xl-5">
          <h2 class="h6 text-uppercase text-secondary fw-bold mb-3"><?= htmlspecialchars($group['label'], ENT_QUOTES, 'UTF-8') ?></h2>
          <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 row-cols-xxl-4 g-4">
            <?php foreach ($group['tasks'] as $task): ?>
              <div class="col">
                <article class="card h-100 border-0 shadow-sm">
                  <div class="card-body d-flex flex-column gap-3 p-4">
                    <div>
                      <div class="text-uppercase text-primary fw-semibold small mb-2"><?= htmlspecialchars($task['slug'], ENT_QUOTES, 'UTF-8') ?></div>
                      <p class="fw-semibold mb-0"><?= htmlspecialchars($task['title'], ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                    <div class="d-flex flex-wrap gap-2 mt-auto">
                      <a class="btn btn-primary rounded-pill px-4" href="<?= htmlspecialchars($task['href'], ENT_QUOTES, 'UTF-8') ?>">開く</a>
                      <a class="btn btn-outline-primary rounded-pill px-4" href="<?= htmlspecialchars($task['problemHref'], ENT_QUOTES, 'UTF-8') ?>">問題</a>
                    </div>
                  </div>
                </article>
              </div>
            <?php endforeach; ?>
          </div>
        </section>
      <?php endforeach; ?>
    <?php endif; ?>
  </main>
  <?php if ($selectedTask !== null): ?>
    <script src="./lib/marked.min.js"></script>
    <script>
      const markdownContent = <?= json_encode($selectedTask['task']['markdown'], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>;
      const problemBody = document.getElementById('problem-body');

      if (problemBody && window.marked) {
        problemBody.innerHTML = window.marked.parse(markdownContent);
        for (const table of problemBody.querySelectorAll('table')) {
          table.classList.add('table', 'table-striped', 'table-bordered');
        }
        for (const pre of problemBody.querySelectorAll('pre')) {
          pre.classList.add('bg-dark', 'text-light', 'p-3', 'rounded', 'overflow-auto');
        }
        for (const code of problemBody.querySelectorAll('code')) {
          if (code.parentElement?.tagName !== 'PRE') {
            code.classList.add('bg-body-secondary', 'px-1', 'rounded');
          }
        }
      }
    </script>
  <?php endif; ?>
</body>

</html>

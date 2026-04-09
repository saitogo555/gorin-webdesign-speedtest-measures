# B44: Navigation APIを使ったSPAライクなページ遷移

以下の要件を満たすSPAライクなルーティングを実装しなさい。`hashchange` イベントではなく、**Navigation API（`window.navigation.addEventListener('navigate', ...)`）**を使用すること。ブラウザ非対応の場合はフォールバックとして `popstate` を使用すること。

- `/`・`/about`・`/contact` の3つのルートに対応すること
- `<a>` タグのクリックで画面全体をリロードせずにコンテンツ部分のみ更新すること
- ブラウザの「戻る」「進む」ボタンで正しくページ遷移すること
- 各ページには異なるタイトルとコンテンツを表示すること

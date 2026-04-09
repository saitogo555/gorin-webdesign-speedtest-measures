# B18: `visibilitychange` イベントを使ったタブ離脱検知

`visibilitychange` イベントを使って、タブを離れた際の動作を実装しなさい。

- タブが非アクティブになると `document.title` が「👀 戻ってきて！」に変わること
- タブに戻ると元のタイトルに戻ること
- タブ離脱の回数と合計離脱時間を計測して表示すること
- `document.visibilityState` を使用すること

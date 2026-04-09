# B28: orientationchangeイベントを使った画面向き検知

以下の要件を満たす画面向き表示ツールを作成しなさい。

- `orientationchange` イベント（または `screen.orientation.addEventListener('change', ...)`）を使用すること
- 縦向き（portrait）の場合は「縦向きです」、横向き（landscape）の場合は「横向きです」と画面中央に表示すること
- 向きに応じてページ全体の背景色が変化すること（色は任意）
- ページ読み込み時にも現在の向きを表示すること

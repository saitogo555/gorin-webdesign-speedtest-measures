# B31: selectionchangeイベントを使ったテキスト選択ツールチップ

以下の要件を満たすテキスト選択ツールチップを作成しなさい。

- `document.addEventListener('selectionchange', ...)` を使用すること
- テキストを選択すると選択範囲のすぐ上に小さなポップアップが表示されること
- ポップアップには「コピー」ボタンを設置し、クリックすると選択テキストがクリップボードにコピーされること
- 選択が解除されるとポップアップが非表示になること
- ポップアップの表示位置は `getSelection().getRangeAt(0).getBoundingClientRect()` を元に算出すること

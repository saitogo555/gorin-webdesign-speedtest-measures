# B45: languagechangeイベントを使ったブラウザ言語変化対応

以下の要件を満たすブラウザ言語対応ページを作成しなさい。

- `window.addEventListener('languagechange', ...)` を使用すること
- 日本語（`ja`）と英語（`en`）の2言語のテキストデータを配列・オブジェクトで用意すること
- ページ読み込み時に `navigator.language` を確認し、日本語なら日本語表示、それ以外なら英語表示とすること
- `languagechange` イベントが発火した際に再度 `navigator.language` を確認し、テキストを自動的に切り替えること
- 言語切り替えボタンを用意し、手動でも切り替えられること（テスト用）

# B22: `hashchange` イベントを使ったSPA風ルーティング

`hashchange` イベントを使って、URLハッシュでページを切り替えるSPA風ルーティングを実装しなさい。

- `#home`、`#about`、`#works`、`#contact` の4ページを用意すること
- URLのハッシュが変わると対応するコンテンツが表示されること
- ナビゲーションリンクをクリックするとURLハッシュが変わること
- ブラウザの戻る・進むボタンでも対応するページが表示されること
- `window.addEventListener('hashchange', ...)` と `window.location.hash` を使用すること

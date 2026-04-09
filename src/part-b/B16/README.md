# B16: `MutationObserver` を使ったDOM変化検知

`MutationObserver` API を使ってDOM変化を検知するツールを実装しなさい。

- テキスト追加・削除・属性変更ができるボタンを用意すること
- DOM変化を検知するたびにログリストに変化内容を記録すること
- ログは最新10件まで表示し、それ以前のものは自動削除すること
- `MutationObserver` の `observe` の `childList`・`attributes`・`subtree` オプションを使い分けること

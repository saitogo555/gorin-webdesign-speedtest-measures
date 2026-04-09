# C13: JSON データの読み込みと表示

PHP で JSON データを扱う機能を実装しなさい。

- 以下の構造を持つ JSON 文字列をPHP内に定義すること
  ```json
  [
    {"id":1,"name":"山田太郎","score":85,"rank":"A"},
    {"id":2,"name":"鈴木花子","score":72,"rank":"B"},
    ...
  ]
  ```
- `json_decode()` でPHP配列に変換すること
- データをHTMLテーブルで表示すること
- 指定したランク（`$_GET['rank']`）でフィルタリングできること
- `json_encode()` で JSON レスポンスとして返すエンドポイントも作成すること（`header('Content-Type: application/json')`）

# B32: PointerLock APIを使った視点操作デモ

以下の要件を満たすPointer Lock（マウスロック）デモを作成しなさい。

- キャンバスまたはdiv要素をクリックすると `requestPointerLock()` でポインタをロックすること
- `pointerlockchange` イベントでロック状態を検知し、ロック中は「ロック中」と画面上に表示すること
- ロック中にマウスを動かすと、`mousemove` イベントの `movementX`・`movementY` を使ってキャンバス上の十字カーソルが移動すること
- Escキーでロックが解除されること

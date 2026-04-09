# B17: `pointerdown` / `pointermove` / `pointerup` イベントを使ったお絵かきツール

Pointer Events を使ってCanvas上のお絵かきツールを実装しなさい。

- `pointerdown` で描画開始、`pointermove` で描画、`pointerup` で描画終了すること
- 線の色・太さを変更できること
- 消しゴムモードを実装すること
- 「全消去」ボタンで Canvas をリセットすること
- `setPointerCapture` を使ってキャンバス外に出ても描画が継続されること

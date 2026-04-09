# B25: `copy` / `paste` イベントを使ったクリップボードフィルター

`copy` と `paste` イベントを使って、クリップボードの内容を加工する機能を実装しなさい。

- テキストエリアでテキストをコピーする際に、`copy` イベントで小文字→大文字変換してクリップボードに格納すること
- テキストをペーストする際に、`paste` イベントで全角数字を半角数字に変換してから貼り付けること
- `event.clipboardData.getData()` と `event.clipboardData.setData()` を使用すること
- `preventDefault()` を適切に使うこと

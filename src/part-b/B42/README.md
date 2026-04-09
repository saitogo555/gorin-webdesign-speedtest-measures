# B42: messageイベントを使ったWeb Workerとの通信

以下の要件を満たすWeb Worker通信デモを作成しなさい。

- メインスレッドで入力された数値を `worker.postMessage()` でWorkerに送信すること
- Worker側では受け取った数値までのフィボナッチ数列を計算すること
- Worker側から `postMessage()` で結果を返し、メインスレッドの `message` イベントで受信すること
- 計算中は「計算中...」と表示し、結果受信後に計算結果をページに表示すること
- Worker用のJSファイルは `worker.js` として作成すること

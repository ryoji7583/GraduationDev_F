<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
    form {
        /* フォームをページの中央に置く */
        margin: 0 auto;
        width: 400px;
        /* フォームの範囲がわかるようにする */
        padding: 1em;
        border: 1px solid #CCC;
        border-radius: 1em;
    }

    form div + div {
        margin-top: 1em;
    }

    label {
        /* すべてのラベルを同じサイズにして、きちんと揃える */
        display: inline-block;
        width: 90px;
        text-align: right;
    }

    input, textarea {
        /* すべてのテキストフィールドのフォント設定を一致させる
        デフォルトで、textarea は等幅フォントが設定されている */
        font: 1em sans-serif;

        /* すべてのテキストフィールドを同じサイズにする */
        width: 300px;
        -moz-box-sizing: border-box;
        box-sizing: border-box;

        /* テキストフィールドのボーダーの外見を同一にする */
        border: 1px solid #999;
        }
        input:focus, textarea:focus {
        /* アクティブな要素を少し強調する */
        border-color: #000;
    }

    textarea {
        /* 複数行のテキストフィールドをラベルにきちんと揃える */
        vertical-align: top;

        /* テキスト入力に十分な領域を与える */
        height: 5em;

        /* ユーザが textarea を垂直方向にリサイズできるようにする
        これが動作しないブラウザもある */
        resize: vertical;
    }

    .button {
        /* ボタンを他のテキストフィールドと同じ場所に置く */
        padding-left: 90px; /* label 要素と同じサイズ */
    }
    
    button {
        /* このマージンは、ラベルとテキストフィールドの間のスペースと
        おおよそ同じスペースを表す */
        margin-left: .5em;
    }
    </style>
    <title>プルリクエストの登録</title>
</head>
<body>
    <h1>プルリクエストの登録</h1>
    <form enctype="multipart/form-data" action="PullRequestRegist.php?ProjectID=<?php echo $_GET["ProjectID"] ?>&PRID=<?php echo $_GET["PRQuantity"] ?>" method="post">
        <div>
            <label for="Title">タイトル:</label>
            <input type="text" name="Title" id="Title" />
        </div>
        <div>
            <label for="Environment">実行環境:</label>
            <textarea name="Environment" id="Environment"></textarea>
        </div>
        <div>
            <label for="Overview">概要:</label>
            <textarea name="Overview" id="Overview"></textarea>
        </div>
        <div>
            <label for="Picture">画像:</label>
            <input type="file" name="Picture" id="Picture" accept="image/*"></input>
        </div>
        <div>
            <label for="Way">実装方法:</label>
            <textarea name="Way" id="Way"></textarea>
        </div>
        <div>
            <label for="Reference">参考ページ:</label>
            <textarea name="Reference" id="Reference"></textarea>
        </div>
        <div class="button">
            <button type="submit" name="button">登録</button>
        </div>
    </form>
</body>
</html>
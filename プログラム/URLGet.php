<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
    textarea {
        width: 600px;
        height: 2em;
        font-size: 140%;
    }
    p{
        font-weight:bold;   
    }
    </style>
    <title>Document</title>
</head>
<body>
    <p>URLを入力してください。</p>
    <form action="URLSet.php" method="post">
        <div>
            <label for="URL">URL:</label>
            <textarea name="URL" id="URL"></textarea>
        </div>
        <div class="button">
            <button type="submit" name="button">登録</button>
        </div>
    </form>
</body>
</html>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Userの登録</title>
</head>
<body>
    <form action="TokenRegist.php?ProjectID=<?php echo $_GET['ProjectID']; ?>" method="post">
        <div>
            <label for="User">ユーザー名:</label>
            <textarea name="User" id="User"></textarea>
        </div>
        <div>
            <label for="Token">トークン:</label>
            <textarea name="Token" id="Token"></textarea>
        </div>
        <div class="button">
            <button type="submit" name="button">登録</button>
        </div>
    </form>
    <a href='https://github.com/settings/developers'>トークン取得ページ</a>
</body>
</html>
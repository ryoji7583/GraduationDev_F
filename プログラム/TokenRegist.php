<?php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'ryoji');
    define('DB_PASSWORD', 'android.1429');
    define('DB_NAME','githubdata');

    try {
        $dbh = new PDO
    ('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASSWORD);
    } catch(PDOException $e){
        echo $e->getMessage();
        exit;
    }

    $User = $_POST['User'];
    $Token = $_POST['Token'];

    $stmt = $dbh -> prepare("INSERT INTO UserToken VALUES (:User, :Token)");
    $stmt->bindParam(':User', $User, PDO::PARAM_STR);
    $stmt->bindParam(':Token', $Token, PDO::PARAM_STR);
    $stmt->execute();

?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>登録が完了しました。<br /><a href='PullRequestAction.php?ProjectID=<?php echo nl2br($_GET['ProjectID']); ?>'>戻る</a></p>
</body>
</html>
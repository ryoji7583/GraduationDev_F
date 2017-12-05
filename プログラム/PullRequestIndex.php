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

$sql = "select * from PRData where ProjectID = '".$_GET["ProjectID"]."' AND PRID = '".$_GET["PRNo"]."';";
$PRData = array();

foreach($dbh->query($sql) as $row){
    array_push($PRData, $row);
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset=utf-8>
    <title><?php echo $PRData[0]['Title']; ?></title>
</head>
<body>
    <input type="button" onclick="location.href='ChangePullRequest.php?ProjectID=<?php echo $_GET["ProjectID"] ?>&PRNo=<?php echo $_GET["PRNo"] ?>'"value="プルリクエストの内容変更">
    <h1><?php echo nl2br($PRData[0]['Title']); ?></h1><br>
    <h2>実行環境</h2>
    <p><?php echo nl2br($PRData[0]['実行環境']) ?></p><br>
    <h2>このページでの内容</h2>
    <p><?php echo nl2br($PRData[0]['ページ内容']); ?></p>
    <h2>結果画面</h2>
    <img src="PictureShow.php?ProjectID=<?php echo $_GET['ProjectID']; ?>&PRNo=<?php echo $_GET['PRNo'] ?>" alt=""/>
    <br>
    <h2>実装方法</h2>
    <?php echo nl2br($PRData[0]['実装方法']); ?>
    <h2>参考ページ一覧</h2>
    <p><a href="<?php echo nl2br($PRData[0]['参考ページ']); ?>"><?php echo nl2br($PRData[0]['参考ページ']); ?></a></p>
</body>
</html>
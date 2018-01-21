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

  $img = NULL;

  $sql = "UPDATE PRData SET 実行画面 = :Picture WHERE PRID = :PullRequestID";
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(':Picture', $img, PDO::PARAM_LOB);
  $stmt->bindParam(':PullRequestID', $_GET["PRNo"], PDO::PARAM_STR);
  $stmt->execute();

  echo "画像を削除しました<br>";
?>
<html>
<head>
  <meta charset="utf-8">
  <title>画像削除ページ</title>
</head>
<body>
    <p><a href="PullRequestIndex.php?ProjectID=<?php echo $_GET['ProjectID'] ?>&PRNo=<?php echo $_GET["PRNo"] ?>">戻る</a></p>
</body>
</html>

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
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>画像保存</title>
</head>
<body>
    <?php
        $PullRequestID = $_GET["PRNo"];
        $image = $_FILES["upfile"];
        move_uploaded_file($image["tmp_name"],$path.$image["name"]);
        $image_data = base64_encode(file_get_contents($path.$image["name"]));
        $stmt = $dbh -> prepare("UPDATE PRData SET 実行画面 = :Picture WHERE PRID = :PullRequestID");
        $stmt->bindParam(':Picture', $image_data, PDO::PARAM_LOB);
        $stmt->bindParam(':PullRequestID', $PullRequestID, PDO::PARAM_STR);
        $stmt->execute();
	?>
    <p>変更しました。<br /><a href="PullRequestIndex.php?ProjectID=<?php echo $_GET['ProjectID'] ?>&PRNo=<?php echo $_GET["PRNo"] ?>">戻る</a></p>
<body>
</html>
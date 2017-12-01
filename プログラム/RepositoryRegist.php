<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'ryoji');
define('DB_PASSWORD', 'android.1429');
define('DB_NAME','githubdata');

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>データ登録</title>
</head>
<body>
<?php

try {
    $dbh = new PDO
('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASSWORD);
} catch(PDOException $e){
    echo $e->getMessage();
    exit;
}
$Picture=NULL;

$Title       = htmlspecialchars($_POST['Title']);
$Overview    = htmlspecialchars($_POST['Overview']);
$ProjectID   = $_GET['RepoID'];

$stmt = $dbh -> prepare("INSERT INTO projectlist VALUES (:ProjectID, :Title, :Overview)");
$stmt->bindParam(':ProjectID', $ProjectID, PDO::PARAM_INT);
$stmt->bindParam(':Title', $Title, PDO::PARAM_STR);
$stmt->bindParam(':Overview', $Overview, PDO::PARAM_STR);
$stmt->execute();
 ?>
 
<p>登録が完了しました。<br /><a href="Front.php">戻る</a></p>
</body>
</html>
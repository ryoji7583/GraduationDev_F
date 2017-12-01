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
$Environment = htmlspecialchars($_POST['Environment']);
$Overview    = htmlspecialchars($_POST['Overview']);
$Picture     = file_get_contents($_FILES['Picture']["tmp_name"]);
$Way         = htmlspecialchars($_POST['Way']);
$Reference   = htmlspecialchars($_POST['Reference']);
$ProjectID   = $_GET['ProjectID'];
$PRID        = $_GET['PRID'];

$stmt = $dbh -> prepare("INSERT INTO PRData VALUES (:ProjectID, :PRID, :Title, :Environment, :Overview, :Picture, :Way, :Reference)");
$stmt->bindParam(':ProjectID', $ProjectID, PDO::PARAM_INT);
$stmt->bindValue(':PRID', $PRID, PDO::PARAM_INT);
$stmt->bindParam(':Title', $Title, PDO::PARAM_STR);
$stmt->bindParam(':Environment', $Environment, PDO::PARAM_STR);
$stmt->bindParam(':Overview', $Overview, PDO::PARAM_STR);
$stmt->bindParam(':Picture', $Picture, PDO::PARAM_LOB);
$stmt->bindParam(':Way', $Way, PDO::PARAM_STR);
$stmt->bindParam(':Reference', $Reference, PDO::PARAM_STR);
$stmt->execute();
 ?>
<p>登録が完了しました。<br /><a href="RepositoryIndex.php?ProjectID=<?php echo $_GET["ProjectID"] ?>">戻る</a></p>
</body>
</html>
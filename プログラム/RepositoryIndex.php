<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'ryoji');
define('DB_PASSWORD', 'android.1429');
define('DB_NAME','githubdata');
define('PROJECTS_PER_PAGE',10);

if (
  isset($_GET["page"]) &&
  $_GET["page"] > 0 &&
  $_GET["page"] <= PROJECTS_PER_PAGE
) {
  $page = (int)$_GET["page"];
} else {
  $page = 1;
}

error_reporting(E_ALL & ~E_NOTICE);

try {
    $dbh = new PDO
('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASSWORD);
} catch(PDOException $e){
    echo $e->getMessage();
    exit;
}

$offset = PROJECTS_PER_PAGE * ($page - 1);
$sql = "select * from PRData where ProjectID = '".$_GET["ProjectID"]."' limit ".$offset.",".PROJECTS_PER_PAGE;
$PRData = array();
foreach($dbh->query($sql) as $row){
    array_push($PRData, $row);
}
$total = $dbh->query("select count(*) from PRData where ProjectID = '".$_GET["ProjectID"]."'")->fetchColumn();
$totalPages = ceil($total / PROJECTS_PER_PAGE);

if($total != 0){
    $from = $offset + 1;
}else{
    $from = 0;
}
$to = ($offset + PROJECTS_PER_PAGE) < $total ? ($offset + PROJECTS_PER_PAGE) : $total;

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset=utf-8>
    <title>プルリクエスト一覧</title>
</head>
<body>
    <h1>プルリクエスト一覧</h1>
    <input type="button" onclick="location.href='PullRequestAction.php?ProjectID=<?php echo $_GET["ProjectID"] ?>'"value="プルリクエスト送信">
    <p>全<?php echo $total; ?>件中、<?php echo $from; ?>件~<?php echo $to; ?>件を表示しています。</p>
    <ul>
    <?php foreach ($PRData as $PRData) :?>
    <li><a href="PullRequestIndex.php?ProjectID=<?php echo $_GET["ProjectID"] ?>&PRNo=<?php echo $PRData["PRID"]; ?>"><?php echo htmlspecialchars($PRData['Title'],ENT_QUOTES,'UTF-8'); ?></a></li>
    <p><?php echo htmlspecialchars($PRData['ページ内容'],ENT_QUOTES,'UTF-8'); ?></p>
    <?php endforeach; ?>
    </ul>
    <?php if($page > 1) : ?>
    <a href="?page=<?php echo $page-1; ?>">前</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
        <?php if ($page == $i) : ?>
        <strong><a href="?ProjectID=<?php echo $_GET["ProjectID"] ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></strong>
        <?php else : ?>
        <a href="?ProjectID=<?php echo $_GET["ProjectID"] ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endif; ?>
    <?php endfor; ?>
    <?php if($page < $totalPages) : ?>
    <a href="?page=<?php echo $page+1; ?>">次</a>
    <?php endif; ?>
    <p><br /><a href="Front.php">一覧に戻る</a></p>
</body>
</html>
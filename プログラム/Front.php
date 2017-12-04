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
$sql = "select * from RepositoryList limit ".$offset.",".PROJECTS_PER_PAGE;
$RepositoryList = array();
foreach($dbh->query($sql) as $row){
    array_push($RepositoryList, $row);
}
$total = $dbh->query("select count(*) from RepositoryList")->fetchColumn();
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
    <title>リポジトリ一覧</title>
</head>
<body>
    <h1>リポジトリ一覧</h1>
    <input type="button" onclick="location.href='URLGet.php'"value="リポジトリ登録">
    <p>全<?php echo $total; ?>件中、<?php echo $from; ?>件~<?php echo $to; ?>件を表示しています。</p>
    <ul>
    <?php foreach ($RepositoryList as $RepositoryList) :?>
    <li><a href="RepositoryIndex.php?ProjectID=<?php echo $RepositoryList['ProjectID']; ?>&page=1"><?php echo htmlspecialchars($RepositoryList['ProjectName'],ENT_QUOTES,'UTF-8'); ?></a></li>
    <p><?php echo htmlspecialchars($projectlist['概要'],ENT_QUOTES,'UTF-8'); ?></p>
    <?php endforeach; ?>
    </ul>
    <?php if($page > 1) : ?>
    <a href="?page=<?php echo $page-1; ?>">前</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
        <?php if ($page == $i) : ?>
            <strong>
            <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </strong>
        <?php else : ?>
            <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endif; ?>
    <?php endfor; ?>
    <?php if($page < $totalPages) : ?>
    <a href="?page=<?php echo $page+1; ?>">次</a>
    <?php endif; ?>

</body>
</html>
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
    $sql = "select * from RepositoryList where ProjectID = '".$_GET["ProjectID"]."'";
    $RepositoryList = array();
    foreach($dbh->query($sql) as $row){
        array_push($RepositoryList, $row);
    }
    $sql2 = "select * from UserToken";
    $UserToken = array();
    foreach($dbh->query($sql2) as $row){
        array_push($UserToken, $row);
    }
?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>変更データ送信</title>
</head>
<body>
    <?php 
    $Owner = $RepositoryList[0]['User'];
    $RepoName = $RepositoryList[0]['ProjectName'];
    $Title = mb_convert_encoding($_POST['Title'],"cp932","UTF-8");
    $Branch = 'master';
    $Body = mb_convert_encoding($_POST['Body'],"cp932","UTF-8");
    $User = $_POST['User'];
    $Token = $UserToken[0]['Token'];
    $PRNo = $_GET['PRNo'];
    $fullPath = 'Python PullRequestChange.py "'.$Owner.'" "'.$RepoName.'" "'.$Title.'" "'.$Branch.'" "'.$Body.'" "'.$User.'" "'.$Token.'" "'.$PRNo.'"';
    exec($fullPath, $outpara,$return);
    echo $return;
    ?>
    <p>変更しました。<br /><a href="PullRequestIndex.php?ProjectID=<?php echo $_GET['ProjectID'] ?>&PRNo=<?php echo $_GET["PRNo"] ?>">戻る</a></p>
</body>
</html>
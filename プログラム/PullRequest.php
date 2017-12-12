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
    <title>PullRequestの送信</title>
</head>
<body>
    <?php
    $Body = "【実行環境】\n";
    $Body .= $_POST['Environment'];
    $Body .= "\n";
    $Body .= "【このページでの内容】\n";
    $Body .= $_POST['Overview'];
    $Body .= "\n";
    $Body .= "【実装方法】\n";
    $Body .= $_POST['Way'];
    $Body .= "\n";
    $Body .= "【参考ページ一覧】\n";
    $Body .= $_POST['Reference'];
    $Body = str_replace("\n", '\n', $Body);
    $head  = $_POST['User'];
    $head .= ':';
    $head .= $_POST['ChangeBranch'];
    $Owner = $RepositoryList[0]['User'];
    $RepoName = $RepositoryList[0]['ProjectName'];
    $Title = mb_convert_encoding($_POST['Title'],"cp932","UTF-8");
    $Branch = $_POST['GetBranch'];
    $Body = mb_convert_encoding($Body,"cp932","UTF-8");
    $User = $_POST['User'];
    $Token = $UserToken[0]['Token'];
    $fullPath = "Python PullRequestSend.py '".$Owner."' '".$RepoName."' '".$Title."' '".$head."' '".$Branch."' '".$Body."' '".$User."' '".$Token."' 2>&1";
    exec($fullPath, $outpara);
    ?>
    <p>送信しました。<br /><a href="RepositoryIndex.php?ProjectID=<?php echo $RepositoryList[0]['ProjectID'] ?>">戻る</a></p>
</body>
</html>
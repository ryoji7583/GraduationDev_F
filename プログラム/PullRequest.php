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
    $head  = $_POST['User'];
    $head .= ':';
    $head .= $_POST['ChangeBranch'];
    $fullPath ='python PullRequestSend.py "'.$RepositoryList[0]['User'].'" "'.$RepositoryList[0]['ProjectName'].'" "'.$_POST['Title']
    .'" "'.$head.'" "'.$_POST['GetBranch'].'" "'.$_POST['Body'].'" "'.$_POST['User'].'" "'.$_POST['Token'].'" 2>&1';
    echo "export LANG=ja_JP.UTF-8;".$fullPath;
    exec("export LANG=ja_JP.UTF-8;".$fullPath, $outpara, $return_ver);
    echo '実行結果：'.$return_ver;
    echo '<PRE>';
    count($outpara);
    echo nl2br("\n");
    for($i=0 ; $i < count($outpara); $i++){
    header("Content-type: text/html charset=Shift_JIS");
    echo $outpara[$i];
    echo nl2br("\n");
    }
    echo '<PRE>';
    ?>
    <p>送信しました。<br /><a href="RepositoryIndex.php?ProjectID=<?php echo $RepositoryList[0]['ProjectID'] ?>">戻る</a></p>
</body>
</html>
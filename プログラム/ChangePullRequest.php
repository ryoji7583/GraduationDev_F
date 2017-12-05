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
    $sql = "select * from UserToken";
    $UserToken = array();
    foreach($dbh->query($sql) as $row){
        array_push($UserToken, $row);
    }
?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>プルリクエストの内容変更ページ</title>
</head>
<body>
    <form action="ChangeDataSend.php?ProjectID=<?php echo $_GET['ProjectID']; ?>&PRNo=<?php echo $_GET["PRNo"] ?>" method="post">
        <div>
            <label for="User">ユーザー名:</label>
            <select name="User" id="User">
            <?php
            for($i=0 ; $i < count($UserToken); $i++){
            print ('<option value="' . $UserToken[$i]['UserName']. '">' . $UserToken[$i]['UserName'] . '</option>');
            }
            ?>
            </select>
        </div>
        <div>
            <label for="Title">タイトル:</label>
            <textarea name="Title" id="Title"></textarea>
        </div>
        <div>
            <label for="Body">内容:</label>
            <textarea name="Body" id="Body"></textarea>
        </div>
        <div class="button">
            <button type="submit" name="button">変更</button>
        </div>
    </form>
    <input type="button" onclick="location.href='TokenSet.php?ProjectID=<?php echo $_GET["ProjectID"] ?>'"value="ユーザーの登録">
</body>
</html>
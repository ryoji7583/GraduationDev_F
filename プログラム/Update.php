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
    $sql = "select * from RepositoryList";
    $RepositoryList = array();
    foreach($dbh->query($sql) as $row){
        array_push($RepositoryList, $row);
    }
    $RepositoryID='';
    $RepositoryDescription='';
    $PullRequestID='';
    $PullRequestTitle='';
    $PullRequestBody='';
    $Environment = '';
    $Picture     = '';
    $Way         = '';
    $Reference   = '';
?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php
        for($i=0 ; $i < count($RepositoryList); $i++){
            $User = $RepositoryList[$i]['User'];
            $RepoName = $RepositoryList[$i]['ProjectName'];
            $fullPath ='python GithubDataGet.py '.$User.' '.$RepoName;
            exec($fullPath, $outpara);
            echo '<PRE>';
            $i=0;
            if(strcmp($outpara[$i], 'RepositoryID') == 0){
                while(strcmp($outpara[$i+1], 'RepositoryDescription') != 0){
                    $i++;
                    $RepositoryID .= $outpara[$i];
                }
            $i++;
            }
            if(strcmp($outpara[$i], 'RepositoryDescription') == 0){
                while(strcmp($outpara[$i+1], 'PullRequestID') != 0){
                    $i++;
                    $RepositoryDescription .= $outpara[$i];
                }
                $i++;
            }
            $stmt = $dbh -> prepare("INSERT INTO RepositoryList VALUES (:RepositoryID, :RepoTitle, :Overview, :User)");
            $stmt->bindParam(':RepositoryID', $RepositoryID, PDO::PARAM_STR);
            $stmt->bindParam(':RepoTitle', $RepoName, PDO::PARAM_STR);
            $stmt->bindParam(':Overview', $RepositoryDescription, PDO::PARAM_STR);
            $stmt->bindParam(':User', $User, PDO::PARAM_STR);
            $stmt->execute();

            for($i ; $i < count($outpara); $i++){
                if(strcmp($outpara[$i], 'PullRequestID') == 0){
                    while(strcmp($outpara[$i+1], 'PullRequestTitle') != 0){
                        $i++;
                        $PullRequestID .= $outpara[$i];
                    }
                    $i++;
                }
                if(strcmp($outpara[$i], 'PullRequestTitle') == 0){
                    while(strcmp($outpara[$i+1], 'PullRequestBody') != 0){
                        $i++;
                        $PullRequestTitle .= $outpara[$i];
                    }
                    $i++;
                }
                if(strcmp($outpara[$i], 'PullRequestBody') == 0){
                    while(strcmp($outpara[$i+1], 'PullRequestEnd') != 0){
                        $i++;
                        $PullRequestBody .= $outpara[$i];
                    }
                    $i++;
                }
                $stmt = $dbh -> prepare("INSERT INTO PRData VALUES (:RepositoryID, :PullRequestID, :Title, :Environment, :Overview, :Picture, :Way, :Reference)");
                $stmt->bindParam(':RepositoryID', $RepositoryID, PDO::PARAM_STR);
                $stmt->bindParam(':PullRequestID', $PullRequestID, PDO::PARAM_STR);
                $stmt->bindParam(':Title', $PullRequestTitle, PDO::PARAM_STR);
                $stmt->bindParam(':Environment', $Environment, PDO::PARAM_STR);
                $stmt->bindParam(':Overview', $PullRequestBody, PDO::PARAM_STR);
                $stmt->bindParam(':Picture', $Picture, PDO::PARAM_LOB);
                $stmt->bindParam(':Way', $Way, PDO::PARAM_STR);
                $stmt->bindParam(':Reference', $Reference, PDO::PARAM_STR);
                $stmt->execute();
                $PullRequestID='';
                $PullRequestTitle='';
                $PullRequestBody='';
            echo '<PRE>';
            }
        }
        http_response_code( 301 ) ;
	    header( "Location: Front.php" ) ;
	    exit ;
    ?>
</body>
</html>
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

    $sql2 = "select * from PRData";
    $PRData = array();
    foreach($dbh->query($sql2) as $row){
        array_push($PRData, $row);
    }

    $Environment = '';
    $Picture     = '';
    $Way         = '';
    $Reference   = '';

    for($j=0 ; $j < count($RepositoryList); $j++){
        $PullRequestID='';
        $PullRequestTitle='';
        $PullRequestBody='';
        $RepositoryID='';
        $RepositoryDescription='';
        $User = $RepositoryList[$j]['User'];
        $RepoName = $RepositoryList[$j]['ProjectName'];
        $fullPath ='python GithubDataGet.py '.$User.' '.$RepoName;
        exec($fullPath, $outpara);
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
        if(strcmp($RepositoryList[$j]['Overview'], $RepositoryDescription) != 0){
            $stmt = $dbh -> prepare("UPDATE RepositoryList SET Overview = :Overview WHERE ProjectID = :RepositoryID");
            $stmt->bindParam(':Overview', $RepositoryDescription, PDO::PARAM_STR);
            $stmt->bindParam(':RepositoryID', $RepositoryID, PDO::PARAM_STR);
            $stmt->execute();
        }
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

            $stmt = $dbh -> prepare("UPDATE PRData SET Title = :Title, Enviroment = :Environment, Overview = :Overview, Picture = :Picture, Way = :Way, Reference = :Reference WHERE PullRequestID = :PullRequestID");
            $stmt->bindParam(':Title', $PullRequestTitle, PDO::PARAM_STR);
            $stmt->bindParam(':Environment', $Environment, PDO::PARAM_STR);
            $stmt->bindParam(':Overview', $PullRequestBody, PDO::PARAM_STR);
            $stmt->bindParam(':Picture', $Picture, PDO::PARAM_LOB);
            $stmt->bindParam(':Way', $Way, PDO::PARAM_STR);
            $stmt->bindParam(':Reference', $Reference, PDO::PARAM_STR);
            $stmt->bindParam(':PullRequestID', $PullRequestID, PDO::PARAM_STR);
            $stmt->execute();
        }
    }
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
    <p>更新が完了しました。<br /><a href="Front.php">戻る</a></p>
</body>
</html>
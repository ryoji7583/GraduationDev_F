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
    $PullRequestID='';
    $PullRequestTitle='';
    $PullRequestBody='';
    $Environment = '';
    $Picture     = '';
    $Way         = '';
    $Reference   = '';

    for($j=0 ; $j < count($RepositoryList); $j++){
        $RepositoryID='';
        $RepositoryDescription='';
        $User = $RepositoryList[$j]['User'];
        $RepoName = $RepositoryList[$j]['ProjectName'];
        $outpara = [];
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
        if(strcmp($RepositoryList[$j]['概要'], $RepositoryDescription) != 0){
            $stmt = $dbh -> prepare("UPDATE RepositoryList SET 概要 = :Overview WHERE ProjectID = :RepositoryID");
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
                    $PullRequestBody .= "\n";
                }
                $i++;
            }
            $Overview = $PullRequestBody;  
            $start = '';
            $end = '';
            $src=$PullRequestBody;
            if(mb_strpos($src,'【実行環境】') !== false){
                $start = mb_strpos($src,'【実行環境】')+6;
                $end = mb_strpos($src,'【このページでの内容】');
                if($end){
                    $Environment = mb_substr($src, $start, $end-$start);
                }else{
                    $end = mb_strpos($src,'【実装方法】');
                    if($end){
                        $Environment = mb_substr($src, $start, $end-$start);
                    }else{
                        $end = mb_strpos($src,'【参考ページ一覧】');
                        if($end){
                            $Environment = mb_substr($src, $start, $end-$start);   
                        }else{
                            $end = strlen($src);
                            $Environment = mb_substr($src, $start, $end-$start);
                        }
                    }
                }
                $start = '';
                $end = '';
            }
            if(mb_strpos($src,'【このページでの内容】') !== false){
                $start = mb_strpos($src,'【このページでの内容】')+11;
                $end = mb_strpos($src,'【実装方法】');
                if($end){
                    $Overview = mb_substr($src, $start, $end-$start);
                }else{
                    $end = mb_strpos($src,'【参考ページ一覧】');
                    if($end){
                        $Overview = mb_substr($src, $start, $end-$start);
                    }else{
                        $end = strlen($src);
                        $Overview = mb_substr($src, $start, $end-$start);
                    }
                }
                $start = '';
                $end = '';
            }
            if(mb_strpos($src,'【実装方法】') !== false){
                $start = mb_strpos($src,'【実装方法】')+6;
                $end = mb_strpos($src,'【参考ページ一覧】');
                if($end){
                    $Way = mb_substr($src, $start, $end-$start);
                }else{
                    $end = strlen($src);
                    $Way = mb_substr($src, $start, $end-$start);
                }
                $start = '';
                $end = '';
            }
            if(mb_strpos($src,'【参考ページ一覧】') !== false){
                $start = mb_strpos($src,'【参考ページ一覧】')+9;
                $end = strlen($src);
                $Reference = mb_substr($src, $start, $end-$start);
            }
            $stmt = $dbh -> prepare("INSERT INTO PRData VALUES (:RepositoryID, :PullRequestID, :Title, :Environment, :Overview, :Picture, :Way, :Reference)");
            $stmt->bindParam(':RepositoryID', $RepositoryID, PDO::PARAM_STR);
            $stmt->bindParam(':PullRequestID', $PullRequestID, PDO::PARAM_STR);
            $stmt->bindParam(':Title', $PullRequestTitle, PDO::PARAM_STR);
            $stmt->bindParam(':Environment', $Environment, PDO::PARAM_STR);
            $stmt->bindParam(':Overview', $Overview, PDO::PARAM_STR);
            $stmt->bindParam(':Picture', $Picture, PDO::PARAM_LOB);
            $stmt->bindParam(':Way', $Way, PDO::PARAM_STR);
            $stmt->bindParam(':Reference', $Reference, PDO::PARAM_STR);
            $stmt->execute();

            $stmt = $dbh -> prepare("UPDATE PRData SET Title = :Title, 実行環境 = :Environment, ページ内容 = :Overview, 実装方法 = :Way, 参考ページ = :Reference WHERE PRID = :PullRequestID");
            $stmt->bindParam(':Title', $PullRequestTitle, PDO::PARAM_STR);
            $stmt->bindParam(':Environment', $Environment, PDO::PARAM_STR);
            $stmt->bindParam(':Overview', $Overview, PDO::PARAM_STR);
            $stmt->bindParam(':Way', $Way, PDO::PARAM_STR);
            $stmt->bindParam(':Reference', $Reference, PDO::PARAM_STR);
            $stmt->bindParam(':PullRequestID', $PullRequestID, PDO::PARAM_STR);
            $stmt->execute();

            $PullRequestID='';
            $PullRequestTitle='';
            $PullRequestBody='';
            $Environment = '';
            $Picture     = '';
            $Way         = '';
            $Reference   = '';
            $Overview    = '';
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
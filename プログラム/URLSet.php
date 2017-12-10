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


    $url = $_POST['URL'];
    $RepositoryID='';
    $RepositoryDescription='';
    $PullRequestID='';
    $PullRequestTitle='';
    $PullRequestBody='';
    $Environment = '';
    $Picture     = '';
    $Way         = '';
    $Reference   = '';

    if(parse_url($url, PHP_URL_SCHEME)=="https" && parse_url($url, PHP_URL_HOST)=="github.com"){
        $Path = parse_url($url, PHP_URL_PATH);
        $keywords = preg_split("#(?<!/)/(?!/)#", $Path);
        $User = $keywords[1];
        $RepoName = $keywords[2];
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
                $RepositoryDescription .= "\n";
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

        $PullRequestID='';
        $PullRequestTitle='';
        $PullRequestBody='';
        $Environment = '';
        $Picture     = '';
        $Way         = '';
        $Reference   = '';
        $Overview    = '';
        }
    }else{
        echo "GitHubのURLを入力してください。";
    }
     ?>
    <p>登録が完了しました。<br /><a href="Front.php">戻る</a></p>
</body>
</html>
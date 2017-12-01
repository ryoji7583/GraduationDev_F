<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php $url = $_POST['URL']; 
    if(parse_url($url, PHP_URL_SCHEME)=="https" && parse_url($url, PHP_URL_HOST)=="github.com"){
        $Path = parse_url($url, PHP_URL_PATH);
        $keywords = preg_split("#(?<!/)/(?!/)#", $Path);
        $User = $keywords[1];
        $RepoName = $keywords[2];
        echo $User;
        echo $RepoName;
    }else{
        echo "GitHubのURLを入力してください。";
    }
     ?>
</body>
</html>
# Step1 システム利用の準備
## Step1.1 リポジトリのクローン
リポジトリをクローンする．（本リポジトリ） URL→ https://github.com/ryoji7583/GraduationDev_F

## Step1.2 Pythonのインストール

https://qiita.com/maholoba/items/8f855a5d8d10150a3e2a

画像等詳細は上記のURLを参照．

https://www.python.org/downloads/windows/ より，Python 2.7 パッケージをダウンロードします．
画面の一番下に，ダウンロード可能なファイルが表示されます．インストールするWindowsが32bit版なら

Windows x86 MSI installer

64bit版なら

Windows x86-64 MSI installer

をインストールしてください．

Windowsの種類が不明な場合は，

https://support.microsoft.com/ja-jp/help/958406

を参照に確認してください．

ダウンロードしたパッケージを実行し，Next をクリックしてインストールを完了させておく．

接続先データベース（MySQL）の情報,usernameに接続ユーザ－名，passwordに接続ユーザーのパスワードを記述する．

## Step1.3 Apacheのインストール

https://techacademy.jp/magazine/1846

画像等詳細は上記のURLを参照．

Apacheとは、Webサイトを提供するためのソフトウェアです．
現在，インターネットにはありとあらゆるWebサイトが存在していますが，それら全てが，Webサーバソフトウェアと言われるツールによって提供されています．
Webサーバソフトウェアの中でも，世界中で利用されているツールが「Apache」です．

Apache LoungeにアクセスしてApacheインストーラーをダウンロードします．
クリック後，インストーラー「httpd-2.4.9-win64-VC11.zip」のダウンロードが始まるので少し待ちます．ダウンロードが終了したら，Zipファイルを解凍します．

続いて，フォルダ内に存在する「Apache24」を「C:\」に移します．「Apache24」上で右クリック→切り取りを選択してください．
(もちろん「Apache24」を選択して「Ctrl+x」でも大丈夫です．)
続いて，「C:\」フォルダを表示させ，フォルダ内で右クリック→貼り付けを選択します．
(もちろん「C:\」を表示させて，「Ctrl+v」でも大丈夫です．)
「C:\Apache24」フォルダがあることを確認し，「Apache24」フォルダを表示させます．

フォルダ内の「conf」フォルダをクリックし，「httpd.conf」ファイルをテキストエディタで表示させます．
表示させた後，検索機能で「ServerName」を検索します．
検索すると「#ServerName www.example.com:80」がヒットするので，「#」を削除して上書き保存してください．

Apacheのインストールや起動は基本的にコマンドプロンプトを使用します．
コマンドプロンプトは
「スタート」→「すべてのプログラム」→「アクセサリ」→「コマンドプロンプト」
で使用することができます．

最初にコマンドプロンプトを起動してください．
コマンドプロンプトが表示されたら，「cd c:\Apache24\bin」と入力し，「Enter」を押します．
入力欄の左側が「c:\Apache24\bin>」に変化したらOKです．

続いて「httpd -k install」と入力し，「Enter」を押します．
このように表示されたらインストールは完了です．

## Step1.4 mySQLのインストール

https://www.dbonline.jp/mysql/install/index1.html

画像等詳細は上記のURLを参照．

まず
http://www-jp.mysql.com/
からmysqlをダウンロードしてくる．
画面上部にある「ダウンロード」と書かれたタブをクリックして下さい．
MySQLのダウンロードに関するページが表示されます．

画面の下の方に「MySQL Community Edition (GPL)」と書かれたブロックがあります．そこに表示されている「Community (GPL) Downloads」と書かれたリンクをクリックして下さい．
「MySQL Community Downloads」のページが表示されます．

「MySQL Community Server (GPL)」ブロックの中にある「DOWNLOAD」と書かれたリンクをクリックして下さい．
「Download MySQL Community Server」のページが表示されます．

MySQLをインストールするプラットフォームを「Select Platform」に下に表示されているドロップダウンメニューで選択します．今回はWindows環境にインストールしますので「Microsoft Windows」が選択して下さい(デフォルトで選択されている場合は何もしなくて結構です)．

プラットフォームの選択が終わりましたら画面の下記の「MySQL Installer 5.7 for Windows」と表示された画像をクリックして下さい．32bit環境でも64bit環境でも同じです．

「Download MySQL Installer」のページが表示されます．(このページに「Note: MySQL Installer is 32 bit, but will install both 32 bit and 64 bit binaries.」と記載されているように64bit環境の場合でもこのインストーラーを使用すればいいようです)．

次の画面でも少し下の方へスクロールしてから「Windows (x86, 32-bit), MSI Installer 5.7.16 385.2M」の右に表示されている「DownLoad」と書かれたリンクをクリックして下さい．(2つ表示されていますが，上の方はインターネットを経由して必要なファイルをダウンロードしつつインストールするものです)．

MySQL.com アカウントのログイン画面が表示されます．新規登録なども行えるようですが，今回はアカウントの登録は行わずにダウンロードのみ行います．画面下部にある「No thanks, just start my download.」と書かれたリンクをクリックして下さい．
ダウンロードが開始されます．任意の場所に保存しておいて下さい．ダウンロードはこれで完了です．

ダウンロードしたファイル名は「mysql-installer-community-5.7.16.0.msi」でインストールパッケージファイルとなっています．ダブルクリックして頂くとインストールが開始されます．最初はライセンスの確認です．
よく読んで頂き，同意できる場合に「I accept the license terms」の左側にあるチェックボックスをチェックして下さい．その後で「Next」をクリックして下さい．

セットアップタイプの選択です．いくつかの種類が用意されていますので利用する目的にあったものを選択して下さい．今回は「Developer Default」を選択しました．選択が終わりましたら「Next」をクリックして下さい．
あとは指示に従いインスト―ル完了です．


# Step2 利用マニュアル
論文4章「F-System」の実装欄にて記載
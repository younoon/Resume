<?php
//  HTTPヘッダーで文字コードを指定
header("Content-Type:text/html; charset=UTF-8");
?>
<?php
//  処理部

if($_POST==null){

}else {

    include("db_ini.php");

//mysqlサーバ接続
    $db_link = mysqli_connect($host, $user, $pass);
    if ($db_link == false) {
        print"MySQLサーバ接続に失敗しました。";
        exit;
    }

//charset指定
    mysqli_set_charset($db_link, "utf8");

//データベース接続
    $db_flg = mysqli_select_db($db_link, $db_name);

    if ($db_flg == false) {
        print"データベース接続に失敗しました。";
        exit;
    }

//投稿フォームから受け取り
    $strID = $_POST['chat_id'];
    $strTEXT = $_POST['chat_text'];

//strDateの取得
    $strDate = date('Y/m/d H:i:s');

//SQL文の実行
    $strSQL = "insert into chat2_tbl(chat_id,chat_kaiwa,item_date)";
    $strSQL .= " value('" . $strID . "','" . $strTEXT . "','" . $strDate . "')";
    //print $strSQL;

//SQL文を実行する
    $db_result = mysqli_query($db_link, $strSQL);

    if ($db_result == false) {
        print "致命的なエラー";
    }

// header()でリダイレクトするので
// どんな出力よりも先に行う。
///* 処理 */
    header("Location: {$_SERVER['PHP_SELF']}");


//mysqlサーバ切断
    mysqli_close($db_link);
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta http-equiv="content-script-type" content="text/javascript" />
    <meta http-equiv="content-style-type" content="text/css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/drw.css">

    <!--  StyleSheet記述
    <link rel="stylesheet" href="./css/main.css" type="text/css" media="all" />
    StyleSheet記述  -->
    <!-- PAGE TITLE -->
    <title>ページタイトル</title>
</head>
<body>

<input type="checkbox" class="check" id="checked">
<label class="menu-btn" for="checked">
    <span class="bar top"></span>
    <span class="bar middle"></span>
    <span class="bar bottom"></span>
    <span class="menu-btn__text">MENU</span>
</label>
<label class="close-menu" for="checked"></label>
<nav class="drawer-menu">
    <ul>
        <li><a href="index.html">HOME</a></li>
        <li><a href="#top">TOP</a></li>
        <li><a href="#toukou">Send Message</a></li>
    </ul>
</nav>
<div class="contents">
    <div class="contents__inner">
        <h1 id="top">ニュースちゃんねる</h1>

        <?php
//  表示部
include("db_ini.php");

//MySQLサーバ接続
$db_link_1=mysqli_connect($host,$user,$pass);

if($db_link_1==false){
    print"MySQLサーバ接続に失敗しました。";
    exit;
}

//charset指定
mysqli_set_charset($db_link_1,"utf8");

//データベース接続
$db_flg_1=mysqli_select_db($db_link_1,$db_name);

if($db_flg_1==false){
    print"データベース接続に失敗しました。";
    exit;
}

//SQL文の作成
$strSQL_1="select * from chat2_tbl";

//SQL文の実行
$db_result_1=mysqli_query($db_link_1,$strSQL_1);

//取得したデータ件数を調べる
$db_cnt=mysqli_num_rows($db_result_1);


if($db_cnt==0){
    //データがない場合
    print"まだ書き込みはありません";
    print"<br>";
    print"一番初めに書き込んでみましょう";
}else{
    //データがある場合

    while ($db_row=mysqli_fetch_array($db_result_1)){
        print "<table class='table table-striped'>";
        //id
        print "ID:".$db_row["chat_id"]."<br>";
        //スレ内容
        print $db_row["chat_kaiwa"]."<br>";
        //投稿日時
        print $db_row["item_date"]."<br>";
        print "<br>";
        print"</table>";
    }

    mysqli_free_result($db_result_1);
}

//opacity文字を透明に
//MySQLサーバ切断
mysqli_close($db_link_1);




?>
        <hr>
        <form id="toukou" method="post" action="hew_2.php">
    <p>ID</p>
    <input type="text" name="chat_id" size="20" maxlength="16">
    <p>投稿内容</p>
    <textarea name="chat_text" rows="10" cols="50"></textarea>
    <br>
    <input type="submit" value="投稿する">
    <input type="reset" value="クリア">
</form>
    </div>
</div>

</body>
</html>


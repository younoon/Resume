<?php
//  HTTPヘッダーで文字コードを指定
header("Content-Type:text/html; charset=UTF-8");
?>
<?php
//  処理部

include ("db_ini.php");

    //mysqlサーバ接続
    $db_link = mysqli_connect($host,$user,$pass);

    if($db_link == false){
        print "接続に失敗しました。";
        exit;
    }

    //データベース接続
    $db_flg = mysqli_select_db($db_link,$db_name);

    if($db_flg == false){
        print "選択に失敗しました。";
        exit;
    }

    //charset指定
    mysqli_set_charset($db_link,"utf8");

    //作成依頼受取
    $strREQ=$_POST['chat_title_sakusei'];

    //SQL文作成
    $strSQL="insert into kueri_tbl(title)";
    $strSQL .="value('".$strREQ."')";

    //SQL文を実行する
    $db_result=mysqli_query($db_link,$strSQL);

    if(!$db_result){
        $msg="依頼に失敗しました";
    }else{
        $msg="依頼が完了しました";
        $msg_1="反映に最大3日ほどかかる場合があります";
    }

    mysqli_close($db_link);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta http-equiv="content-script-type" content="text/javascript" />
    <meta http-equiv="content-style-type" content="text/css" />
    <!--  StyleSheet記述
    <link rel="stylesheet" href="./css/main.css" type="text/css" media="all" />
    StyleSheet記述  -->
    <!-- PAGE TITLE -->
    <title>ページタイトル</title>
</head>
<body>
<?php
//  表示部
print "<p>".$msg."<p>";
print "<p><font size=1>".$msg_1."</font><p>";
?>
<a href="index.html">一覧へ戻る</a>
</body>
</html>

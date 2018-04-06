<!-- 545042　中山諒 -->
<html>
    <head>
       <meta charset="utf-8">
       <title>ブログ記事の投稿</title>
    </head>
     <body>
         <h1>ブログ記事の投稿</h1>
         <?php
            if (isset($_POST["title"]) && isset($_POST["contents"])) {
              if(!isset($_POST["password"]) || $_POST["password"]!='abc'){
                echo '<p>パスワードが違います</p>';
              }
              else{
             try{
               //タイムゾーンの指定
               ini_set("date.timezone", "Asia/Tokyo");
               //$timeへ成形した年月日および時刻データを格納
               $time=date("Y.m.d-H:i");
               //PDOクラスのオブジェクトの作成
               $dbh = new PDO('sqlite:blog.db',",");
               //実行するSQL文を$sqlに格納
               $sql='insert into posts(title,contents,date) values(?,?,?)';
               //prepareメソッドでSQL文の準備
               $sth = $dbh->prepare($sql);
               //prepareした$sthを実行　SQL文の？部に格納する変数を指定
               $sth->execute(array($_POST["title"],$_POST["contents"],$time));
               if ($sth) {
                 echo "記事１件を投稿しました";
               } else {
                 echo "記事１件の投稿に失敗しました";
               }	 
             }
             Catch (PDOException $e) {
               print "エラー!: " . $e->getMessage() . "<br/>";	 die();
             }
           }
           }
           $dbh = null;?>

               <p><a href="index.php">blog閲覧ページはこちら</a></p>
               <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                 <dl>
                   <dt>表題：</dt>
                   <dd><input type="text" name="title" size="60" /></dd>
                   <dt>本文：</dt>
                   <dd><textarea name="contents" rows="10" cols="60"></textarea></dd>
                   <dt>パスワード:</dt>
                   <dd><input type="password" name="password" size = "20"></dd>
                 </dl>
                 <input type="reset" value="リセット" />
                 <input type="submit" value="送信" />
               </form>
      </body>
</html>

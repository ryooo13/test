<html>
  <head>ヘッダー</head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <body>
      <h1>コメント投稿</h1>
      <?php

      try{
        $dbh = new PDO('sqlite:blog.db','','');//PDOクラスのオブジェクトの作成

        if  (isset($_POST["pid"]) && isset($_POST["contents"]) ){
          ini_set("date.timezone", "Asia/Tokyo");

          // $sql='select*from comments where pid = ?';

        //$timeへ成形した年月日および時刻データを格納
        $time=date("Y.m.d-H:i");
        //実行するSQL文を$sqlに格納
        $sql='insert into comments(pid,contents,date,name) values(?,?,?,?)';
        $sth = $dbh->prepare($sql);
        //prepareした$sthを実行　SQL文の？部に格納する変数を指定
        $sth->execute(array($_POST["pid"],$_POST["contents"],$time,$_POST["name"]));

        echo $_POST["name"];

          if ($sth) {
            echo "コメント１件を投稿しました";
          } else {
            echo "コメント１件の投稿に失敗しました";
            }
        }
        $dbh = null;

      }
    Catch(PDOException $e){
            print "エラー!: " . $e->getMessage() . "<br/>";
            die();
          }
          ?>
          <p><a href="index.php">blog閲覧ページはこちら</a></p>
          <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        </body>
</html>

<html>
<head>
  <p>
    545042<br>
    中山諒<br>
    コメントに対して削除機能を追加しました。
  </p>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta charset="utf-8">
  <title>中山諒のブログサイト</title>
</head>
<body>
  <h1>中山諒のブログ</h1>
  <p><a href="post.php">blog記事投稿ページはこちら</a></p>
  <hr/>
  <?php
  try{
    $dbh = new PDO('sqlite:blog.db','','');
    //PDOクラスのオブジェクトの作成
    $sth = $dbh->prepare("select * from posts order by date desc");
    //prepareメソッドでSQL文の準備
    $sth->execute();
    //準備したSQL文の実行

    while ($row = $sth->fetch()) {
      //テーブルの内容を１行ずつ処理
      $time = preg_split("/[\s.:-]+/",$row['date']);
      ?>

      <h3>
        <?php echo $row['title'] ?>
      </h3>
      <p>
        <?php echo $row['contents'] ?>
        <br>
        (<?php echo $time[0]."年".$time[1]."月". $time[2]."日 ".$time[3].":".$time[4] ?>)
      </p>

      <form action="edit.php" method="post">
        <p>
          <input type="submit" value="編集" >
          <input type="hidden" name="id" value="<?php echo $row['id'] ?>" >
        </p>
      </form>

      <form action="delete.php" method="post">
        <p>
          <input type="submit" value="削除" >
          パスワード:<input type="password" name="password" size="20" />
          <input type="hidden" name="id" value="<?php echo $row['id'] ?>" >
        </p>
      </form>

      <h3>コメント 　　　　名前</h3>

      <form action="comment.php" method="post">
        <p>
          <textarea name="contents" rows=“2" cols=“50"></textarea>
          <input type="hidden" name="pid" value="<?php echo $row['id'] ?>" />


          <!-- <textarea name="contents" rows=“2" cols=“50"></textarea> -->
          <textarea name="name" rows=“2" cols=“50"></textarea>
          <!-- <input type="name" name="name" /> -->
          <input type="submit" value="投稿" />

        </p>
      </form>



      <?php

      $sth2 = $dbh->prepare("select * from comments order by id desc");
      //prepareメソッドでSQL文の準備

      //準備したSQL文の実行
      $sth2->execute();

      while ($row2 = $sth2->fetch()) {
        if($row['id'] == $row2['pid']){

      $time = preg_split("/[\s.:-]+/",$row2['date']);
        ?>

        <p>
          <?php echo $row2['contents'] ?>
          <?php echo $row2['name'] ?>
          <br>
          (<?php echo $time[0]."年".$time[1]."月". $time[2]."日 ".$time[3].":".$time[4] ?>)
        </p>

        <form action="commentdelete.php" method="post">
          <p>
            <input type="submit" value="削除" >
            パスワード:<input type="password" name="password" size="20" />
            <input type="hidden" name="id" value="<?php echo $row2['id'] ?>" >
          </p>
        </form>

        <?php
      }
    }
        ?>
        <hr/>
        <?php
      }
      $dbh = null;
    } Catch (PDOException $e)
    {   print "エラー!: " . $e->getMessage() . "<br/>";   die();}
    ?>

  </body>
  </html>

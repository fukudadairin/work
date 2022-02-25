<!-- 
var_dump();
→これじゃないと配列の中身は見れない 

echo "<pre>";
echo "</pre>";
→これで配列の中身を開業

fetchAll()のPDO::FETCH_UNIQUEは、
DBの最初の列にある値で、それぞれの行毎に連番をふる

-->

<?php
require_once(dirname(__FILE__) . "/config/config.php");
require_once(dirname(__FILE__) . "/function.php");
session_start();

if(isset($_SESSION["user"]) == true){
  header("Location:/r40208/");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  // POST送信時

  // 1入植された値の取得
  $login_id = $_POST["login_id"];
  $login_password = $_POST["login_password"];

  // 2バリデーション
  $err = array();
  if (!$login_id) {
    $err["login_id"] = "ログインIDを入力";
  }
  if (!$login_password) {
    $err["login_password"] = "パスワードを入力";
  }
  if (empty($err)) {
    // 3BD接続
    $pdo  = connect_db();
    $sql = "SELECT * FROM user WHERE login_id = :login_id AND login_password = :login_password LIMIT 1";
    $stmt = $pdo->prepare($sql);
    // sql文で入力された値を使う準備
    $stmt->bindValue(":login_id", $login_id, PDO::PARAM_INT);
    $stmt->bindValue(":login_password", $login_password, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user) {
    // ログイン処理
      $_SESSION["user"] = $user;
      header("Location:/r40208/");

    } else {
    // homeに遷移

      $err["login_password"] = "正しいパスワードを入力";
    }
    

  }
} else {
  // 初回アクセス
  $login_id = "";
  $login_password = "";
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>勤怠管理</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="./reset.css">
  <link rel="stylesheet" href="./style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous" defer></script>

  <!-- <script src="./script.js" defer></script> -->
</head>

<body>
  <h1>勤怠管理</h1>
  <section class="login">
    <form class="login_from" method="post">
      <h2>Login</h2>
      <div class="mb-3 from-group">
        <input type="text" class="form-control <?php if (isset($err["login_id"])) {
                                                  echo "is-invalid";
                                                } ?>" placeholder="社員番号" name="login_id" value="<?= $login_id ?>">
        <div class="invalid-feedback">
          <?= $err["login_id"] ?>
        </div>
      </div>
      <div class="mb-3 from-group">
        <input type="password" class="form-control <?php if (isset($err["login_password"])) {
                                                      echo "is-invalid";
                                                    } ?>" placeholder="パスワード" name="login_password">
        <div class="invalid-feedback">
          <?= $err["login_password"] ?>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">ログイン</button>
    </form>
  </section>

</body>

</html>
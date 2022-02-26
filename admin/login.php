<?php
echo "<pre>";
require_once(dirname(__FILE__) . "/../config/config.php");
require_once(dirname(__FILE__) . "/../function.php");
session_start();

if (isset($_SESSION["admin"]) == true) {
  header("Location:/r40208/admin/user_list.php");
  exit;
}
$admin_login = "";
$admin_password = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  $admin_login = $_POST["admin_login"];
  $admin_password = $_POST["admin_password"];

  // DBの情報を取得
  // 入力情報とDBの情報を照合
  $pdo  = connect_db();
  $sql = "SELECT * FROM user WHERE login_id =:login_id AND login_password=:login_password AND auth_type=:auth_type limit 1";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(":login_id", (int)$admin_login, PDO::PARAM_INT);
  $stmt->bindValue(":login_password", $admin_password, PDO::PARAM_STR);
  $stmt->bindValue(":auth_type", 1, PDO::PARAM_STR);
  $stmt->execute();
  $admin_login = $stmt->fetch();
  $_SESSION["admin"] = $admin_login;
  $admin = $_SESSION["admin"];

  // 情報が一致したら「user_list.php」へ画面遷移
  if ($admin) {
    header("Location:/r40208/admin/user_list.php");
    exit;
  } else {
    $admin_err_password = "パスワードが間違ってます";
  }
}


echo "</pre>";
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>勤怠管理</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="../reset.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous" defer></script>
  <link rel="stylesheet" href="../style.css">
</head>

<body class="bg-success">
  <h1 class="text-white">勤怠管理</h1>
  <section class="login">
    <form class="login_from" method="POST">
      <h2 class="fs-2 mt-3 mb-4">Login</h2>
      <div class="mb-3">
        <input type="text" class="form-control" placeholder="社員番号" name="admin_login" value="<?= $admin_login ?>">
      </div>
      <div class="mb-3">
        <input type="password" class="form-control <?php if (isset($admin_err_password)) {
                                                      echo "is-invalid";
                                                    } ?>" placeholder="パスワード" name="admin_password">
        <div class="invalid-feedback">
          <?= $admin_err_password ?>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">ログイン</button>
    </form>
  </section>

</body>

</html>
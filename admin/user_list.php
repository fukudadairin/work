<?php
echo "<pre>";

require_once(dirname(__FILE__) . "/../config/config.php");
require_once(dirname(__FILE__) . "/../function.php");
session_start();


$pdo  = connect_db();
$sql = "SELECT id,login_id,name,login_password,auth_type FROM user ";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$admin_all_user = $stmt->fetchAll(PDO::FETCH_UNIQUE);
$_SESSION["admin_all_user"] = $admin_all_user;
$admin_all_user = $_SESSION["admin_all_user"];


$pdo  = connect_db();
$sql = "SELECT COUNT(*) FROM user";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$admin_listCount = $stmt->fetch();
$_SESSION["admin_listCount"] = $admin_listCount;
$admin_listCount = $_SESSION["admin_listCount"];
$admin_listCount = $admin_listCount["COUNT(*)"];

// 検証用
// var_dump($admin_all_user);
// var_dump($admin_all_user[$i]);
// var_dump($_SESSION);

echo "</pre>";

?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠管理</title>
    <link rel="stylesheet" href="../reset.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
</head>

<body class="bg-success">
    <h1 class="text-white">勤怠管理</h1>

    <section class="aaa">
        <form action="./index.php" class="admin_user_list">
            <h2>社員リスト</h2>
            <table class="table">
                <thead>
                    <tr class="bg-light">
                        <th scope="col" class="fw-bold text-center">社員番号</th>
                        <th scope="col" class="fw-bold text-center">社員名</th>
                        <th scope="col" class="fw-bold text-center">権限</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 1; $i <= $admin_listCount; $i++) : ?>
                        <?php

                        $admin_login_id = "";
                        $admin_login_name = "";
                        $admin_user = $admin_all_user[$i];

                        // $list = $admin_user["login_id"];
                        // echo "———————————————————";
                        // var_dump($admin_user);
                        ?>

                        <tr>
                            <th scope="row" class="text-center"><?= $admin_user["login_id"] ?></th>
                            <td class="text-center"><a href="/r40208/admin/user_result.php?login_id=<?= $admin_user["login_id"] ?>"><?= $admin_user["name"] ?></a></td>
                            <td class="text-center"><?php if ($admin_user["auth_type"] ==1) {
                                                        echo "管理者";
                                                    } else {
                                                        echo "社員";
                                                    } ?></td>
                        </tr>

                    <?php endfor; ?>

                </tbody>
            </table>


        </form>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="./script.js"></script>
</body>

</html>
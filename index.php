<!-- ログイン状態の確認 -->
<?php
echo "<pre>";

date_default_timezone_set('Asia/Tokyo');
require_once(dirname(__FILE__) . "/config/config.php");
require_once(dirname(__FILE__) . "/function.php");
session_start();

// 
$modal_time = date("n");
// jsで編集ボタンをクリックした日にち
$modal_target = "";

if (!isset($_SESSION["user"]) == true) {
    header("Location:/r40208/login.php");
    exit;
}

// 各種設定で必要
$session_user = $_SESSION["user"];
$pdo  = connect_db();
$modal_flag = true;

if (isset($_GET["m"])) {
    $yyyymm = $_GET["m"];
} else {
    $yyyymm = date('Y-m');
}

if ($yyyymm != date('Y-m')) {
    $modal_flag = false;
}

$day_count = date("t", strtotime($yyyymm));


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // echo "POST送信";
    // $_SERVER["REQUEST_METHOD"] 現在のページにアクセスする際に使用されたメソッド（GETやメソッド）

    $modal_start_time = $_POST["modal_start_time"];
    $modal_end_time = $_POST["modal_end_time"];
    $modal_break_time = $_POST["modal_break_time"];
    $modal_comment = $_POST["modal_comment"];
    // jsで編集ボタンをクリックした日にち
    $modal_target = $_POST["modal_target"];

    $sql = "SELECT date,login_id,start_time,end_time,break_time,comment FROM work WHERE login_id =:aa AND date=:date limit 1";
    $stmt = $pdo->prepare($sql); //どれを使うのかを決める→SELECT文：INSERT文：UPDATE文：DELETE文：
    $stmt->bindValue(":aa", (int)$session_user["id"], PDO::PARAM_INT);
    if ($modal_target === date("Y-m-d")) {
        $stmt->bindValue(":date", date("Y-m-d"), PDO::PARAM_STR);
    } else {
        $stmt->bindValue(":date", $modal_target, PDO::PARAM_STR);
    }
    $stmt->execute();
    $target = $stmt->fetch();
    // $target_comment = $target["comment"];

    // 
    // echo "target_comment";
    // var_dump($target_comment);
    // 


    if ($target) {
        // var_dump("UPDATE");
        $sql = "UPDATE work SET start_time =:start_time, end_time =:end_time, break_time =:break_time, comment =:comment WHERE login_id = :login_id AND date=:date";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":login_id", (int)$target["login_id"], PDO::PARAM_INT); // データベースに接続
        $stmt->bindValue(":date", $modal_target, PDO::PARAM_STR);
        $stmt->bindValue(':start_time', $modal_start_time, PDO::PARAM_STR);
        if ($modal_end_time === "") {
            $stmt->bindValue(":end_time", null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':end_time', $modal_end_time, PDO::PARAM_STR);
        };
        $stmt->bindValue(":break_time", $modal_break_time, PDO::PARAM_STR);
        $stmt->bindValue(":comment", $modal_comment, PDO::PARAM_STR);
        $stmt->execute(); // 実行



    } else {
        // var_dump("INSERT");
        $sql = "INSERT INTO work(login_id,date,start_time,end_time,break_time,comment)VALUES(:login_id,:date,:start_time,:end_time,:break_time,:comment)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':login_id', (int)$session_user['id'], PDO::PARAM_INT);
        if (empty($modal_target)) {
            $stmt->bindValue(":date", date("Y-m-d"), PDO::PARAM_STR);
        } else {
            $stmt->bindValue(':date', $modal_target, PDO::PARAM_STR);
        }
        if ($modal_start_time === "") {
            $stmt->bindValue(":start_time", null, PDO::PARAM_NULL);
            echo "<script>console.log( 'modal_start_timeのnull' );</script>";
        } else {
            $stmt->bindValue(':start_time', $modal_start_time, PDO::PARAM_STR);
            echo "<script>console.log( 'modal_start_time' );</script>";
        }
        if ($modal_end_time === "") {
            $stmt->bindValue(":end_time", null, PDO::PARAM_NULL);
            echo "<script>console.log( 'modal_end_timeのnull' );</script>";
        } else {
            $stmt->bindValue(':end_time', $modal_end_time, PDO::PARAM_STR);
            echo "<script>console.log( 'modal_end_time' );</script>";
        }
        $stmt->bindValue(':break_time', $modal_break_time, PDO::PARAM_STR);
        $stmt->bindValue(':comment', $modal_comment, PDO::PARAM_STR);
        $stmt->execute(); // 実行

    }
} else {
    // echo "GET送信";
}


// データベースから情報を引き抜いて一覧に表示

$sql = "SELECT date,id,start_time,end_time,break_time,comment FROM work WHERE login_id =:login_id AND DATE_FORMAT(date,'%Y-%m')=:date";
$stmt = $pdo->prepare($sql); //どれを使うのかを決める→SELECT文：INSERT文：UPDATE文：DELETE文：
$stmt->bindValue(":login_id", (int)$session_user["id"], PDO::PARAM_INT);
$stmt->bindValue(":date", $yyyymm, PDO::PARAM_STR);
$stmt->execute();
$work_list = $stmt->fetchAll(PDO::FETCH_UNIQUE);

// 今日の日報が登録されてなかったらモーダル表示
$sql = "SELECT date,id,start_time,end_time,break_time,comment FROM work WHERE login_id =:login_id AND DATE_FORMAT(date,'%Y-%m-%d')=:date limit 1";
$stmt = $pdo->prepare($sql); //どれを使うのかを決める→SELECT文：INSERT文：UPDATE文：DELETE文：
$stmt->bindValue(":login_id", (int)$session_user["id"], PDO::PARAM_INT);
$stmt->bindValue(":date", date('Y-m-d'), PDO::PARAM_STR);
$stmt->execute();
$today_work = $stmt->fetch();


if ($today_work) {
    $modal_start_time = $today_work["start_time"];
    $modal_end_time = $today_work["end_time"];
    $modal_break_time = $today_work["break_time"];
    $modal_comment = $today_work["comment"];

    if ($modal_start_time && $modal_end_time) {
        $modal_flag = false;
    }
} else {
    $modal_start_time = null;
    $modal_end_time = null;
    $modal_break_time = "01:00";
    $modal_comment = null;
}


// 検証パーツ

// var_dump($modal_start_time);
// var_dump($modal_end_time);
// var_dump($modal_break_time);
// var_dump($modal_comment);
// var_dump($modal_target);

// echo "jsonTest";
// $jsonTarget_comment = json_encode($target_comment); //JavaScriptに渡すためにjson_encodeを行う 
// 
// var_dump($jsonTarget_comment);
// 
echo "</pre>";
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠管理</title>
    <link rel="stylesheet" href="./reset.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <h1>勤怠管理</h1>

    <section class="target_month">
        <form action="./index.php" class="from">
            <h2>月別リスト</h2>
            <select class="form-select mb-3" aria-label="Default select example" name="m" onchange="submit(this.from)">
                <option value="<?= date("Y-m") ?>"><?= date("Y/m") ?></option>
                <?php for ($i = 1; $i <= 12; $i++) : ?>
                    <?php $target_yyyymm = strtotime("-{$i}months"); ?>

                    <option value="<?= date("Y-m", $target_yyyymm) ?>" <?php if (date("Y-m", $target_yyyymm) == $yyyymm) echo "selected"; ?>><?= date("Y/m", $target_yyyymm) ?></option>
                <?php endfor; ?>
            </select>

            <table class="table">
                <thead>
                    <tr class="bg-light">
                        <th scope="col" class="text-center fw-bold col-2">日付</th>
                        <th scope="col" class="text-center fw-bold col-2">出勤</th>
                        <th scope="col" class="text-center fw-bold col-2">退勤</th>
                        <th scope="col" class="text-center fw-bold col-2">休憩時間</th>
                        <th scope="col" class="text-center fw-bold col-4">勤務内容</th>
                        <th scope="col" class="text-center fw-bold col-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 1; $i <= $day_count; $i++) : ?>
                        <?php
                        $start_time = "";
                        $end_time = "";
                        $break_time = "";
                        $comment = "";

                        if (isset($work_list[date("Y-m-d", strtotime($yyyymm . "-" . $i))])) {

                            $work = $work_list[date("Y-m-d", strtotime($yyyymm . "-" . $i))];
                            if ($work["start_time"]) {
                                // ??はnull合体演算子と呼ばれている。これはnullかどうかを確認することができる。
                                $start_time = date("H:i", strtotime($work["start_time"]));
                            }
                            if ($work["end_time"]) {
                                $end_time = date("H:i", strtotime($work["end_time"]));
                            }
                            if ($work["break_time"]) {
                                $break_time = date("H:i", strtotime($work["break_time"]));
                            }
                            if ($work["comment"]) {
                                // $comment = mb_strimwidth($work["comment"], 0, 30, "..");
                                // 日本語を含むマルチバイト文字は2文字としてカウントされますので、「10」で指定した場合「…」分を引いた「8」で丸められ、全てマルチバイト文字なので4文字分の「こんにち」が丸められていることになります。
                                $comment = $work["comment"];
                            }
                        }
                        ?>

                        <tr>
                            <th class="text-center" scope="row"><?= time_format_dw($yyyymm . "-" . $i) ?></th>
                            <td class="text-center"><?= $start_time ?></td>
                            <td class="text-center"><?= $end_time ?></td>
                            <td class="text-center"><?= $break_time ?></td>
                            <td class="with-max px-4"><?= $comment ?></td>
                            <td><button type="button" class="btn py-0" data-bs-toggle="modal" data-bs-target="#inputModal" data-day="<?= $yyyymm . "-" . $i ?> " data-target_month="<?= $modal_time ?>/">●</button></td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </form>

        <!-- Modal -->
        <form method="POST" class="modal_from">
            <div class="modal fade" id="inputModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <p></p>
                            <h5 class="modal-title text-center fw-bold" id="exampleModalLongTitle">勤怠入力</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                        </div>
                        <div id="modal_day" class="alert alert-primary" role="alert">
                            <?= date("n") . "/" . time_format_dw(date("Y-m-d")) ?>
                        </div>

                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group">
                                            <input id="modal_start_time" type="text" class="form-control" placeholder="出勤" aria-label="出勤" aria-describedby="basic-addon1" name="modal_start_time" value="<?php if ($modal_start_time) {
                                                                                                                                                                                                                echo date("H:i", strtotime($modal_start_time));
                                                                                                                                                                                                            } ?>">
                                            <button type="button" class="input-group-text start_btn">打刻</button>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group">
                                            <input id="modal_end_time" type="text" class="form-control" placeholder="退勤" aria-label="退勤" aria-describedby="basic-addon1" name="modal_end_time" value="<?php if ($modal_end_time) {
                                                                                                                                                                                                            echo date("H:i", strtotime($modal_end_time));
                                                                                                                                                                                                        } else {

                                                                                                                                                                                                            echo $modal_end_time;
                                                                                                                                                                                                        } ?>">
                                            <button type="button" class="input-group-text end_btn">打刻</button>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="休憩時間" aria-label="休憩時間" aria-describedby="basic-addon1" name="modal_break_time" value="<?php if ($modal_break_time) {
                                                                                                                                                                                            echo date("G:i", strtotime($modal_break_time));
                                                                                                                                                                                        } else {

                                                                                                                                                                                            echo $modal_break_time;
                                                                                                                                                                                        } ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="my-3">
                                    <textarea class="form-control" id="modal_comment" rows="3" placeholder="業務内容" aria-label="業務内容" name="modal_comment"><?= $modal_comment ?></textarea>
                                </div>
                            </div>
                            <input type="hidden" id="modal_target" name="modal_target">
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">登録</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="./script.js"></script>
    <script>
        <?php if ($modal_flag) {  ?>
            var inputModal = new bootstrap.Modal(document.getElementById("inputModal"));
            inputModal.toggle();
        <?php  }; ?>


        // var sample = JSON.parse(''); 
        //jsonをparseしてJavaScriptの変数に代入
        // console.log(sample, "sample");

        $("#inputModal").on("show.bs.modal", function(event) {
            // show.bs.modal：モーダル・ダイアログを開くshowメソッドを呼び出した時のイベント。
            var button = $(event.relatedTarget);
            var target_day = button.data("day");
            console.log(target_day);

            var day = button.closest("tr").children("th")[0].innerText;
            var target_month = button.data("target_month");
            // console.log(day); 
            // console.log(target_month); 

            var start_time = button.closest("tr").children("td")[0].innerText
            var end_time = button.closest("tr").children("td")[1].innerText
            var break_time = button.closest("tr").children("td")[2].innerText
            var comment = button.closest("tr").children("td")[3].innerText
            // console.log(start_time); 
            // console.log(comment); 

            var comment = button.closest("tr").children("td")[3].innerText

            $("#modal_day").text(target_month + day)
            $("#modal_target").val(target_day)
            $("#modal_start_time").val(start_time)
            $("#modal_end_time").val(end_time)
            $("#modal_break_time").val(break_time)
            $("#modal_comment").val(comment)
            // $("#modal_comment").val(sample)
            $("#target_date").val(target_day)

            // $("#modal_start_time").removeClass("is-invalid")
            // $("#modal_end_time").removeClass("is-invalid")
            // $("#modal_break_time").removeClass("is-invalid")
            // $("#modal_comment").removeClass("is-invalid")

        });
    </script>
</body>

</html>
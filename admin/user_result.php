<?php
echo "<pre>";

require_once(dirname(__FILE__) . "/../config/config.php");
require_once(dirname(__FILE__) . "/../function.php");
session_start();
$pdo  = connect_db();

$admin_loginID = $_GET["login_id"];


if (isset($_GET["m"])) {
    $select_month = $_GET["m"];
} else {
    $select_month = date('Y-m');
}

var_dump($admin_loginID);
var_dump($select_month);


$sql = "SELECT date,id,start_time,end_time,break_time,comment FROM work WHERE login_id =:login_id AND DATE_FORMAT(date,'%Y-%m')=:date";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":login_id", (int)$admin_loginID, PDO::PARAM_INT);
$stmt->bindValue(":date", $select_month, PDO::PARAM_STR);
$stmt->execute();
$work_list = $stmt->fetchAll(PDO::FETCH_UNIQUE);
// var_dump($work_list);

$day_count = date("t", strtotime($select_month));

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
        <form class="from" name="m">
            <h2>月別リスト</h2>
            <select class="form-select mb-3" aria-label="Default select example" name="m" onchange="submit(this.from)">
                <option value="<?= date("Y-m") ?>"><?= date("Y/m") ?></option>
                <?php
                for ($i = 1; $i < 7; $i++) :
                    $old_month = "-{$i}month";
                ?>
                    <option value="<?= date("Y-m", strtotime($old_month)) ?>" <?php if($select_month ==date("Y-m", strtotime($old_month))) echo "selected"; ?>><?= date("Y/m", strtotime($old_month)) ?></option>
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
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i=1; $i <= $day_count; $i++) : ?>
                        <?php
                        $start_time = "";
                        $end_time = "";
                        $break_time = "";
                        $comment = "";
                        if (isset($work_list[date("Y-m-d", strtotime($select_month . "-" . $i))])) {
                            $work = $work_list[date("Y-m-d", strtotime($select_month . "-" . $i))];
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
                                // 日本語を含むマルチバイト文字は2文字としてカウントされますので、「10」で指定した場合「…」分を引いた「8」で丸められ、全てマルチバイト文字なので4文字分の「こんにち」が丸められていることになります。
                                $comment = $work["comment"];
                            }
                        }
                        ?>

                        <tr>
                            <th class="text-center" scope="row"><?= time_format_dw($select_month . "-" . $i) ?></th>
                            <td class="text-center"><?= $start_time ?></td>
                            <td class="text-center"><?= $end_time ?></td>
                            <td class="text-center"><?= $break_time ?></td>
                            <td class="with-max px-4"><?= $comment ?></td>
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
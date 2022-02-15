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
        <form action="./index.php" class="from">
            <h2>月別リスト</h2>
            <select class="form-select mb-3" aria-label="Default select example">
                <option value="2022年1月" selected>2022年2月</option>
                <option value="2022年1月" selected>2022年2月</option>
                <option value="2022年1月" selected>2022年2月</option>
            </select>
            <table class="table">
                <thead>
                    <tr class="bg-light">
                        <th scope="col" class="fw-bold">日付</th>
                        <th scope="col" class="fw-bold">出勤</th>
                        <th scope="col" class="fw-bold">退勤</th>
                        <th scope="col" class="fw-bold">休憩時間</th>
                        <th scope="col" class="fw-bold">勤務内容</th>
                        <th scope="col" class="fw-bold"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">12日</th>
                        <td>9：00</td>
                        <td>18：00</td>
                        <td>1：00</td>
                        <td>＝＝＝＝＝＝＝</td>
                        <td><button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModalLong">●</button></td>
                        <!-- モーダルの設定 -->
                        <div class="modal fade" id="exampleModalLong" tabindex="-1" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <p></p>
                                        <h5 class="modal-title text-center fw-bold" id="exampleModalLongTitle">勤怠入力</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                                    </div>
                                    <div class="alert alert-primary" role="alert">
                                        2月11日（水）
                                    </div>
                                    <div class="modal-body">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="出勤" aria-label="出勤" aria-describedby="basic-addon1" value="">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="退勤" aria-label="退勤" aria-describedby="basic-addon1" value="">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="休憩時間" aria-label="休憩時間" aria-describedby="basic-addon1" value="1：00">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="my-3">
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="業務内容" aria-label="業務内容"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary">修正</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                </tbody>
            </table>


        </form>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="./script.js"></script>
</body>

</html>
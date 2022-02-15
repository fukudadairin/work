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
        <form class="login_from" action="./user_list.php">
            <h2 class="fs-2 mt-3 mb-4">Login</h2>
            <div class="mb-3">
              <input type="email" class="form-control" placeholder="社員番号">
            </div>
            <div class="mb-3">
              <input type="password" class="form-control" placeholder="パスワード">
            </div>
            <button type="submit" class="btn btn-primary">ログイン</button>
          </form>
    </section>
    
</body>
</html>
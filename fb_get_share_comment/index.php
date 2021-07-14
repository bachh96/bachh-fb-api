<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <title>Đếm comment & share bài viết Facebook</title>
</head>
<body>
    <div class="wrapper">
        <h2 class="text-center">Đếm comment & share bài viết Facebook</h2>
        <h3>Nhập link bài viết có dạng: <span>https://www.facebook.com/topcomments.vn/posts/3712936208964487</span></h3>
        <form action="result.php" method="post">
            <p><input type="text" name="url[]" placeholder="Nhập URL bài viết" class="form-control"></p>
            <p><input type="text" name="url[]" placeholder="Nhập URL bài viết" class="form-control"></p>
            <p><input type="text" name="url[]" placeholder="Nhập URL bài viết" class="form-control"></p>
            <p><input type="text" name="url[]" placeholder="Nhập URL bài viết" class="form-control"></p>
            <p><input type="text" name="url[]" placeholder="Nhập URL bài viết" class="form-control"></p>
            <p>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="allcomment" name="allcomment" value="yes">
                    <label class="form-check-label" for="allcomment">
                        Bao gồm bình luận trả lời
                    </label>
                </div>
            </p>
            <p><button type="submit" class="btn btn-warning">Lấy dữ liệu</button></p>
        </form>
    </div>
</body>
</html>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" href="https://hoangbach96.com/wp-content/themes/bachh_vue/favicon.png" type="image/gif" sizes="16x16">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <title>Đếm comment & share bài viết Facebook</title>
</head>
<body>
    <div class="wrapper">
        <h2 class="text-center">Lấy tất cả comment của bài viết Facebook</h2>
        <p class="text-center base-fb">(Dựa trên Facebook Graph API Version 11.0)</p>
        <h3>Nhập link bài viết có dạng: <span>https://www.facebook.com/topcomments.vn/posts/3712936208964487</span></h3>
        <form action="result.php" method="post">
            <p>
                <input type="text" name="accesstoken" placeholder="Nhập Access Token (có thể bỏ qua)" class="form-control">
                <span style="font-size: 12px;">Truy cập: <a href="https://m.facebook.com/composer/ocelot/async_loader/?publisher=feed" target="_blank">https://m.facebook.com/composer/ocelot/async_loader/?publisher=feed</a> -> tìm kiếm "EAA" -> copy chuỗi và dán vào đây.</span>
            </p>
            <p><input type="text" name="url" placeholder="Nhập URL bài viết" class="form-control"></p>
            <p>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="allcomment" name="allcomment" value="yes">
                    <label class="form-check-label" for="allcomment">
                        Bao gồm bình luận trả lời
                    </label>
                </div>
            </p>
            <p>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="exportexcel" name="exportexcel" value="yes">
                <label class="form-check-label" for="exportexcel">
                    Tạo file Excel
                </label>
            </div>
            </p>
            <input type="hidden" name="timestamp" value="<?php echo time(); ?>">
            <p><button type="submit" class="btn btn-warning">Lấy dữ liệu</button></p>
        </form>

        <a href="/fb_get_share_comment" style="display: block">Tool đếm comment, share, bày tỏ cảm xúc bài viết FB</a>
        <a href="/fb_get_all_comment" style="display: block">Tool lấy comment bài viết FB</a>

        <p class="copy-right text-center">© <a href="https://hoangbach96.com/">Hoang Bach</a>. All rights reserved.</p>
    </div>
</body>
</html>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <title>Kết quả</title>
</head>
<body>
    <div class="wrapper">
        <table class="table table-sm table-bordered table-success table-striped">
            <thead>
            <tr>
                <th scope="col">URL</th>
                <th scope="col">Tổng số comment</th>
                <th scope="col">Tổng lượt share</th>
            </tr>
            </thead>
            <tbody>
            <?php
                $accessToken = "EAAAAZAw4FxQIBAC8LlrIC39B5FrArpZACBNRvxCnRjZCqpgzjgKOsjzMa0E9GTBavoZCv2RWiZBtx28HVdHzRmJDNbNSdVmhvpfI2O8V9ZA8W82LQDUAoM87ZAjCXy62jUI0bbKHPp9TFER3cpNZBXfZCPiDzNq5RMIfcz4KwqFiYqAIZAEzYBRGAYuRjiI2Ym8q0ZD";
                $allUrl = $_POST["url"];

                foreach ($allUrl as $item) :
                    if(!empty($item)) :
                    // lấy id group theo url
                    $url = $item;
                    $urlArr = explode("/posts/",$url);
                    $groupApi = "https://graph.facebook.com/v11.0?id=". $urlArr[0] . "&access_token=".$accessToken."";
                    $array = json_decode(file_get_contents($groupApi), true);
                    $groupId = $array['id'];
                    // lấy id bài viết
                    $postId = $urlArr[1];

                    if(isset($_POST["allcomment"]) && $_POST["allcomment"] === "yes") {
                        $filter = "stream";
                    } else {
                        $filter = "toplevel";
                    }

                    $commentApi = "https://graph.facebook.com/v11.0/".$groupId."_".$postId."/comments?summary=1&filter=$filter&access_token=$accessToken";
                    $commentResponse = json_decode(file_get_contents($commentApi), true);

                    $shareApi = "https://graph.facebook.com/v11.0/".$groupId."_".$postId."?fields=shares&access_token=$accessToken";
                    $shareResponse = json_decode(file_get_contents($shareApi), true);
            ?>
            <tr>
                <th scope="row"><?php echo $item; ?></th>
                <td class="color-red"><?php echo $commentResponse['summary']['total_count']; ?></td>
                <td class="color-red"><?php echo $shareResponse['shares']['count']?></td>
            </tr>
            <?php
                endif;
            endforeach; ?>
            </tbody>
        </table>
        <a href="index.php">Trở về trang chủ</a>
    </div>
</body>
</html>

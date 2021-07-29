<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" href="https://hoangbach96.com/wp-content/themes/bachh_vue/favicon.png" type="image/gif" sizes="16x16">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="style.css">

    <title>Kết quả</title>
</head>
<body>
    <div class="wrapper">
        <table id="mainTable" class="cell-border" style="width:100%">
            <thead>
            <tr>
                <th>URL</th>
                <th>Comment</th>
                <th>Comment có chứa text</th>
                <th>Share</th>
                <th>Reaction</th>
                <th>👍</th>
                <th>❤</th>
                <th>😲</th>
                <th>😆</th>
                <th>😢</th>
                <th>😠</th>
            </tr>
            </thead>
            <tbody>
            <?php
                $allUrl = [];

                if (isset($_FILES['csvfile']) && !empty($_FILES['csvfile']['tmp_name']))
                {
                    $handle = fopen($_FILES['csvfile']['tmp_name'], "r");
                    while (($line = fgetcsv($handle)) !== FALSE)
                    {
                        $allUrl[] = $line[0];
                    }
                    fclose($handle);
                } else {
                    $allUrl = $_POST['url'];
                }

                if(isset($_POST["allcomment"]) && $_POST["allcomment"] === "yes") {
                    $filter = "stream";
                } else {
                    $filter = "toplevel";
                }

                $limit = 2000;

                if(isset($_POST['accesstoken']) && !empty($_POST['accesstoken'])) {
                    $accessToken = $_POST['accesstoken'];
                } else {
                    $accessToken = "EAAAAZAw4FxQIBALiZCXZCflf8jh26G3a6ZABxIGK5jCfhTc7rUZAq4eegsgJ2fpJ9SWPT92XiRj6HUf2QZAzOURMTMIkPE7x5ZB342OydaZCTmuGVRUwSnaOYm2uC7BZAu3qGKnClbW8FlrnUNNu6ZBt1PTZB3uBmB40ZBZANrz7ZAeiTM3ORZCsKP8Sn7l4mzdP8FJuG0ZD";
                }

                function getAllComment($groupId, $postId, $after, $list = array()) {
                    global $list, $filter, $limit, $accessToken;
                    if($after != '') {
                        $commentApi = "https://graph.facebook.com/v11.0/".$groupId."_".$postId."/comments?summary=1&filter=$filter&limit=$limit&after=$after&access_token=$accessToken";
                    } else {
                        $commentApi = "https://graph.facebook.com/v11.0/".$groupId."_".$postId."/comments?summary=1&filter=$filter&limit=$limit&access_token=$accessToken";
                    }
                    $commentResponse = json_decode(file_get_contents($commentApi), true);
                    $list[] = $commentResponse['data'];
                    if(isset($commentResponse['paging']['cursors']['after'])) {
                        $next = $commentResponse['paging']['cursors']['after'];
                        getAllComment($groupId, $postId, $next, $list);
                    }

                    return $list;
                }

                foreach ($allUrl as $url) :
                    if(!empty($url)) :
                    // lấy id group theo url
                    $urlArr = explode("/posts/",$url);
                    $groupApi = "https://graph.facebook.com/v11.0?id=". preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $urlArr[0]) . "&access_token=".$accessToken."";
                    $array = json_decode(file_get_contents($groupApi), true);
                    $groupId = $array['id'];
                    // lấy id bài viết
                    $postId = $urlArr[1];

                    if(isset($_POST["countcomment"]) && $_POST["countcomment"] === "yes") {
                        $commentApi = "https://graph.facebook.com/v11.0/".$groupId."_".$postId."/comments?summary=1&filter=$filter&limit=1&access_token=$accessToken";
                        $commentResponse = json_decode(file_get_contents($commentApi), true);

                        $allCommentData = getAllComment($groupId, $postId, '');
                        $commentHasTextNum = 0;
                        foreach ($allCommentData as $item2) {
                            foreach ($item2 as $comment) {
                                if(preg_match('/[a-zA-Z0-9]/',$comment['message'])) {
                                    $commentHasTextNum++;
                                }
                            }
                        }
                    }

                    if(isset($_POST["countshare"]) && $_POST["countshare"] === "yes") {
                        $shareApi = "https://graph.facebook.com/v11.0/".$groupId."_".$postId."?fields=shares&access_token=$accessToken";
                        $shareResponse = json_decode(file_get_contents($shareApi), true);
                    }

                    if(isset($_POST["countlike"]) && $_POST["countlike"] === "yes") {
                        $likeApi = "https://graph.facebook.com/v11.0/".$groupId."_".$postId."?fields=likes.summary(true)&access_token=$accessToken";
                        $likeResponse = json_decode(file_get_contents($likeApi), true);
                    }

                    if(isset($_POST["countreaction"]) && $_POST["countreaction"] === "yes") {
                        $reactionApi = "https://graph.facebook.com/v11.0/".$groupId."_".$postId."?fields=reactions.summary(total_count)&access_token=$accessToken";
                        $reactionResponse = json_decode(file_get_contents($reactionApi), true);

                        $loveApi = "https://graph.facebook.com/v11.0/".$groupId."_".$postId."?fields=reactions.type(LOVE).limit(0).summary(total_count)&access_token=$accessToken";
                        $loveResponse = json_decode(file_get_contents($loveApi), true);

                        $wowApi = "https://graph.facebook.com/v11.0/".$groupId."_".$postId."?fields=reactions.type(WOW).limit(0).summary(total_count)&access_token=$accessToken";
                        $wowResponse = json_decode(file_get_contents($wowApi), true);

                        $hahaApi = "https://graph.facebook.com/v11.0/".$groupId."_".$postId."?fields=reactions.type(HAHA).limit(0).summary(total_count)&access_token=$accessToken";
                        $hahaResponse = json_decode(file_get_contents($hahaApi), true);

                        $sadApi = "https://graph.facebook.com/v11.0/".$groupId."_".$postId."?fields=reactions.type(SAD).limit(0).summary(total_count)&access_token=$accessToken";
                        $sadResponse = json_decode(file_get_contents($sadApi), true);

                        $angryApi = "https://graph.facebook.com/v11.0/".$groupId."_".$postId."?fields=reactions.type(ANGRY).limit(0).summary(total_count)&access_token=$accessToken";
                        $angryResponse = json_decode(file_get_contents($angryApi), true);
                    }
            ?>
            <tr>
                <td scope="row" style="font-weight: 400;"><?php echo $url; ?></td>
                <td class="color-blue"><?php if(isset($commentResponse)) echo $commentResponse['summary']['total_count']; ?></td>
                <td class="color-blue"><?php if(isset($commentHasTextNum)) echo $commentHasTextNum; ?></td>
                <td class="color-blue"><?php if(isset($shareResponse)) echo $shareResponse['shares']['count']?></td>
                <td class="color-blue"><?php if(isset($reactionResponse)) echo $reactionResponse['reactions']['summary']['total_count']; ?></td>
                <td class="color-blue"><?php if(isset($likeResponse)) echo $likeResponse['likes']['summary']['total_count']; ?></td>
                <td class="color-blue"><?php if(isset($loveResponse)) echo $loveResponse['reactions']['summary']['total_count']; ?></td>
                <td class="color-blue"><?php if(isset($wowResponse)) echo $wowResponse['reactions']['summary']['total_count']; ?></td>
                <td class="color-blue"><?php if(isset($hahaResponse)) echo $hahaResponse['reactions']['summary']['total_count']; ?></td>
                <td class="color-blue"><?php if(isset($sadResponse)) echo $sadResponse['reactions']['summary']['total_count']; ?></td>
                <td class="color-blue"><?php if(isset($angryResponse)) echo $angryResponse['reactions']['summary']['total_count']; ?></td>
            </tr>
            <?php
                endif;
            endforeach; ?>
            </tbody>
        </table>

        <a href="/fb_get_share_comment" style="display: block">Tool đếm comment, share, bày tỏ cảm xúc bài viết FB</a>
        <a href="/fb_get_all_comment" style="display: block">Tool lấy comment bài viết FB</a>

        <a href="index.php" style="display: block; color: darkred">Trở về trang chủ</a>

        <p class="copy-right text-center">© <a href="https://hoangbach96.com/">Hoang Bach</a>. All rights reserved.</p>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#mainTable').DataTable();
        });
    </script>
</body>
</html>

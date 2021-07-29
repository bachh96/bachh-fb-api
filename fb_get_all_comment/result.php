<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" href="https://hoangbach96.com/wp-content/themes/bachh_vue/favicon.png" type="image/gif" sizes="16x16">

    <link href="assets/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="assets/jquery.dataTables.min.css">

    <link rel="stylesheet" href="style.css">

    <title>Kết quả</title>
</head>
<body>
    <div class="wrapper">
        <table id="mainTable" class="cell-border" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Message</th>
            </tr>
            </thead>
            <tbody>
            <?php
                require 'vendor/autoload.php';

                use PhpOffice\PhpSpreadsheet\Spreadsheet;
                use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', 'ID');
                $sheet->setCellValue('B1', 'Message');
                $rowCount = 2;

                // get all comment
                if(isset($_POST['accesstoken']) && !empty($_POST['accesstoken'])) {
                    $accessToken = $_POST['accesstoken'];
                } else {
                    $accessToken = "EAAAAZAw4FxQIBALiZCXZCflf8jh26G3a6ZABxIGK5jCfhTc7rUZAq4eegsgJ2fpJ9SWPT92XiRj6HUf2QZAzOURMTMIkPE7x5ZB342OydaZCTmuGVRUwSnaOYm2uC7BZAu3qGKnClbW8FlrnUNNu6ZBt1PTZB3uBmB40ZBZANrz7ZAeiTM3ORZCsKP8Sn7l4mzdP8FJuG0ZD";
                }

                if(!empty($_POST["url"])) :
                    // lấy id group theo url
                    $url = $_POST["url"];
                    $urlArr = explode("/posts/",$url);
                    $groupApi = "https://graph.facebook.com/v11.0?id=". $urlArr[0] . "&access_token=".$accessToken."";
                    $array = json_decode(file_get_contents($groupApi), true);
                    $groupId = $array['id'];
                    // lấy id bài viết
                    $postId = $urlArr[1];

                    $limit = 2000;

                    if(isset($_POST["allcomment"]) && $_POST["allcomment"] === "yes") {
                        $filter = "stream";
                    } else {
                        $filter = "toplevel";
                    }

                    function getAllComment($after, $list = array()) {
                        global $list, $groupId, $postId, $filter, $limit, $accessToken;
                        if($after != '') {
                            $commentApi = "https://graph.facebook.com/v11.0/".$groupId."_".$postId."/comments?summary=1&filter=$filter&limit=$limit&after=$after&access_token=$accessToken";
                        } else {
                            $commentApi = "https://graph.facebook.com/v11.0/".$groupId."_".$postId."/comments?summary=1&filter=$filter&limit=$limit&access_token=$accessToken";
                        }
                        $commentResponse = json_decode(file_get_contents($commentApi), true);
                        $list[] = $commentResponse['data'];
                        if(isset($commentResponse['paging']['cursors']['after'])) {
                            $next = $commentResponse['paging']['cursors']['after'];
                            getAllComment($next, $list);
                        }

                        return $list;
                    }

                    $data = getAllComment('');
                    
                    foreach ($data as $item) :
                        foreach ($item as $comment) :
                            if(!empty($comment['message'])) :
                                $sheet->setCellValue('A' . $rowCount, $comment['id']);
                                $sheet->setCellValue('B' . $rowCount, "\"" . $comment['message'] . "\"");
                                $rowCount++;
            ?>
                <tr>
                    <td scope="row" style="font-weight: 400;"><?php echo $comment['id']; ?></td>
                    <td class="color-blue"><?php echo $comment['message']; ?></td>
                </tr>
            <?php
                            endif;
                        endforeach;
                    endforeach;
                endif;
            ?>
            </tbody>
        </table>
        <?php if(isset($_POST["exportexcel"]) && $_POST["exportexcel"] === "yes") : ?>
            <button class="download-excel btn btn-success">Download Excel File</button>
        <?php endif; ?>

        <a href="/fb_get_share_comment" style="display: block">Tool đếm comment, share, bày tỏ cảm xúc bài viết FB</a>
        <a href="/fb_get_all_comment" style="display: block">Tool lấy comment bài viết FB</a>

        <a href="index.php" style="display: block; color: darkred">Trở về trang chủ</a>

        <p class="copy-right text-center">© <a href="https://hoangbach96.com/">Hoang Bach</a>. All rights reserved.</p>
    </div>
    <?php
        $writer = new Xlsx($spreadsheet);
        if(isset($_POST["exportexcel"]) && $_POST["exportexcel"] === "yes") :
            $writer->save('comments_' . $_POST['timestamp'] . '.xlsx');
        endif;
    ?>
    <script src="assets/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="assets/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#mainTable').DataTable();

            $('.download-excel').click(function(e) {
                e.preventDefault();
                window.location.href = "<?php echo 'comments_'.$_POST['timestamp'].'.xlsx'; ?>";
            });

        });
    </script>
</body>
</html>

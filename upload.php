<?php

session_start();

require_once('assets/config.php');
require_once('assets/functions.php');

if ($_FILES['image']['error'] != UPLOAD_ERR_OK) {
    echo "エラーが発生しました : ".$_FILES['image']['error'];
    exit;
}

$imagesize = getimagesize($_FILES['image']['tmp_name']);


switch($imagesize['mime']) {
    case 'image/gif':
        $ext = '.gif';
        break;
    case 'image/jpeg':
        $ext = '.jpg';
        break;
    case 'image/png':
        $ext = '.png';
        break;
    default:
    echo "GIF/JPEG/PNG only";
    exit;
}

// ただのファイル名
$imageFileName = sha1(time().mt_rand()) . $ext;

// move_uploaded_fileするための変数
$imageFilePath = IMAGES_DIR . '/' . $imageFileName;

$image_path = 'assets/images/users/' . $imageFileName;

$rs = move_uploaded_file($_FILES['image']['tmp_name'], $imageFilePath);
if (!$rs) {
    echo "アップロードできません！";
}
// var_dump($imageFilePath);


$dbh = connectDb();

$sql = "update users set
        image = :image,
        modified = now()
        where id = :id";
$stmt = $dbh->prepare($sql);
$params = array(
    ":image" => $image_path,
    ":id" => $_SESSION['me']['id']
);
$stmt->execute($params);

// ログイン中のIDを取ってきてるかを確認 → とれてる！
// var_dump($_SESSION['me']['id']);

header('Location: '.SITE_URL.'mypage.php');
exit;


 // enctype="multipart/form-data"はファイルをそのまま送信できる指定方法
 // Postでしかファイルは投稿されない
 // アップロードされたファイルはグローバル変数$_FILESで渡される → $_FILES['image']のように指定する（inputのnameの値がインデックスに来る）
 // 連想配列の中身は「name」「type」「tmp_name」「error」「size」のようにあらかじめ決まっている
 // tmp_nameとは一時的にアップロードされたファイル名のこと 
 // ファイルアップロードはまず最初にtmpディレクトリにtmp_nameとして保存される
 // そのファイルを適切な場所に移動するファンクションがmove_uploaded_fileとなる
 // ブール値＝move_uploaded_file([コピー元][コピー先]);
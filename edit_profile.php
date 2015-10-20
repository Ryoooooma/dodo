<?php

session_start();

require_once('assets/config.php');
require_once('assets/functions.php');

// ログインしてなかったら、ログインページにとばす
if (empty($_SESSION['me'])) {
    header('Location:' .SITE_URL.'login.php');
}

$me = $_SESSION['me'];
$id = $me['id'];

$dbh = connectDb();
$sql = "select * from users where id = $id limit 1";
$stmt = $dbh->query($sql);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] = "POST") {

    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $ocupation = $_POST['ocupation'];
    $introduction = $_POST['introduction'];

    $error = array();

    // エラー処理
    if ($user_name == '') {
        $error['user_name'] = 'NOT EMPTY';
    }
    if ($email == '') {
        $error['email'] = 'NOT EMPTY';
    }

    if (empty($error)) {

        $sql = "update users set
                user_name = :user_name,
                email = :email,
                ocupation = :ocupation,
                introduction = :introduction,
                modified = now()
                where id = :id";
        $stmt = $dbh->prepare($sql);
        $params = array(
            ":user_name" => $user_name,
            ":email" => $email,
            ":ocupation" => $ocupation,
            ":introduction" => $introduction,
            ":id" => $id
        );
        $stmt->execute($params);

        header('Location: '.SITE_URL.'mypage.php');
        exit;
    }
}

?>

<html lang="ja">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
        <title>EDIT PROFILE</title>
    </head>
    <body>
        <div id="form-main">
            <div id="form-div">
            <h2 style="color:white; text-align:center;">Edit your profile</h2>
            <form method="POST" class="form" id="form1">
                <p class="name">
                    <input name="user_name" type="text" class="validate[required,custom[onlyLetter],length[0,100]] feedback-input" placeholder="Name" id="name" value="<?php echo $user['user_name']; ?>"/>
                </p>
                <p>
                    <?php echo $error['user_name']; ?>
                </p>

                <p class="email">
                    <input name="email" type="text" class="validate[required,custom[email]] feedback-input" id="email" placeholder="Email"  value="<?php echo $user['email']; ?>" />
                </p>
                <p>
                    <?php echo $error['email']; ?>
                </p>

                <p class="email">
                    <input name="ocupation" type="text" class="validate[required,custom[email]] feedback-input" id="" placeholder="Ocupation"  value="<?php echo $user['ocupation']; ?>" />
                </p>

                <p class="text">
                    <textarea name="introduction" class="validate[required,length[6,300]] feedback-input" id="comment" placeholder="Introduction"><?php echo $user['introduction']; ?></textarea>
                </p>

                <div class="submit">
                    <input type="submit" value="EDIT" id="button-blue"/>
                    <div class="ease"></div>
                </div>
            </form>
        </div>
    </body>
</html>



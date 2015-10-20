<?php

session_start();

require_once('assets/config.php');
require_once('assets/functions.php');

if (!empty($_SESSION['me'])) {
	header('Location:'.SITE_URL.'mypage.php');
}

function getUser($user_name, $password, $dbh) {
	$sql = "select * from users where user_name = :user_name and password = :password limit 1";
	$stmt = $dbh->prepare($sql);
	$stmt->execute(array(":user_name"=>$user_name, ":password"=>getSha1Password($password)));
	// 返り値のPDOオブジェクトに対してfetchメソッドを実行し、結果セットを配列で取得している
	$user = $stmt->fetch();
	return $user ? $user : false;
}

if ($_SERVER['REQUEST_METHOD'] != "POST") {
	// 投稿前

	// CSRF対策
	setToken();	
} else {
	// 投稿後
	checkToken();

	$user_name = $_POST['user_name'];
	$password = $_POST['password'];


	// DB接続した値を＄dbhにぶっこんでいる
	$dbh = connectDb();

	$error = array();

	// エラー処理
	// メールアドレスメールアドレスとパスワードが正しくない
	// この書き方でもOK → if (!$me = getUser($user_name, $password, $dbh)) {
	$me = getUser($user_name, $password, $dbh);

	// 名前が空
	if ($password == '') {
		$error['user_name'] = 'NOT ALLOWED EMPTY';
	}

	if (!$me) {
		$error['password'] = 'NAME AND PASSWORD ARE NOT MATCHED';
	}

	// パスワードが空
	if ($password == '') {
		$error['password'] = 'NOT ALLOWED EMPTY';
	}

	if (empty($error)) {
		// セッションハイジャック対策...これやると一旦動かないから置いておく。
		// session_regenerate_id(true);
		$_SESSION['me'] = $me;
			header('Location:'.SITE_URL.'mypage.php');
		exit;
	}

	// ログイン情報を記録する
	if ($_POST['save'] == 'on') {
		setcookie('email', $_POST['email'], time()+60*60*24*14);
		setcookie('password', $_POST['password'],
		time()+60*60*24*14);
	}
}

	

?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>LOG IN</title>
	</head>
	<body>
		<h1>LOG IN</h1>
		<form action="" method="POST">
			<p>
				NAME：
				<input type="text" name="user_name" value="<?php echo h($user_name); ?>"> 
				<span class="error">
					<?php echo h($error['user_name']); ?>
				</span>
			</p>
			<p>
				PASSWORD：
				<input type="password" name="password" value=""> 
				<span class="error">
					<?php echo h($error['password']); ?>
				</span>
			</p>
			<p>
				<input id="save" type="checkbox" name="save" value="on"><label for="save">AUTO LOG IN</label>
			</p>
			<p><input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>"></p>
			<p><input type="submit" value="LOG IN"> <a href="signup.php">GO TO SIGN UP</a></p>
		</form>
	</body>
</html>
<?php

session_start();

require_once('assets/config.php');
require_once('assets/functions.php');

$images = array();

$imageDir = opendir(IMAGES_DIR);

while ($file = readdir($imageDir)) {
	if ($file == '.' || $file == '..') {
		continue;
	}
	
	if (file_exists(THUMBNAIL_DIR.'/'.$file)) {
		$images[] = 'thumbnails/'.$file;
	} else {
		$images[] = 'images/'.$file;
	}
}

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
// var_dump($row);


if ($user['user_name'] == '') {
	$user['user_name'] = 'EMPTY';
}

if ($user['ocupation'] == '') {
	$user['ocupation'] = 'EMPTY';
}

if ($user['introduction'] == '') {
	$user['introduction'] = 'EMPTY';
}

?>

<!DOCTYPE html>
<!--
	Strata by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>DoDo</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	</head>
	<body id="top">
		<!-- Header -->
			<header id="header">
				<p><a href="#" class="image avatar" style="float:left;"><img src="<?php echo $user['image']; ?>" alt="" /></a></p>
				<p>
					<form action="upload.php" method="POST" enctype="multipart/form-data">
						<p><input type="file" name="image"></p>
						<p><input type="submit" value="UP LOAD"></p>
					</form>
				</p>
				<div>
					<h2 ><?php echo $user['user_name']; ?></h2>
					<h3 ><?php echo $user['ocupation']; ?></h3>
				</div>
				<div style="clear:both;">
					<p><?php echo $user['introduction']; ?></p>
					<ul class="actions">
						<li><a href="#" class="button">Learn More</a></li>
					</ul>
					<h2><a href="logout.php">LOG OUT</a> / <a href="edit_profile.php">EDIT</a></h2>
				</div>
			</header>

		<!-- Main -->
			<div id="main">
				

				<!-- FAVORITE -->
				<section id="two">
					<h2>FAVORITE</h2>
					<div class="row">
						<article class="6u 12u$(xsmall) work-item">
							<a href="assets/images/fulls/01.jpg" class="image fit thumb"><img src="assets/images/pic_1.jpg" alt="" /></a>
							<h3>TITLE TITLE TITLE TITLE TITLE</h3>
							<p>TEXT TEXT TEXT TEXT TEXT TEXT TEXT TEXT </p>
						</article>
						<article class="6u$ 12u$(xsmall) work-item">
							<a href="assets/images/fulls/02.jpg" class="image fit thumb"><img src="assets/images/pic_2.jpg" alt="" /></a>
							<h3>TITLE TITLE TITLE TITLE TITLE</h3>
							<p>TEXT TEXT TEXT TEXT TEXT TEXT TEXT TEXT </p>
						</article>
						<article class="6u 12u$(xsmall) work-item">
							<a href="assets/images/fulls/03.jpg" class="image fit thumb"><img src="assets/images/pic_4.jpg" alt="" /></a>
							<h3>TITLE TITLE TITLE TITLE TITLE</h3>
							<p>TEXT TEXT TEXT TEXT TEXT TEXT TEXT TEXT </p>
						</article>
						<article class="6u$ 12u$(xsmall) work-item">
							<a href="assets/images/fulls/04.jpg" class="image fit thumb"><img src="assets/images/pic_10.jpg" alt="" /></a>
							<h3>TITLE TITLE TITLE TITLE TITLE</h3>
							<p>TEXT TEXT TEXT TEXT TEXT TEXT TEXT TEXT </p>
						</article>
					</div>
					<ul class="actions">
						<li><a href="#" class="button">MORE</a></li>
					</ul>
				</section>

				<!-- MY POSTS -->
				<section id="two">
					<h2>MY POSTS</h2>
					<div class="row">
						<article class="6u 12u$(xsmall) work-item">
							<a href="assets/images/fulls/01.jpg" class="image fit thumb"><img src="assets/images/pic_9.jpg" alt="" /></a>
							<h3>TITLE TITLE TITLE TITLE TITLE</h3>
							<p>TEXT TEXT TEXT TEXT TEXT TEXT TEXT TEXT </p>
						</article>
						<article class="6u$ 12u$(xsmall) work-item">
							<a href="assets/images/fulls/02.jpg" class="image fit thumb"><img src="assets/images/pic_5.jpg" alt="" /></a>
							<h3>TITLE TITLE TITLE TITLE TITLE</h3>
							<p>TEXT TEXT TEXT TEXT TEXT TEXT TEXT TEXT </p>
						</article>
						<article class="6u 12u$(xsmall) work-item">
							<a href="assets/images/fulls/03.jpg" class="image fit thumb"><img src="assets/images/pic_7.jpg" alt="" /></a>
							<h3>TITLE TITLE TITLE TITLE TITLE</h3>
							<p>TEXT TEXT TEXT TEXT TEXT TEXT TEXT TEXT </p>
						</article>
						<article class="6u$ 12u$(xsmall) work-item">
							<a href="assets/images/fulls/04.jpg" class="image fit thumb"><img src="assets/images/pic_8.jpg" alt="" /></a>
							<h3>TITLE TITLE TITLE TITLE TITLE</h3>
							<p>TEXT TEXT TEXT TEXT TEXT TEXT TEXT TEXT </p>
						</article>
					</div>
					<ul class="actions">
						<li><a href="#" class="button">MORE</a></li>
					</ul>
				</section>

			<!-- Footer
			<footer id="footer">
				<ul class="icons">
					<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
					<li><a href="#" class="icon fa-github"><span class="label">Github</span></a></li>
					<li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
					<li><a href="#" class="icon fa-envelope-o"><span class="label">Email</span></a></li>
				</ul>
				<ul class="copyright">
					<li>&copy; Untitled</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
				</ul>
			</footer> -->

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.poptrox.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	</body>
</html>
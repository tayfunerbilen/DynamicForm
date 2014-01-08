<?php
require 'ayarlar.php';
extract($ayarlar);
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>

	<meta charset="UTF-8">
	<title><?php print $adsoyad; ?></title>
	
	<style type="text/css">
	* {
		padding: 0;
		margin: 0;
		list-style: none;
		text-decoration: none;
		font-family: Arial, sans-serif;
		font-size: 14px;
		line-height: 22px;
	}
	.profile {
		width: 400px;
		margin: 50px auto;
		border: 1px solid #eee;
		border-bottom-color: #ccc;
		padding: 20px;
	}
	.profile > img {
		display: block;
		width: 150px;
		height: 150px;
		border-radius: 100%;
		margin: 0 auto;
	}
	.profile h5 {
		font-size: 25px;
		text-align: center;
		padding: 20px 0;
		color: darkred;
	}
	.profile ul li {
		border-bottom: 1px solid #eee;
		padding: 5px 0;
	}
	.profile ul li a {
		color: darkred;
	}
	.social {
		padding-top: 10px;
		text-align: center;
	}
	</style>
	
</head>
<body>

	<div class="profile">
		
		<img src="http://www.gravatar.com/avatar/<?php print md5($eposta); ?>" alt=""/>
		<h5><?php print $adsoyad; ?></h5>
		
		<ul>
			<li>
				<strong>E-posta: </strong> <?php print $eposta; ?>
			</li>
			<li>
				<strong>Telefon: </strong> <?php print $telefon; ?>
			</li>
			<li>
				<strong>Web: </strong> <a href="<?php print $web; ?>"><?php print $web; ?></a>
			</li>
			<li>
				<strong>Hakkımda:</strong>
				<p><?php print $hakkinda; ?></p>
			</li>
		</ul>
		
		<div class="social">
			<a href="<?php print $facebook; ?>">
				<img src="facebook.png" alt=""/>
			</a>
			<a href="<?php print $twitter; ?>">
				<img src="twitter.png" alt=""/>
			</a>
			<a href="<?php print $youtube; ?>">
				<img src="youtube.png" alt=""/>
			</a>
		</div>
		
	</div>

</body>
</html>

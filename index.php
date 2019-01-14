<!doctype html>
<html lang="en">
<head>
<?php
	$title = 'Spawnpoint &bull; Gaming &amp; TeamSpeak &bull; Ready to spawn?';
	$desc = 'We\'re playing all kinds of games and are hosting a popular TeamSpeak voice chat server. Come play with us!';
	$og_title = $title;
	$og_desc = $desc;
?>
	<link href="content/img/favicon.png" rel="icon" type="image/png">
	<title><?php echo $title ?></title>
	<meta name="robots" content="index,follow">
	<meta name="description" content="<?php echo $desc ?>">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,500,900i" rel="stylesheet">
	<link rel="stylesheet" href="style/dist/css/main.min.css?<?=filemtime('style/dist/css/main.min.css')?>">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
	<meta name="theme-color" content="#322828">
	<meta property="og:title" content="<?php echo $og_title ?>">
	<meta property="og:url" content="https://spawnpoint.de/">
	<meta property="og:site_name" content="<?php echo $og_title ?>">
	<meta property="og:description" content="<?php echo $og_desc ?>">
	<meta property="og:type" content="website">
	<meta property="og:image" content="http://spawnpoint.de/content/img/og-logo.jpg">
</head>
<body>
<div class="header">
	<div class="grid">
		<div class="col-s-min col-align-middle hidden-l">
			<img class="appear appear-1" src="content/img/logo.svg" width="128" height="128" alt="Spawnpoint">
		</div>
		<div class="col-max col-l-12 col-align-middle">
			<a class="tscounter nowrap" href="#teamspeak"><span class="tscounter-signal"></span><span id="tscount">0</span> online</a>
		</div>
	</div>
</div>
<div class="hero" id="about">
	<div class="wrapper">
		<div class="grid">
			<div class="col-12 col-l-6 visible-l">
				<img class="appear appear-1" src="content/img/logo.svg" width="512" height="512" alt="Spawnpoint">
			</div>
			<div class="col-12 col-l-6 col-align-middle">
				<div class="container">
					<h1 class="hero-text appear appear-2"><a href="#the-crew" class="fancy">Spawnpoint</a> is a German gaming&nbsp;team established in 2009. We’re playing games of all genres and are hosting a popular <span class="nowrap"><a href="#teamspeak" class="fancy">TeamSpeak server</a>.</span></h1>
					<div class="container">
						<div class="group group-s-block">
							<div class="group-item appear appear-3">
								<a href="#the-crew"><button class="button">Meet the crew</button></a>
							</div>
							<div class="group-item appear appear-4">
								<a href="#teamspeak"><button class="button button-ghost">TeamSpeak</button></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<main class="content" id="the-crew">
	<div class="wrapper">
		<h2 class="mega-headline">We<br>are<br>Spawn<br>point</h2>
		<div class="container container-spacious">
			<div class="grid grid-spacious">
				<?php include 'Steam.class.php' ?>
				<?php foreach (Steam::get() as $member): ?>
					<div class="col-12 col-m-6">
						<div class="container-spacious member ta-center ta-l-left">
							<div class="grid">
								<div class="col-12 col-l-4">
									<div class="tap-protector" onclick="">
										<a class="circle member-avatar" target="_blank">
											<img class="member-avatar-image" src="content/img/pixel.png" alt="">
											<div class="member-avatar-link"></div>
										</a>
									</div>
								</div>
								<div class="col-12 col-l-8">
									<h3 class="member-name"><?=$member['name']?></h3>
									<div class="grid grid-tight">
										<div class="col-12 col-s-4">
											<div class="container container-tight">
												<h4 class="font-size-xxs">Alias</h4>
												<p class="member-alias"><?=$member['alias']?></p>
											</div>
											<div class="container container-tight">
												<h4 class="font-size-xxs">Age</h4>
												<p class="member-age"><?=$member['age']?></p>
											</div>
										</div>
										<div class="col-12 col-s-8">
											<div class="container container-tight">
												<h4 class="font-size-xxs">Most played</h4>
												<p class="member-most-played"><span class="loading-inline"></span></p>
											</div>
											<div class="container container-tight">
												<h4 class="font-size-xxs">Recently played</h4>
												<p class="member-recently-played"><span class="loading-inline"></span></span></p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="container container-spacious ta-center">
			<a href="#teamspeak"><button class="button">Talk to us</button></a>
		</div>
	</div>
</main>
<main class="content content-eyecatcher">
	<div class="wrapper ta-center">
		<?php
			function time_since($date) {
				$now = new DateTime(date('Y-m-d'));
				$date = new DateTime($date);
				$diff = $now->diff($date);
				if ($diff->m == 0 and $diff->d == 0) return $diff->y.' years&nbsp;🎉';
				else {
					if ($diff->m != 0 and $diff->d == 0) return $diff->y.' years and '.$diff->m.' month'.($diff->m > 1?'s':'').'';
					else if ($diff->m == 0 and $diff->d != 0) return $diff->y.' years and '.$diff->d.' day'.($diff->d > 1?'s':'').'';
					else return $diff->y.' years, '.$diff->m.' month'.($diff->m > 1?'s':'').' and '.$diff->d.' day'.($diff->d > 1?'s':'').'';
				}
			}
		?>
		<p class="font-size-m">Today it's been exactly<br><strong class="datecounter"><?php echo time_since('2009-09-19'); ?></strong><br>since our founding on Sep&nbsp;19<sup>th</sup>,&nbsp;2009.</p>
	</div>
</main>
<main class="content" id="teamspeak">
	<div class="wrapper">
		<div class="grid grid-spacious">
			<div class="col-12 col-m-6" id="col-tsviewer">
				<h2>TeamSpeak Live</h2>
				<div class="tsviewer" id="tsviewer">
					<div class="loading"></div>
				</div>
			</div>
			<div class="col-12 col-m-6 ta-m-right">
				<h2 class="mega-headline">Join<br>us&nbsp;on<br>Team<br>Speak</h2>
				<div class="container container-spacious">
					<p class="font-size-m">Visit our TeamSpeak server and say "Hello"! We're open for members and guests without any kind of registration. We're offering plenty of free channels for you and your friends.</p>
					<p class="font-size-m">Come play with us!</p>
					<p class="font-size-m"><a href="ts3connect.html" class="fancy">spawnpoint.de:9987</a></p>
					<p class="font-size-xxs"><a href="https://www.teamspeak.com/" target="_blank">Get TeamSpeak</a></p>
				</div>
				<hr class="hidden-nav">
			</div>
		</div>
	</div>
</main>
<footer class="footer">
	<div class="wrapper">
		<div class="grid">
			<div class="col-12 col-l-6">
				<div class="grid grid-tight">
					<div class="col-12 col-m-min">
						<a href="#about" class="float-left"><img src="content/img/logo.svg" class="footer-logo" height="68" width="68"></a>
					</div>
					<div class="col-12 col-m-max">
						<p>Copyright&nbsp;&copy;&nbsp;<?php echo date('Y'); ?> spawnpoint.de<br>Design&nbsp;&amp;&nbsp;Code&nbsp;by <a href="https://marceickhoff.com/"target="_blank">Marc&nbsp;Eickhoff</a></p>
					</div>
				</div>
			</div>
			<div class="col-12 col-l-6">
				<nav class="group group-center group-m-right">
					<div class="group-item"><a href="impressum.html" title="Impressum und rechtliche Angaben">Impressum</a></div>
					<div class="group-item"><a href="datenschutz.html" title="Datenschutzerklärung">Datenschutz</a></div>
				</nav>
			</div>
		</div>
	</div>
</footer>
<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script type="text/javascript" src="spawnpoint.min.js?<?=filemtime('spawnpoint.min.js')?>" defer></script>
</body>
</html>
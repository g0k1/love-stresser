
<?php
$file = '../authentication/handler/status/status.json';
$status = json_decode(file_get_contents($file), true);
if ($status['status'] === 'offline') {
    include('../help/cgu/index.php');
    die();
} else {
}
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title>Anim Coming Soon Responsive Template</title>
		<meta name="author" content="Codrops" />
		<link rel="shortcut icon" href="../favicon.ico">
		<link rel="stylesheet" type="text/css" href="css/normalize.css" /> 
		<link href='http://fonts.googleapis.com/css?family=Raleway:200,400,800' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>
	<body> 

<body id="home">
<div id="large-header" class="large-header">
					<canvas id="demo-canvas"></canvas> 
</div>
<div id="Content" class="wrapper"> 
<div class="top-wrapper">
<div id="header">
<div class="wrapper">
	<h1><a href="#" class="logo">Time Before Opening</a></h1>	
	</div>
</div>
<div class="countdown styled"></div> 

</div>
 
<script src="js/TweenLite.min.js"></script>
<script src="js/EasePack.min.js"></script>
<script src="js/rAF.js"></script>
<script src="js/demo-1.js"></script> 

<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/Backstretch.js"></script>
<script type="text/javascript" src="js/jquery.countdown.js"></script>
<script type="text/javascript" src="js/global.js"></script>

	</body>
</html>
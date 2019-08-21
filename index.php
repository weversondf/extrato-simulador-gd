<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Extrato do simulador</title>

	<!-- Bootstrap -->
	<link href="assets/css/bootstrap-3.3.7.min.css" rel="stylesheet">
	
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<script src="assets/js/jquery-3.2.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
	<script src="assets/js/bootstrap-3.3.7.min.js"></script>
	<style type="text/css">
	body {
	   font-size: 12px;
	}
	</style>
</head>
<body>
	<div class="container">
		<form class="navbar-form" action="action/extract-gd.php" method="post" name="formSearch">
			<div class="input-group">
				<!-- Teste: 201130001652 -->
				<input pattern=".{7,}" required="" title="Mínimo de 7 caracteres!" class="form-control" placeholder="Matrícula SIAPE!" name="search" type="text">
				<span class="input-group-btn">
					<input type="submit" value="Pesquisar" class="btn btn-primary">
				</span>
			</div>
		</form>
	</div>
</body>
</html>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Extrato do simulador</title>

	<!-- Bootstrap -->
	<link href="../assets/css/bootstrap-3.3.7.min.css" rel="stylesheet">
	
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<script src="../assets/js/jquery-3.2.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
	<script src="../assets/js/bootstrap-3.3.7.min.js"></script>
	<style type="text/css">
	body {
	   font-size: 12px;
	}
	.panel-title {
		font-size: 12px;
		color: black;
	}
	</style>
</head>
<body>
	<div class="container">
 <?php 
 // Forçar exibição de erros
// ini_set('display_errors',1);
// ini_set('display_startup_errors',1);
// error_reporting(E_ALL);

require_once("../config/dbconfig.php");
require_once("../classes/functions.php");
header('Content-Type: text/html; charset=utf-8');

$pdo = Conexao::getInstance();
$crud = Crud::getInstance($pdo, NULL);

$search = trim($_POST['search']);
// echo "Matrícula digitada: $search<br>"; // "201130001652"

// if(isset( $_POST['search'] )) {
if(isset( $search )) {
	if((strlen($search) < 7) || ($search != is_numeric($search))) {
		// echo "Digite uma matrícula válida com 7 ou 12 caracteres!";
?>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hsearchden="true">&times;</span></button>
			<span class="glyphicon glyphicon-thumbs-down" aria-hsearchden="true"></span>
			<strong>Erro!</strong> 
			<br>Digite uma matrícula válida com 12 caracteres!
		</div>
<?php
		die();
	} else {
		// echo "Matrícula digitada: $search"; // "201130001652"
		$sql = "SELECT orgao ||'-'|| it_no_orgao AS \"Órgão\"
				, gr_matricula AS \"Vínculo\"
				, it_no_servidor AS \"Nome\"
				, sit_vinc AS \"Situação\"
				, it_co_grupo_ocor_inatividade || it_co_ocor_inatividade  ||'-'|| it_no_ocorrencia AS \"Aposentadoria\"
				, to_char(it_da_ocor_inatividade_serv::DATE, 'DD/MM/YYYY') AS \"Data\"
				  FROM tb_concessoes
				WHERE gr_matricula = :search";
		$data = $crud->getQueryInListHtml($sql, $search, 'Dados do servidor');

		// Média dos pontos
		if(!empty($data)){
			// echo "Registro encontrado";
			$sql2 = "SELECT REPLACE(media_total_pontos::VARCHAR,'.',',') AS \"Média dos pontos calculada\"
					, REPLACE(total_meses_contagem::VARCHAR,'.',',') AS \"Total de meses na contagem\"
					  FROM tb_financeiro_extrato_media_pontos
					WHERE matricula = :search";	
			$data2 = $crud->getQueryInTableHtml($sql2, $search, 'Média dos pontos');
		} else {
			// echo "Registro não encontrado";
			die;
		}
		
		// Detalhamento das GDs
		$sql3 = "SELECT sigla_gratificacao AS \"Gratificação\"
				, fn_format_out_yyyymm(no_mes) AS \"Mês e Ano\"
				, nivel AS \"Nível\"
				, classe AS \"Classe\"
				, ref_niv_pad AS \"Padrão\"
				, REPLACE(valor_ponto::VARCHAR,'.',',') AS \"Valor do ponto\"
				, TO_CHAR(valor_gratificacao, '\"R$\" FM999G999G990D00') AS \"Valor da gratificação\"
				, REPLACE(total_pontos::VARCHAR,'.',',') AS \"Total de pontos\"
				  FROM tb_financeiro_extrato
				WHERE matricula = :search
				ORDER BY matricula, no_mes";
		$data3 = $crud->getQueryInTableHtml($sql3, $search, 'Detalhamento das GDs');

		// Desconectar
		$pdo = null;
	}
}
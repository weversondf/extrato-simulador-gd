<?php  
header('Content-Type: text/html; charset=utf-8');
  
class Crud{
    
	// Atributo para guardar uma conexão PDO   
	private $pdo = null;
    
	// Atributo onde será guardado o nome da table    
	private $table = null;
    
	// Atributo estático que contém uma instância da própria classe   
	private static $crud = null;
       
	private function __construct($connect, $table=NULL){ 
		if (!empty($connect)):
			$this->pdo = $connect;
		else:
			echo "<h3>Conexão inexistente!</h3>";
			exit();
		endif;

		if (!empty($table)) $this->table =$table;
	}
    
	public static function getInstance($connect, $table=NULL){
		// Verifica se existe uma instância da classe
		if(!isset(self::$crud)):
			try {
				self::$crud = new Crud($connect, $table);
			} catch (Exception $e) {
				echo "Erro " . $e->getMessage(); 
			}
		endif;

		return self::$crud;
	}
  
	public function setTableName($table){
		if(!empty($table)){
			$this->table = $table;
		}
	}

	public function getQueryInListHtml($query, $param, $title) {
		try {
			// Preventing SQL Injection Attacks with Prepared Statements
			$result = $this->pdo->prepare($query);
			$result->bindValue('search', $param);
			$result->execute();
			$row = $result->fetch(PDO::FETCH_ASSOC);
			
			// Trata o Warning: Invalid argument supplied for foreach() in /var/www/html/afd/consulta-afd-siape/classes/functions.php on line 97
			if(!empty($row)) {	
				echo "<div class=\"panel panel-info\">
						<div class=\"panel-heading\">
						  <h3 class=\"panel-title\">
							<strong>$title</strong>
						  </h3>
						</div>
						<div class=\"panel-body\">";
						foreach ($row as $field => $value){
							echo "<strong>$field: </strong>$value<br/>";

						}
			echo "  </div>
				</div>";
			} else {
?>
				<div class="alert alert-info alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hsearchden="true">&times;</span></button>
					<span class="glyphicon glyphicon-exclamation-sign" aria-hsearchden="true"></span>
					<strong>Informação!</strong> 
					<br>Registro não encontrado!
				</div>
<?php 
			}
			return $row;
		} catch(PDOException $e) {
			echo 'ERROR: ' . $e->getMessage();
		}
	}

	public function getQueryInTableHtml($query, $param, $caption) {
		try {
			// Preventing SQL Injection Attacks with Prepared Statements
			$result = $this->pdo->prepare($query);
			$result->bindValue('search', $param);
			$result->execute();
			$row = $result->fetch(PDO::FETCH_ASSOC);
			
			// Trata o Warning: Invalid argument supplied for foreach() in /var/www/html/afd/consulta-afd-siape/classes/functions.php on line 97
			if(!empty($row)) {	
				echo "<div class=\"table-responsive\">
						<table class=\"table table-bordered table-striped table-hover table-condensed\">
							<caption>
								<strong>{$caption}</strong>
							</caption>
						<thead>";
				echo "<tr class=\"info\">";
						foreach ($row as $field => $value){
							echo "<th>$field</th>";
						}
				echo "</tr>
				</thead>
				<tbody>";
				$data = $this->pdo->prepare($query);
				$data->bindValue('search', $param);
				$data->execute();				
				$data->setFetchMode(PDO::FETCH_ASSOC);
				foreach($data as $row){
					echo "<tr>";
					foreach ($row as $name=>$value){
						echo " <td>$value</td>";
					}
				echo "</tr>";
				}
				echo "</tbody>
				</table>
				</div>";
			} else {
?>
				<div class="alert alert-info alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hsearchden="true">&times;</span></button>
					<span class="glyphicon glyphicon-exclamation-sign" aria-hsearchden="true"></span>
					<strong>Informação!</strong> 
					<br>Registro não encontrado!
				</div>
<?php 
			}
			return $row;
		} catch(PDOException $e) {
			echo 'ERROR: ' . $e->getMessage();
		}
	}
} 
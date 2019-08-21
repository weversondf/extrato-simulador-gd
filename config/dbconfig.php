 <?php 
// Desenvolvimento local AFD
define('HOST', '10.209.9.131');  
// define('DBNAME', 'simulador_gd');   
define('DBNAME', 'simulador_gd_serpro');   
define('USER', 'cgdms');  
define('PASSWORD', 'senhacgdms');

 class Conexao {  
	/*  
	* Atributo estático para instância do PDO  
	*/  
	private static $pdo;

	/*  
	* Escondendo o construtor da classe  
	*/ 
	private function __construct() {  
	 //  
	} 

	/*  
	* Método estático para retornar uma conexão válida  
	* Verifica se já existe uma instância da conexão, caso não, configura uma nova conexão  
	*/  
	public static function getInstance() {  
		if (!isset(self::$pdo)) {  
			try {  
				self::$pdo = new PDO("pgsql:host=".HOST.";port=5432;dbname=".DBNAME.";user=".USER.";password=".PASSWORD);
			} catch (PDOException $e) {  
				print "Erro: " . $e->getMessage();  
			}  
		}  
		return self::$pdo;  
	} 
 }

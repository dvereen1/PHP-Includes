<?php 

/**
 * Returns a database connection
 */

include_once("DBConfig.php");
class DBConnection extends DBConfig{
    
    protected static $instance; 
    protected $pdo;  
    
    /**
     * Creates a PDO connection with the database credentials found in the given .ini file
     * 
     * @param $file {String} - an ini file which contains database login information
     */
    private function __construct($file) {

        //The function call returns an array that holds the database credentials found in a give .ini file
        $iniArr = $this->configCred($file);
        $dsn = 'mysql:host=' . $iniArr['host'] . ';dbname=' . $iniArr['dbName'] . ';charset=utf8mb4;';
        //defining how to report errors, fetch and recieve data from database and how to handle prepared statements
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        try {
         //defining the connection
          $this->pdo = new PDO($dsn, $iniArr['user'], $iniArr['pwd'], $options);
   
        } catch (PDOException $e){
            // in production should log this error;
            $errors['dbConnError'] = 'Unable to connect: ' . $e->getMessage();
            echo(json_encode($errors));
            die();
        }
    }
    
    /**
     * Generates an instance of itself if it does not exist
     * 
     * @param $file {String} - the .ini file holding the database credentials
     * @return - instance of this class which is a pdo database connection
     */
    public static function initialize($file){
        if(!isset(self::$instance)){
            self::$instance = new self($file);  // instantiating itself
          
        }
        return self::$instance;
    }

    /**
     * Queries the database with provided query and arguments
     * @param {String} $query - the query string
     * @param {Array} $args  - arguments in the event of prepared   prepared statement
     * @param {Integer} $type - expects 1 if prepared statement object is to be returned, null otherwise
     * @return {Boolean | PDOStatement } - If a prepared statement was executed then true or false depending on the success. If $type is 1 then a PDOStatement object is returned.
     */

    public function dbQuery($query, $args = [], $type = null) {
 
        if(!$args) { //if there are no arguments just a simple query is necessary
            if(!$result = $this->pdo->query($query)){
                //echo 'Error updating database with ' . $query;
                exit(json_encode($errors['queryError'] = 1));
            } 
            return $result;
        }
        if($stmt = $this->pdo->prepare($query)){
            //if the prepared statement can be ran within mysql server
            try{
                $result = $stmt->execute($args);
            }catch(PDOException $e){
                error_log($e);
                $errors['queryError'] = 1;
                exit(json_encode($errors));
            }
        }else{
            //echo 'Error preparing statment';
            $errors['prepStatError'] = 1;
            exit(json_encode($errors));
        }
        if($type){
            return $stmt; 
        }else{
            return $result;
        }
       
    }

    
}
 
 


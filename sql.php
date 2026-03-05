<?php
include_once("./secrets.php"); //path matters
include_once("./encrypt.php");

//DB connector class

//observe errors in browser window
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Database{
    
    private $server = "127.0.0.1";
    private $user = Secrets::DB_USER; //TODO: Least Priv. make new user.
    private $password = Secrets::DB_PASSWORD;
    //TODO: weak password, hardcoded
    private $schema = "web_app";

    private $conn = null;

    public function __construct() {
        //conn db 
        $this->conn = mysqli_connect($this->server, $this->user, $this->password, $this->schema);

        if(!$this->conn){
            die("Connection failed " . mysqli_connect_error());
        }
    }

    public function login($username, $password){
        //never concatenate user input into sql query, use prepared statements instead. This is vulnerable to sql injection attacks.
        //$sql1 = "SELECT * FROM users WHERE username ='".$username."' AND password='".$password."'";

        $stmt = $this->conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();  
        if($result->num_rows != 1){
            return false;
        }
        $result->data_seek(0);
        $row = $result->fetch_assoc();

        return password_verify($password, $row['password']);
        
        //$result = mysqli_query($this->conn, $sql1);

        //var_dump($result);

        //error handling
        //if(!$result){
            //return false;
        //}

        //if(!$result instanceof mysqli_result){
            //return false;
    
        //}

        //if($result->num_rows == 0){
            //return false;
        //}

        //return true;
    }

    public function search($keyword){

        $sql1 = "SELECT preferred FROM users WHERE preferred LIKE '%".$keyword."%'";

        $result = mysqli_query($this->conn, $sql1);

        //var_dump($result);

        return $result;
    
    }

    public function create_user($un, $pw, $rn, $st, $ssn){
        //split up ssn
        $ssn = str_replace("-", "", $ssn); //remove dashes
        $ssn_prefix = substr($ssn, 0, 5);

        //encrypt asap
        $e = new Encrypt();
        $ssn_prefix_iv_t_ct = $e->encrypt($ssn_prefix);
        

        $ssn_suffix = substr($ssn, 5);


        //var_dump($ssn);
        //var_dump($ssn_prefix);
        //var_dump($ssn_suffix);
        //Prepared statement

        $insert_sql = "INSERT INTO users (username, password, preferred, email, ssn_prefix, ssn_suffix) VALUES (?, ?, ?, ?, ?, ?)";

        //bind variables
        $arr = [$un, $pw, $rn, '', $ssn_prefix_iv_t_ct, $ssn_suffix];

        //execute
        if($this->conn->execute_query($insert_sql, $arr)){
            return true;
        } 
        return false;
    


        
    }

    public function user_exists($un){
        //Prepared statement

        $insert_sql = "SELECT username FROM users WHERE username = ?";

        //bind variables
        $arr = [$un];

        //execute
        $result = $this->conn->execute_query($insert_sql, $arr);
        
        return $result->num_rows > 0;


        
    }

}


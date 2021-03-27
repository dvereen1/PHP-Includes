<?php

/*
Defines methods for form validation.
Places each input that has passed validation test into an array 
which is ultimately returned 
*/
class FormValidator {
    private $success = false;
    private $validInputs = [];
    private $passwords = [];
    private $conn = null;

   
    /**
     * Sends error array to output and exits the program 
     * @param {String} $msg - the input which triggered error.
     * 
     */
    protected function reportError($msg){
        //$errors[] = $msg;
        exit(json_encode($msg));
    }
    /**
     * Checks given password against a regular expression. If check fails, call function which exits program with error message.
     * @param {String} $password - password to be checked
     * 
     */
    protected function legalPassword($password){
        if(!preg_match("/^[a-zA-Z0-9!$:_#]+$/i", $password)){
            $this->reportError("Password");
        }
    }
    /**
     * 
     * Validates password. If registration is taking place, checks whether both passwords match.
     * 
     * @param {String | Array} $password - $_POST value that references password or an array containing to passwords.
     * @param {boolean} $register - true if $_POST object contains an array of password inputs
     * false if only one password value is present
     * 
     */
    protected function validatePassword($password, $register){
        if(!empty($password)){
            $trimmedPwd = "";
            if(!$register){
                //In this case the user is logging in or there is no need to confirm this password matches another
                $trimmedPwd = trim($password);
                $this->legalPassword($trimmedPwd);
                $this->validInputs["password"] = $trimmedPwd;
            }else{
                //An array containing passwords is expected
                //Compare the two passwords
                if($password[0] !== $password[1]){
                      $this->reportError("Non-match");
                }
                $this->legalPassword(trim($password[0]));
                $trimmedPwd = trim($password[0]);
                $hash = password_hash($trimmedPwd, PASSWORD_DEFAULT);
                /*echo json_encode('this is the password hash: ' . $hash);*/
                $this->validInputs["password"] = $hash;
           }
           //Making it here means the password  either passed reg expression, matches the confirmation password, or both.
            return $this->validInputs;
        }
         $this->reportError("Empty");
    }   
    /**
     * Validates email
     *
     * @param {String} $emailValue - $_POST object value that references email field passed via post method
     * @param {DBConnection} $conn - database connection object
     * @return {Array} $validInputs - array with the addition of the validated email
     */
    protected function validateEmail($email, $conn){ 
        if(!empty($email)){
            $trimmedEmail = trim($email);
            //if the email cannot be validated by built in validator call function to send error and exit script
            if(!filter_var($trimmedEmail, FILTER_VALIDATE_EMAIL)){
                $this->reportError("Email");
            }
            $cleanEmail = filter_var($trimmedEmail, FILTER_SANITIZE_EMAIL);
            //check to see if email already exists in databases
            $result = $conn->dbQuery("select count(email) from users where email = ?", ["$cleanEmail"], 1);
            $taken = $result->fetchColumn();
            if($taken){
                $this->reportError("Email Taken");
            }
            $this->validInputs["email"] = $cleanEmail;
            return $this->validInputs;
        }
        $this->reportError("Empty");
    }      
    /** 
     * Validates text inputs from $_POST array. If the input is a username and registration is occuring, checks existance of given username against those already in the database.
     * 
     * @param {String} $text - $_POST variable value that is a name or username or some text passed via post method.
     * @param {String} $nameType - denotes the type of input to be processed. Expects one of the following strings: [ "first name" | "firstname" | "last name" | "lastname" | "user name" | "username" | "password"].
     * @param {DBConnection} $conn- database connection 
     * @param {boolean} $register - true if some type of registering is taking place
     * 
     * 
     * @return {Array} $validInputs - an array with addition of the validated text field
     */
    protected function validateText($text, $nameType, $conn, $register) {
        if(!empty($text)){
            $trimmedText = trim($text);
            $validUsername = false;
            //check if the name or user name aligns with the regex, if not error out of the script
            switch(mb_strtolower($nameType)){
                case "firstname":
                case "first name":
                case "lastname":
                case "last name":
                    if(!preg_match("/^[a-z]+$/i", $trimmedText)){ 
                        $this->reportError("Name");
                    }
                break;
                case "username":
                case "user name":
                    if(!preg_match("/^[a-z0-9_]+$/i", $trimmedText)){
                        $this->reportError("Username");
                    }
                    $validUsername = true;
                break;
            }
            //sanitize the string after its been passed through regex
            $cleanStr = filter_var($trimmedText, FILTER_SANITIZE_STRING);
            //If registration is occuring, the username must not already be in database
            if($validUsername && $register){
                $result = $conn->dbQuery("select count(username) from login where username = ?", ["$cleanStr"], 1);
                $takenUser = $result->fetchColumn();
                if($takenUser){
                    $this->reportError("Username Taken");
                }
            }
            $this->validInputs[$nameType] = $cleanStr;
    
            return $this->validInputs;
        }
        //Input was empty
        $this->reportError("Empty");
    }

    /**
     * Validates each element in the $_POST array based on requirements provided in an additional array.
     * For this use case, only inputs of type text, email, or password are checked and expected. If the source array contains multiple passwords then registration is occuring.
     * 
     * @param {Array} $source - the POST or GET object
     * @param {Array} $reqs - an array of $_POST or $_GET keys whose value is the key's input type 
     * @param {DBConnection }$conn - a database connection 
     * @param {Booelean} $register - 0 or 1 representing true or false if a type of registration is taking place.
     * @return boolean depending on the validity of the  each of the inputs in the $_POST array 
     */
     
     public function check($source, $reqs = [], $conn, $register) {
        //$register = 0;
        if(isset($source)){
            if(isset($reqs)){
                //checking if there a multiple passwords
                /*if(count($source["password"]) > 1){
                    $register = 1;
                }*/
                /*echo json_encode('This is the value of register variable ' . $register . "\n");*/
                foreach($reqs as $key => $val) { 
                    $val = mb_strtolower($val);
                    switch($val){
                        case "text":
                            $this->validateText($source[$key], $key, $conn, $register);
                            /*echo json_encode($source[$req] . " is a text input");*/
                        break;
                        case "email":
                            $this->validateEmail($source[$key], $conn);
                            /*echo json_encode($source[$req] . " is  email");*/
                        break;
                        case "password":
                            $this->validatePassword($source[$key], $register);
                            //echo json_encode($source[$req] . " is  password");
                        break;
                    }
                }
            } else { 
                //$errors["Undefined"] = "Parameter is undefined";
                $this->reportError("Parameter is undefined");
                //echo $errors;
                //return false;
            }
        } else {
            //$errors["Undefined"] = "Parameter is undefined";
            //echo $errors;
            //return false;
            $this->reportError("No post data submitted");
        }
        
        return $this->validInputs;
     }
}
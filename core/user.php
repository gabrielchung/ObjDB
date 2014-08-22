<?php
    require_once 'database.php';
    require dirname(__FILE__) . '/openID/openid.php';
    
    class User {
        
        public $userID = null;
        public $firstName = null;
        public $lastName = null;
        public $email = null;
        private $openid = null;
        
        function __construct($openID = true) {
            try {
                if ($openID) {
                    $this->openid = new LightOpenID('http://www.beewii.com/jspg');
                }
            } catch(ErrorException $e) {
                echo $e->getMessage();
            }
        }
        
        public function authorize() {
            try {
                if ($this->openid == null) {
                    return;
                }
                else {
                    $openid = $this->openid;
                }
                
                if(!$openid->mode) {
                    $openid->identity = 'https://www.google.com/accounts/o8/id';
                    $openid->required = array('contact/email', 'namePerson/first', 'namePerson/last');
                    return 'Location: ' . $openid->authUrl();
                } elseif($openid->mode == 'cancel') {
                    //do nothing
                    //echo 'User has canceled authentication!';
                } else {
                    //echo 'User ' . ($openid->validate() ? $openid->identity . ' has ' : 'has not ') . 'logged in.';
                    $attributes = $openid->getAttributes();
                    $this->firstName = $attributes['namePerson/first'];
                    $this->lastName = $attributes['namePerson/last'];
                    $this->email = $attributes['contact/email'];
                    //print_r($openid->data);
                    //echo 'Email: ' . $openid['contact/email']
                }
            } catch(ErrorException $e) {
                echo $e->getMessage();
            }
        }
        
        public function login() {
            try {
                $dbh = connect_db();
    
                $sql = 'SELECT * FROM tblUser WHERE email = :email';

                $sth = $dbh->prepare($sql);
                $sth->bindParam(':email', $this->email, PDO::PARAM_STR, 100);

                $sth->execute();
                
                if ($row = $sth->fetch())
                {
                    $this->userID = $row['userID'];
                    $this->firstName = $row['firstName'];
                    $this->lastName = $row['lastName'];
                    $this->email = $row['email'];
                }
                else
                {
                   //echo 'not in DB';
                   $this->register();
                   $this->login();
                }
            } catch(ErrorException $e) {
                echo $e->getMessage();
            }
        }
        
        private function register() {
            try {
                
                $dbh = connect_db();
    
                $sql = 'INSERT INTO tblUser (firstName, lastName, email) VALUES (:firstName, :lastName, :email)';

                $sth = $dbh->prepare($sql);
                $sth->bindParam(':firstName', $this->firstName, PDO::PARAM_STR, 50);
                $sth->bindParam(':lastName', $this->lastName, PDO::PARAM_STR, 50);
                $sth->bindParam(':email', $this->email, PDO::PARAM_STR, 100);

                $sth->execute();
                
            } catch(ErrorException $e) {
                echo $e->getMessage();
            }
        }
        
        public function getUserByEmail($email) {
            try {
                
                $dbh = connect_db();
    
                $sql = 'SELECT * FROM tblUser WHERE email = :email';

                $sth = $dbh->prepare($sql);
                $sth->bindParam(':email', $email, PDO::PARAM_STR, 100);

                $sth->execute();
                
                if ($row = $sth->fetch()) {
                    $this->userID = $row['userID'];
                    $this->firstName = $row['firstName'];
                    $this->lastName = $row['lastName'];
                    $this->email = $row['email'];
                    
                    return true;
                }
                else {
                    return false;
                }
                
            } catch(ErrorException $e) {
                echo $e->getMessage();
            }
        }
    }
?>
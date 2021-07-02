<?php
    class LoginRegisterView {

        //Atributes:
        private $isLogin;
        private $login;
        private $register;

        //Constructor:
        public function __construct() {
            $this->setIsLogin(true);
            
            if(array_key_exists('register', $_POST)){
               $this->setIsLogin(false);
            }
            else if(array_key_exists('login', $_POST)){
                $this->setIsLogin(true);
            }
        }

        //Methods:
        private function setIsLogin($set){
            return  $this->isLogin = $set;
        }

        public function getIsLogin(){
            return $this->isLogin;
        }

        public function getLogin(){
            return $this->login;
        }

        public function getRegister(){
            return $this->register;
        }
    }
?>
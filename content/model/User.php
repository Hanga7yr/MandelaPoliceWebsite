<?php
    require_once 'model/Person.php';

    class User extends Person {
        private int $id;

        private string $username;
        private string $password;
        private string $icon;

        public function SetID($id) {
            $this->id = $id;
        }
        public function SetUsername($username) {
            $this->username = $username;
        }

        public function SetPassword($password) {
            $this->password = $password;
        }

        public function SetIcon($icon) {
            $this->icon = $icon;
        }

        public function GetID() {
            return $this->id;
        }

        public function GetUsername() {
            return $this->username;
        }

        public function GetPassword() {
            return $this->password;
        }

        public function GetHashPassword() {
            return hash('sha256', $this->password);
        }
        public function GetIcon() {
            return $this->icon;
        }
    }
?>
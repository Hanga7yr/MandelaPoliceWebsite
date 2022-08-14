<?php
    require_once 'Model/Person.php';

    class User extends Person {
        private array $id;

        private string $username;
        private string $password;
        private string $icon;
        private string $rol;

        public function __construct(
            ?array $id = ['', ''],
            ?string $username = '',
            ?string $password = '',
            ?string $icon = '',
            ?string $rol = ''
        ) {
            $this->id =         $id == null         ? ['', ''] : $id;
            $this->username =   $username == null   ? '' : $username;
            $this->password =   $password == null   ? '' : $password;
            $this->icon =       $icon == null       ? '' : $icon;
            $this->rol =        $rol == null        ? '' : $rol;
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

        public function SetRol($rol) {
            $this->rol = $rol;
        }

        public function GetID() { return $this->id; }
        public function GetStringID() { return $this->id[0]; }
        public function GetNumberID() { return $this->id[1]; }
        public function SetID(array $id) { $this->id = $id; }

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
        public function GetRol() {
            return $this->rol;
        }
    }
?>
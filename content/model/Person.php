<?php
    class Person {
        private string $firstName;
        private string $lastNames;
        private string $gender;

        public function __construct() {
            $this->firstName = $this->lastNames = $this->gender = '';
        }

        public function SetFirstName($firstName) {
            $this->firstName = $firstName;
        }

        public function SetGender($gender) {
            $this->gender = $gender;
        }

        public function SetLastNames($lastNames) {
            $this->lastNames = $lastNames;
        }

        public function GetFirstName() {
            return $this->firstName;
        }

        public function GetGender() {
            return $this->gender;
        }

        public function GetLastNames() {
            return $this->lastNames;
        }
    }

?>
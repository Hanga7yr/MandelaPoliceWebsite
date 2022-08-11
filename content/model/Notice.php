<?php
    class Notice {
        private int $id;
        private string $header;
        private $content;
        private string $image;
        
        public function __construct() {
            $this->id = 0;
            $this->content = null;
            $this->image = $this->header = '';
        }

        public function SetID($id) {
            $this->id = $id;
        }

        public function SetImage($image) {
            $this->image = $image;
        }

        public function SetHeader($header) {
            $this->header = $header;
        }

        public function SetContent($content) {
            $this->content = is_array($content) ? $content : array($content);
        }

        public function AddContent($content) {
            if(!isset($this->content))
                $this->content = array($content);
            
            $this->content = $this->GetContent();

            if(is_array($content))
                $this->content = array_merge($this->GetContent(), $content); # We use the function as we know it will always be an array.
            else
                array_push($this->content, $content);
        }

        public function GetID() {
            return $this->id;
        }

        public function GetImage() {
            return $this->image;
        }

        public function GetHeader() {
            return $this->header;
        }

        public function GetContent() {
            return is_array($this->content) ? $this->content : array($this->content);
        }
    }

?>
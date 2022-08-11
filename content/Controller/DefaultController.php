<?php
    require_once 'Controller/Controller.php';

    class DefaultController extends Controller {
        public function DefaultAction($args) {
            $headerLogo = $this->defaultHeaderLogo;
            $headerLogo['text'] .= '1';

            $frontNew = new Notice();
            $frontNew->SetHeader('In Memorium1');
            $frontNew->SetContent('In memory of...1');
            $frontNew->SetImage('/assets/img/news/0/img.png');

            include_once 'View/index.html';
        }

        public function AboutAction($args) {
            
            $title = 'About';
            include_once 'View/About.html';
        }

        public function ShowAction($args) {
            echo '<p>Called from Default Controller by Show Action</p>';
            
            echo '<p>'.var_dump($args).'</p>';
            echo '<p>'.$this->controllerName.'</p>';

            include_once 'View/index.php';
        }

        public function CheckErrorAction($args) {
            echo '<p>Called from Default Controller by Check Error Action</p>';
            
            $this->Error();
        }
    }
?>
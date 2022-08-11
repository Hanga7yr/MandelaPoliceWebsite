<?php
    require_once 'Controller/Controller.php';

    class NewsController extends Controller {
        public function ShowAction($args) {
            echo $args;
        }
    }
?>
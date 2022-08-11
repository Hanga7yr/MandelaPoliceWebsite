<?php
    require_once 'Controller/Controller.php';

    class LoginController extends Controller {
        public function RequestLogAction($args) {
            echo '<p>'.var_dump($args['Msg']).'</p>';
        }

        public function LoginAction() {
            Controller::StartSession();
        }

        public function LogoutAction() {
            Controller::StopSession();
        }
    }
?>
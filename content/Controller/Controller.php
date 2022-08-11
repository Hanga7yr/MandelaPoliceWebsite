<?php
    class Controller {
        protected string $controllerName;
        protected string $controllerAction;
        protected $controllerArgs;

        function __construct($controllerName, $controllerAction, $controllerArgs) {
            $this->controllerName = $controllerName;
            $this->controllerAction = $controllerAction;
            $this->controllerArgs = $controllerArgs;

            $texts = constant('18i');
            foreach($texts as $txtKey => $txtValue)
                $this->{'default'.$txtKey} = $txtValue;

            $this->defaultFrontNew = constant('frontNew');
        }

        public function Error() {
            require_once '/View/error.php';
        }

        public function Redirect($controller, $action, $args) {
            Controller::StartSession();
            $_SESSION['Args'] = $args;
            header('Location: /index.php?Controller='.$controller.'&Action='.$action, TRUE);
        }

        public function Allow($usernames) {
            if(!isset($_SESSION['user'])) # Redirect to login. Requesting log.
                $this->Redirect(
                    'Login',
                    'RequestLog',
                    array(
                        "Msg" => constant('msg')['allow_request_login']
                    ) # args
                ); 
            
            $canContinue = FALSE;
            if(is_array($usernames)) {
                $canContinue = in_array($usernames, $_SESSION['user']->GetUsername());
            } else $canContinue = $_SESSION['user']->GetUsername() === $usernames;


        }

        public function Deny($usernames) {
            if(!isset($_SESSION['user'])) # Redirect to login. Requesting log.
                $this->Redirect(
                    'Login',
                    'RequestLog',
                    array(
                        "Msg" => constant('msg')['allow_request_login'] 
                    ) # args
                ); 

            $canContinue = FALSE;
            if(is_array($usernames)) {
                $canContinue = !in_array($usernames, $_SESSION['user']->GetUsername());
            } else $canContinue = $_SESSION['user']->GetUsername() !== $usernames;
        }

        public static function StartSession() {
            if(session_status() === PHP_SESSION_NONE)
                session_start();
        }

        public static function StopSession() {
            if(session_status() === PHP_SESSION_ACTIVE)
                session_destroy();
        }
    }
?>
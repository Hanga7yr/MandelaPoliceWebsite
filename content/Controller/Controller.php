<?php
    class Controller {
        protected string $controllerName;
        protected string $controllerAction;
        protected $controllerArgs;

        protected $ViewModel;

        function __construct($controllerName, $controllerAction, $controllerArgs) {
            $this->controllerName = $controllerName;
            $this->controllerAction = $controllerAction;
            $this->controllerArgs = $controllerArgs;

            $this->ViewModel = [
                '*.footer.socials.disabled' => True,
                '*.identifiers.prefix' => 'alternate',
                '*.identifiers.suffix' => 'type',
                'index.header.navbar.items' => [
                    ['text' => t('index.header.navbar.items.0.text'), 'link' => Controller::Url(null, null, null)       , 'controller' => 'Default' , 'disabled' => False , 'required' => False ],
                    ['text' => t('index.header.navbar.items.1.text'), 'link' => Controller::Url(null, 'Services', null) , 'controller' => 'Services', 'disabled' => TRUE , 'required' => False ],
                    ['text' => t('index.header.navbar.items.2.text'), 'link' => Controller::Url('News', null, null)     , 'controller' => 'News'    , 'disabled' => False , 'required' => False ],
                    ['text' => t('index.header.navbar.items.3.text'), 'link' => '#'                                     , 'controller' => 'About'   , 'disabled' => True  , 'required' => False ],
                    ['text' => t('index.header.navbar.items.4.text'), 'link' => Controller::Url('Reports', null, null)  , 'controller' => 'Reports' , 'disabled' => False , 'required' => True  ],
                ],
                'index.header.navbar.login.link' => Controller::Url('Login', null, null),
                'index.header.navbar.login.text' => t('index.header.navbar.login.text'),
                'index.header.navbar.logout.link' => Controller::Url('Login', 'Logout', null),
                'index.header.navbar.logout.text' => t('index.header.navbar.logout.text'),
                'news.maxlength' => 10,
                'news.link' => 'index.php?Controller=News&Action=Get&Args=',
            ];
        }

        public static function Url($controller, $action, $args) {
            return 'index.php?'.http_build_query([
                'Controller' => $controller,
                'Action' => $action,
                'Args' => $args
            ]);
        }

        public function RenderPage($page, $dictionary = null) {
            if(file_exists($page)) {
                Controller::StartSession();

                if(isset($dictionary))  $GLOBALS['Dictionary'] = $dictionary;
                include_once $page;
                if(isset($dictionary))  $GLOBALS['Dictionary'] = $GLOBALS['18i'];

                $_SESSION['Args'] = [];
            } else $this->Error([
                'page' => $page
            ]);
        }

        public function Error($args) {
            require_once 'View/error.php';
        }

        public function Redirect($controller, $action, $args) {
            header('Location: '.Controller::Url($controller, $action, $args), TRUE);
        }

        public function Allow($usernames, $roles) {
            Controller::StartSession();
            if(!isset($_SESSION['User'])) # Redirect to login. Requesting log.
                $this->Redirect(
                    'Login',
                    'RequestLog',
                    array(
                        "Msg" => t('errors.allow_request_login')
                    ) # args
                ); 
            
            $canContinueUsers = FALSE;
            if(is_array($usernames)) {
                $canContinueUsers = in_array($_SESSION['User']->GetUsername(), $usernames);
            } else $canContinueUsers = $_SESSION['User']->GetUsername() === $usernames;
            
            $canContinueRoles = FALSE;
            if(is_array($roles)) {
                $canContinueRoles = in_array($_SESSION['User']->GetRol(), $roles);
            } else $canContinueRoles = $_SESSION['User']->GetRol() === $roles;

            if(!$canContinueUsers && !$canContinueRoles)
                $this->Redirect(
                    'Login',
                    'RequestLog',
                    [
                        "Msg" => t('errors.allow_request_login')
                    ]
                );
        }

        public function Deny($usernames, $roles) {
            if(!isset($_SESSION['User'])) # Redirect to login. Requesting log.
                $this->Redirect(
                    'Login',
                    'RequestLog',
                    array(
                        "Msg" => t('errors.allow_request_login')
                    ) # args
                ); 

            $canContinueUsers = TRUE;
            if(is_array($usernames)) {
                $canContinueUsers = in_array($_SESSION['User']->GetUsername(), $usernames);
            } else $canContinueUsers = $_SESSION['User']->GetUsername() === $usernames;

            $canContinueRoles = TRUE;
            if(is_array($roles)) {
                $canContinueRoles = in_array($_SESSION['User']->GetRol(), $roles);
            } else $canContinueRoles = $_SESSION['User']->GetRol() === $roles;

            if($canContinueUsers || $canContinueRoles)
                $this->Redirect(
                    'Login',
                    'RequestLog',
                    [
                        "Msg" => t('errors.allow_request_login')
                    ]
                );
        }

        public static function RegisterAction(
                $controllerName,
                $controllerAction,
                $controllerArgs,
        
                $controllerNameFull,
                $controllerActionFull,
                $controllerArgsDecom) {
            Controller::StartSession();

            if(!isset($_SESSION['Actions'])) $_SESSION['Actions'] = [];
            $stackTrace = $_SESSION['Actions'];
            $current = [
                'Original' => [
                    'Controller' => $controllerName,
                    'Action' => $controllerAction,
                    'Args' => $controllerArgs
                ], 
                'Final' => [
                    'Controller' => $controllerNameFull,
                    'Action' => $controllerActionFull,
                    'Args' => $controllerArgsDecom
                ]
                ];

            $_SESSION['Actions'] = array_merge($current, $stackTrace);
        }

        public static function ClearActions() {
            Controller::StartSession();

            $_SESSION['Actions'] = [];
        }

        public static function IsLogged() {
            Controller::StartSession();
            return isset($_SESSION) && isset($_SESSION['User']) && $_SESSION['User'] != $GLOBALS['users'][t('*.default.username')];
        }

        public static function StartSession() {
            if(session_status() === PHP_SESSION_NONE)
                session_start();
            if(!isset($_SESSION) || !isset($_SESSION['User']))
                $_SESSION['User'] = $GLOBALS['users'][t('*.default.username')];
        }

        public static function StopSession() {
            if(session_status() === PHP_SESSION_ACTIVE)
                session_destroy();
        }
    }
?>
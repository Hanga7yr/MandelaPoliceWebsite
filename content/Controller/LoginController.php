<?php
    require_once 'Controller/Controller.php';

    class LoginController extends Controller {
        public function RequestLogAction($args) {
            echo '<p>'.var_dump($args).'</p>';
        }

        public function DefaultAction($args) {
            $newDictionary = $GLOBALS['18i'];
            $newDictionary['FrontNewLink']['text'] = ['1' => 'DictionaryChange'];

            if(isset($args['errors']))
                $this->ViewModel['login.errors'] = $args['errors'];

            $this->RenderPage('View/Login/index.html');
        }

        public function LoginAction($args) {
            if(array_key_exists('User', $args) && array_key_exists('Password', $args)) {
                $selected = null;
                $error = 1;
                foreach($GLOBALS['users'] as $filterNew) {
                    if($args['User'] === $filterNew->GetUsername()) {
                        if($args['Password'] === $filterNew->GetPassword())
                            $selected = $filterNew;
                        else $error = 2;
                    }

                    if($args['User'] === $this->ViewModel['*.identifiers.prefix'].$filterNew->GetNumberID().$this->ViewModel['*.identifiers.suffix'])
                        $selected = $filterNew;
                }

                if(isset($selected)) {
                    Controller::StartSession();

                    $_SESSION['User'] = $selected;

                    $this->Redirect(
                        null,
                        null,
                        null,
                    );
                } else {
                    $errors = [];
                    if($error == 1) array_push($errors, t('errors.login.username'));
                    if($error == 2) array_push($errors, t('errors.login.password'));

                    $this->Redirect(
                        'Login',
                        null,
                        [
                            'result' => 'failure',
                            'errors' => [
                                $errors
                            ]
                        ]
                    );
                }
            } else $this->Redirect(
                'Login',
                null,
                [
                    'result' => 'failure',
                    'errors' => [
                        t('errors.login.failure')
                    ]
                ]
            );
        }

        public function LogoutAction() {
            Controller::StopSession();
            $this->Redirect(
                null,
                null,
                null
            );
        }
    }
?>
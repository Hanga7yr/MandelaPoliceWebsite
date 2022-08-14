<?php
    require_once 'Controller/Controller.php';

    class DefaultController extends Controller {
        function __construct($controllerName, $controllerAction, $controllerArgs) {
            parent::__construct($controllerName, $controllerAction, $controllerArgs);

            $this->ViewModel = array_merge($this->ViewModel, [
                'index.body.frontnew' => $GLOBALS['news'][3],
                'index.body.frontnew.readmore.link' => Controller::Url('News', 'Get', ['ID' => $GLOBALS['news'][0]->GetStringID()]),
                'index.body.messages' => array_slice($GLOBALS['messages'], 0, 4),
                'index.body.news' => $GLOBALS['news'],
            ]);
        }
        public function DefaultAction($args) {
            $newDictionary = $GLOBALS['18i'];
            $newDictionary['FrontNewLink']['text'] = ['1' => 'DictionaryChange'];

            $this->RenderPage('View/index.html');
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
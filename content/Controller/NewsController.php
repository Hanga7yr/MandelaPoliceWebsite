<?php
    require_once 'Controller/Controller.php';

    class NewsController extends Controller {
        function __construct($controllerName, $controllerAction, $controllerArgs) {
            parent::__construct($controllerName, $controllerAction, $controllerArgs);

            $this->ViewModel = array_merge($this->ViewModel, [
                'index.body.news' => $GLOBALS['news'],
            ]);
        }

        public function DefaultAction($args) {
            $newDictionary = $GLOBALS['18i'];
            $newDictionary['FrontNewLink']['text'] = ['1' => 'DictionaryChange'];

            $this->RenderPage('View/News/index.html');
        }

        public function GetAction($args) {
            $selected = null;
            foreach($GLOBALS['news'] as $filterNew) {
                if($args['ID'] === $filterNew->GetStringID()
                    || $args['ID'] === $this->ViewModel['*.identifiers.prefix'].$filterNew->GetNumberID().$this->ViewModel['*.identifiers.suffix'])
                    $selected = $filterNew;
            }

            if(!isset($selected))
                $this->Error([
                    'page' => $args['ID']
                ]);
            else {
                $this->ViewModel['SelectedNew'] = $selected;
                $this->RenderPage('View/News/GetNotice.html');
            }
        }
    }
?>
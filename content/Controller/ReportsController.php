<?php
    require_once 'Controller/Controller.php';

    class ReportsController extends Controller {
        function __construct($controllerName, $controllerAction, $controllerArgs) {
            parent::__construct($controllerName, $controllerAction, $controllerArgs);

            $this->ViewModel = array_merge($this->ViewModel, [
                'index.body.reports' => $GLOBALS['reports'],
            ]);
        }

        public function DefaultAction($args) {
            $this->Allow(null, [t('users.rols.inv')]);
            $newDictionary = $GLOBALS['18i'];
            $newDictionary['FrontNewLink']['text'] = ['1' => 'DictionaryChange'];

            $this->RenderPage('View/Reports/index.html');
        }
    }
?>
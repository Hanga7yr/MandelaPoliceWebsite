<?php
    require_once 'Controller/Controller.php';

    class SearchController extends Controller {
        function __construct($controllerName, $controllerAction, $controllerArgs) {
            parent::__construct($controllerName, $controllerAction, $controllerArgs);

            $this->ViewModel = array_merge($this->ViewModel, [
                'search.body.news'      => $GLOBALS['news'],
                'search.body.reports'   => $GLOBALS['reports'],
                'search.body.messages'  => $GLOBALS['messages'],
                'search.body.users'     => $GLOBALS['users'],
            ]);
        }

        public function DefaultAction($args) {
            $newDictionary = $GLOBALS['18i'];
            $newDictionary['FrontNewLink']['text'] = ['1' => 'DictionaryChange'];

            # Maintained in case its later implemented for search
            // foreach(['news', 'reports', 'messages', 'users'] as $targetGeneral) {
            //     foreach($this->ViewModel['search.body.'.$targetGeneral] as $target) {
            //         ;
            //     }
            // }

            switch(strtolower($args)) {
                case 'hanga7yr':
                case 'hanga':
                    $this->ViewModel['SearchResult'] = 'Hello there you stranger';

                    $this->ViewModel['*.footer.socials.disabled'] = false;
                    break;
                case '':
                    $this->ViewModel['SearchResult'] = t('search.result.none');
                    break;
                default:
                    $filteredNews = [];
                    foreach($this->ViewModel['search.body.news'] as $news) {
                        $this->DefaultReportFiltering($filteredNews, $news, $args);
                    }

                    $this->ViewModel['SearchResult'] = array_merge(
                        $filteredNews    
                    );

                    if(Controller::IsLogged()) {
                        $filteredReports = [];
                        foreach($this->ViewModel['search.body.reports'] as $reports) {
                            $this->DefaultReportFiltering($filteredReports, $reports, $args);
                        }
                        $this->ViewModel['SearchResult'] = array_merge(
                            $this->ViewModel['SearchResult'],
                            $filteredReports
                        );
                    }

                    if(count($this->ViewModel['SearchResult']) == 0)
                        $this->ViewModel['SearchResult'] = t('search.result.none');
                    break;
            }

            $this->RenderPage('View/Search/index.html');
        }

        public function DefaultReportFiltering(array &$array, $value, string $search) {
            if(str_contains(strtolower($value->GetHeader()), strtolower($search)))
                array_push($array, $value);
            else {
                $found = false;
                if($value->IsContentUrl()) {
                    $contents = $value->GetContentUrl();
                    if(file_exists($contents)) {
                        $contents = file_get_contents($contents);
                        if(str_contains(strtolower($contents), strtolower($search)))
                            $found = true;
                    }
                } else {
                    $contents = $value->GetContentText();
                    if(is_array($contents)) {
                        foreach($contents as $line)
                            if(str_contains(strtolower($line), strtolower($search)))
                                $found = true;
                    } else if(is_string($contents)) {
                        if(str_contains(strtolower($contents), strtolower($search)))
                            $found = true;
                    }
                }
                
                if($found)
                    array_push($array, $value);
            }
        }
    }
?>
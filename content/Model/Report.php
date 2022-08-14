<?php
    class Report {
        private array $id;
        private string $header;
        private string $thumbnail;
        private array $resume;
        private array $content;
        private string $time;

        public function __construct(
            ?array $id = ['', ''],
            ?string $header = '',
            ?string $thumbnail = '',
            ?array $resume = [],
            ?array $content = ['url' => '', 'text' => []],
            ?string $time = ''
        ) {
            $this->id =         $id == null         ? ['', ''] : $id;
            $this->header =     $header == null     ? '' : $header;
            $this->thumbnail =  $thumbnail == null  ? '' : $thumbnail;
            $this->time =       $time == null       ? '' : $time;
            $this->resume =     $resume == null     ? [] : $resume;
            $this->content =    $content == null    ? ['url' => '', 'text' => []] : $content;
        }

        public function IsContentUrl() {
            return isset($this->content['url']) && count($this->content['text']) == 0;
        }

        public function PrintContent(bool $origin = FALSE, bool $exitOnError = FALSE) {
            $content = $this->content['text'];
            $url = $this->content['url'];

            if(!$origin) { # Take the url file
                if(isset($url) && !empty($url)) {
                    if(file_exists($url)) {
                        require_once $url;
                        return '';
                    }
                }
                if(!$exitOnError)    return $this->PrintContent(!$origin, TRUE); # Error? Then try the other...
            } else if(isset($content)) {
                if(is_array($content)) {
                    $filtered = array_filter($content);
                    if(!empty($filtered)) {
                        foreach($filtered as $line)
                            print('<p>'.$line.'</p>');
                        return '';
                    }
                }
                if(!$exitOnError)    return $this->PrintContent(!$origin, TRUE); # Error? Then try the other...
            }
            return '</p>'.t('reports.body.no_content').'</p>';
        }

        public function PrintResume($maxlength = 10) {
            $resume = '';
            foreach($this->resume as $line)
                $resume .= '<p>'.$line.'</p>';
            $strlen = strlen($resume);

            if($strlen == 0)
                print '</p>'.t('reports.body.no_content').'</p>';
            else print(substr($resume, 0, $maxlength == -1 ? $strlen : $maxlength));
        }

        public function GetID() { return $this->id; }
        public function GetStringID() { return $this->id[0]; }
        public function GetNumberID() { return $this->id[1]; }
        public function SetID(array $id) { $this->id = $id; }

        public function GetHeader() { return $this->header; }
        public function SetHeader(string $header) { $this->header = $header; }

        public function GetThumbnail() { return $this->thumbnail; }
        public function SetThumbnail(string $thumbnail) { $this->thumbnail = $thumbnail; }

        public function GetResume() { return $this->resume; }
        public function SetResume(array $resume) { $this->resume = $resume; }
        public function AddResume(string $resume) { array_push($this->resume, $resume); }

        public function GetContent() { return $this->content; }
        public function SetContent(array $content) { $this->content = $content; }

        public function GetContentText() { return $this->content['text']; }
        public function SetContentText(string $content) { $this->content['text'] = $content; }
        public function AddContentText(string $content) { array_push($this->content['text'], $content); }

        public function GetContentUrl() { return $this->content['url']; }
        public function SetContentUrl(string $content) { $this->content['url'] = $content; }

        public function GetTime() { return $this->time; }
        public function SetTime(string $time) { $this->time = $time; }
    }
?>
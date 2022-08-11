<?php
    # I don't want to complicate my life by designing and implementing a db schema.
    # So I will only make classes that will be used to locally store the data.
    # These classes will be instantiated within this file, so it can be used everywhere else.

    // require_once './model/Notice.php';
    // require_once './model/User.php';

    // $new = new Notice ();
    // $new->SetID(1);
    // $new->SetHeader('prueba');
    // $new->SetContent('asdf');
    // $new->SetImage('asdfasd');

    // echo '<h4>News</h4>';
    // echo '<p>'.var_dump($new).'</p>';

    // $new->AddContent('qwer');
    
    // echo '<p>'.var_dump($new).'</p>';

    // $user = new User();
    // $user->SetID(1);
    // $user->SetUsername('prueba');
    // $user->SetPassword('asdf');
    // $user->SetIcon('asdfasd');
    // $user->SetFirstName('asdf');

    // echo '<h4>User</h4>';
    // echo '<p>'.var_dump($user).'</p>';
    // echo $user->GetHashPassword();
    require_once 'Controller/Controller.php';
    require_once 'model/User.php';
    require_once 'model/Notice.php';

    define('users', array(

    ));

    $news = [];
    $news[0] = new Notice();
    $news[0]->SetHeader('In Memorium');
    $news[0]->SetContent('In memory of...');
    $news[0]->SetImage('/assets/img/news/0/img.png');
    define('news', $news);
    define('frontNew', constant('news')[0]);

    $messages = [];

    $messages[0] = new Notice();
    $messages[0]->SetHeader('In Memorium');
    $messages[0]->SetContent('In memory of...');

    $messages[1] = new Notice();
    $messages[1]->SetHeader('In Memorium1');
    $messages[1]->SetContent('In memory of...aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
    $messages[1]->SetTime('Updated 10m ago.');
    define('messages', $messages);
    

    define('msg', array(
        'allow_request_login' => 'In order to enter this site, you must login with the apropiate account.'
    ));

    define('18i', array(
        'Title' => 'Madela Police Department',
        'Favicon' => 'favicon.png',
        'Logo' => 'logo.png',
        'LogoAlt' => 'Mandela Police Department',
        "HeaderLogo" => ['text' => "Mandela Police Department", 'link' => 'index.php?'],
        'HeaderShowTxt' => 'Show',
        'NavItem' => [
            ['text' => 'Home', 'link' => '/index.php?', 'disabled' => False],
            ['text' => 'About', 'link' => '/index.php?Action=About', 'disabled' => False],
            ['text' => 'News', 'link' => '#', 'disabled' => False],
            ['text' => 'Services', 'link' => '#', 'disabled' => True],
        ],
        'NavItemSearch' => 'Search',
        'FrontNewLink' => ['text' => "Read More...", 'link' => '/index.php?Controller=News&Action=Show&Args=0']
    ));
?>
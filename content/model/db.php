<?php
    # I don't want to complicate my life by designing and implementing a db schema.
    # So I will only make classes that will be used to locally store the data.
    # These classes will be instantiated within this file, so it can be used everywhere else.

    require_once 'Controller/Controller.php';
    require_once 'Model/User.php';
    require_once 'Model/Report.php';

    $GLOBALS['18i'] = [
        'errors' => [
            'login' => [
                'password' => 'Invalid password.',
                'username' => 'Username not found.',
                'failure' => 'No data sent.'
            ],
            'allow_request_login' => 'In order to enter this site, you must login with the apropiate account.',
        ],
        '*' => [
            'default' => [
                'username' => 'alternate'
            ]
        ],
        'users' => [
            'rols' => [
                'none' => 'None' ,
                'inv' => 'Investigator' 
            ]
        ],
        'login' => [
            'body' => [
                'username' => 'Username',
                'password' => 'Password',
                'login' => 'Login'
            ]
        ],
        'index' => [
            'window' => [
                'title'     => 'Madela Police Department',
                'favicon'   => 'favicon.png'
            ], 
            'header' => [
                'navbar' => [
                    'brand' => [
                        'link' => 'index.php?',
                        'img' => 'logo.png',
                        'img_alt' => 'logo',
                        'text' => 'Mandela Police Department'
                    ], 
                    'items' => [
                        '0' => ['text' => 'Home'],
                        '1' => ['text' => 'Services'],
                        '2' => ['text' => 'News'],
                        '3' => ['text' => 'About'],
                        '4' => ['text' => 'Reports'],
                    ], 
                    'toggler' => ['text' => 'Show'],
                    'search' => [
                        'text' => 'Search',
                        'placeholder' => 'Search'
                    ],
                    'login' => ['text' => 'Log in'],
                    'logout' => ['text' => 'Log out'],
                ]
                ],
            'body' => [
                'frontnew' => [
                    'readmore' => [
                        'text' => 'Read more...',
                        'link' => '/index.php?Controller=News&Action=Show&Args=0'
                    ]
                ],
                'messages' => [
                    'text' => 'Messages:'
                ]
            ]
        ],
        'reports' => [
            'body' => [
                'no_content' => 'There is no data to show.'
            ]
        ],
        'search' => [
            'result' => [
                'none' => 'The search has returned nothing.'
            ],
            'body' => [
                'navbar' => 'Results'
            ]
        ]    
    ];

    $GLOBALS['Dictionary'] = $GLOBALS['18i'];

    function t($txt) {
        if(!isset($txt)) return 'error_str_not_found';

        if(is_string($txt) && substr_count($txt, '.') > 0) {
            $structure = preg_split('/[.]/', $txt);

            $level = $GLOBALS['Dictionary'];

            foreach($structure as $keyword) {
                if(isset($level) && is_array($level)) {
                    if(array_key_exists($keyword, $level))
                        $level = $level[$keyword];
                    else {
                        $level = $txt;
                        break;
                    }
                } else $level = $txt;
            }
            return $level;
        }
    }


    $users = [];

    $users[t('*.default.username')] = new User();
    $users[t('*.default.username')]->SetID(['', '0']);
    $users[t('*.default.username')]->SetUsername(t('*.default.username'));
    $users[t('*.default.username')]->SetPassword('');
    $users[t('*.default.username')]->SetIcon('');
    $users[t('*.default.username')]->SetRol(t('users.rols.none'));
    
    $users[0] = new User();
    $users[0]->SetID(['that', '1']);
    $users[0]->SetUsername('ThatcherDavis92');
    $users[0]->SetPassword('a');
    $users[0]->SetIcon('');
    $users[0]->SetRol(t('users.rols.inv'));

    $GLOBALS['users'] = $users;

    # Random urls are made with https://www.lastpass.com/es/features/password-generator
    # No symbols, 8 length
    $news = [];

    $news[0] = new Report(
        ['7s3ANhV0', 0],
        'LOCAL LITTLE LEAGUE SOCCER FINALS',
        'assets\img\news\1\brightonbunnies.png',
        null,
        null,
        '07-03-04'
    );
    $news[0]->AddResume('Support your local soccer team on July 21 at St. John Field!');
    $news[0]->AddContentText('Support your local soccer team on July 21 at St. John Field!');
    $news[0]->AddContentText('ADMISSION ONLY $5');
    $news[0]->AddContentText('Concessions not available. Bring own beverage and food.');

    $news[1] = new Report(
        ['Mr8r1687', 1],
        'MANDELA POPULATION DECREASE',
        'assets\img\news\2\come again.png',
        null,
        null,
        '11-12-04'
    );
    $news[1]->AddResume('For the past week, many residents of Mandela County have been leaving for varying reasons.');
    $news[1]->AddContentText('For the past week, many residents of Mandela County have been leaving for varying reasons.');
    $news[1]->AddContentText('A survey concluded that most residents are moving to surrounding counties (Bythorne, Werksha, Yonder) to seek "Safer Living Conditions".');
    $news[1]->AddContentText('I can assure you that you are 100% safe here. There is no reason to run. Who are you running from?');

    $news[2] = new Report(
        ['N20Zvp1m', 2],
        '"SPOOKY APPARITIONS" IN THE COUNTY',
        'assets\img\news\3\spocky.png',
        null,
        null,
        '10-31-04'
    );
    $news[2]->AddResume("This doesn't mean anything. Just some fun halloween activities");
    $news[2]->AddContentText("This doesn't mean anything. Just some fun halloween activities");

    $news[3] = new Report(
        ['7s3AX5X8', 3],
        'In "Remembrance"',
        'assets\img\news\0\img.png',
        null,
        null,
        null
    );
    $news[3]->AddResume('Support your local soccer team on July 21 at St. John Field!');
    $news[3]->AddContentText('Support your local soccer team on July 21 at St. John Field!');
    $news[3]->AddContentText('ADMISSION ONLY $5');
    $news[3]->AddContentText('Concessions not available. Bring own beverage and food.');

    $GLOBALS['news'] = $news;

    $messages = [];

    $messages[0] = new Report(
        ['j1V3X5X8', 0],
        'Removed Support',
        null,
        null,
        null,
        '11-15-04'
    );
    $messages[0]->AddResume('THIS SITE WILL NO LONGER BE SUPPORTED AS OF NOV 16 2004');

    $messages[1] = new Report(
        ['v73BDo50', 1],
        'Road Conditions',
        null,
        null,
        null,
        '11-15-04'
    );
    $messages[1]->AddResume('ROAD CONDITIONS ARE DANGEROUS, DRIVE SLOW');

    $messages[2] = new Report(
        ['382yJCUo', 2],
        'CHRISTMAS PARADE',
        null,
        null,
        null,
        '11-15-04'
    );
    $messages[2]->AddResume('DEC 07 CHRISTMAS PARADE CANCELLED');

    $GLOBALS['messages'] = $messages;

    $reports = [];

    $reports[0] = new Report(
        ['Xc4559Bg', 0],
        '#00276 [A. KEISLER]',
        null,
        null,
        null,
        '07-03-04'
    );

    $reports[1] = new Report(
        ['4SC27NpW', 1],
        '#00317 [M. JOSEPH]',
        null,
        null,
        null,
        '07-03-04'
    );

    $reports[2] = new Report(
        ['x7I8Wo69', 2],
        '#00334 [L. MURRAY]',
        null,
        null,
        null,
        '07-03-04'
    );

    $reports[3] = new Report(
        ['3OEuuc96', 3],
        '#00335 [MEDIA RECOVERED FROM CASE #00334]',
        null,
        null,
        null,
        '07-03-04'
    );
    $reports[3]->AddResume('Support your local soccer team on July 21 at St. John Field!');
    $reports[3]->SetContentUrl('View/Reports/Files/report4.html');

    $reports[4] = new Report(
        ['fu0X29cx', 4],
        '#00364 [BYTHORNE PARANORMAL SOCIETY]',
        null,
        null,
        null,
        '07-03-04'
    );
    $reports[4]->AddResume('Support your local soccer team on July 21 at St. John Field!');
    $reports[4]->SetContentUrl('View/Reports/Files/report5.html');

    $reports[5] = new Report(
        ['586Tf1M0', 5],
        '#00389 [H. JOHNSON]',
        null,
        null,
        null,
        '07-03-04'
    );

    $reports[6] = new Report(
        ['3W237eIo', 6],
        '#00432 [M. HEATHCLIFF / C. TORRES]',
        null,
        null,
        null,
        '07-03-04'
    );
    $reports[6]->AddResume('Support your local soccer team on July 21 at St. John Field!');
    $reports[6]->SetContentUrl('View/Reports/Files/report7.html');

    $reports[7] = new Report(
        ['vy9x6W6f', 7],
        '#00469 [M. MARSHALL]',
        null,
        null,
        null,
        '07-03-04'
    );
    $reports[7]->AddResume('Support your local soccer team on July 21 at St. John Field!');
    $reports[7]->SetContentUrl('View/Reports/Files/report8.html');

    $reports[8] = new Report(
        ['a3202Ztk', 8],
        '#0000000000000000',
        null,
        null,
        null,
        '07-03-04'
    );
    $reports[8]->AddResume('Support your local soccer team on July 21 at St. John Field!');
    $reports[8]->SetContentUrl('View/Reports/Files/report9.html');

    // $reports[9] = new Report(
    //     ['8yB17Osh', 9],
    //     'LOCAL LITTLE LEAGUE SOCCER FINALS',
    //     'assets\img\news\1\brightonbunnies.png',
    //     null,
    //     null,
    //     '07-03-04'
    // );
    // $reports[9]->AddResume('Support your local soccer team on July 21 at St. John Field!');
    // $reports[0]->AddContentUrl('View/Reports/Files/report0.html');

    // $reports[10] = new Report(
    //     ['9Qv4IV5n', 10],
    //     'LOCAL LITTLE LEAGUE SOCCER FINALS',
    //     'assets\img\news\1\brightonbunnies.png',
    //     null,
    //     null,
    //     '07-03-04'
    // );
    // $reports[10]->AddResume('Support your local soccer team on July 21 at St. John Field!');
    // $reports[0]->AddContentUrl('View/Reports/Files/report0.html');

    $GLOBALS['reports'] = $reports;
?>
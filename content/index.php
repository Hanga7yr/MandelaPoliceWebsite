<?php
    require_once 'Model/db.php';
    Controller::StartSession();

    $defaultController = 'Default';
    $defaultAction = 'Default';

    # Set a default ControllerName, just in case something happens with the checks.
    $controllerName = $defaultController;
    $controllerAction = $defaultAction;
    $controllerArgsSession = isset($_SESSION['Args']);
    $controllerArgs = $controllerArgsSession ? $_SESSION['Args'] : '';
    $controllerArgsDecom = null;
    $pathToController = 'Controller';

    switch($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if(isset($_GET['Controller']))  $controllerName = $_GET['Controller'];
            if(isset($_GET['Action']))      $controllerAction = $_GET['Action'];
            if(isset($_GET['Args']))        $controllerArgs = $_GET['Args'];
        case 'POST':
            # Take priority with post data rather than with get
            if(isset($_POST['Controller']))     $controllerName = $_POST['Controller'];
            if(isset($_POST['Action']))         $controllerAction = $_POST['Action'];
            if(isset($_POST['Args']))           $controllerArgs = $_POST['Args'];
            break;
        default:
            break;
    }

    # Allow Rules
    $controllerNameAllowed = FALSE;
    switch($controllerName) {
        case 'Default':
        case 'Reports':
        case 'News':
        case 'Login':
        case 'Services':
        case 'Search':
            $controllerNameAllowed = TRUE;
            break;
        default:
            $controllerNameAllowed = FALSE;
            break;
    }

    # Is the proper controller?
    if(!$controllerNameAllowed || !file_exists($pathToController.'/'.$controllerName.'Controller.php')) {
        $pathToController = $pathToController.'/'.$defaultController.'Controller.php';
        $controllerName = $defaultController;
    } else $pathToController = $pathToController.'/'.$controllerName.'Controller.php';

    # Process Controller ACtions arguments
    if(!empty($controllerArgs) && !$controllerArgsSession)
        $controllerArgsDecom = parse_url($controllerArgs);
    else $controllerArgsDecom = $controllerArgs;
    
    # Create said controller, with information about itself and the actions to perform.
    require_once $pathToController;
    $controllerNameFull = $controllerName.'Controller';
    $controller = new $controllerNameFull(
        $controllerName,
        $controllerAction,
        $controllerArgsDecom
    );

    # Is there a proper method?
    $controllerActionFull = null;
    if(!method_exists($controller, $controllerAction.'Action')) $controllerActionFull = $defaultAction.'Action';
    else                                                        $controllerActionFull = $controllerAction.'Action';


    $controller->$controllerActionFull($controllerArgsDecom);
    $controller->RegisterAction(
        $controllerName,
        $controllerAction,
        $controllerArgs,

        $controllerNameFull,
        $controllerActionFull,
        $controllerArgsDecom
    );
?>
<?php
    require_once('../functions.php');
    require_once('includes/actions.php');
    require_once('../mailer.php');

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $action = isset($_GET['action']) ? urlencode($_GET['action']) : 'stats';
        $subAction = (isset($_GET['sub'])) ? urlencode($_GET['sub']) : '';
        if(!isset($_GET['sub']) || empty($subAction)){
            switch($action){
                case 'about-services':
                    $subAction = isset($_GET['sub']) ? urlencode($_GET['sub']) : 'about';
                    break;
                case 'galleries':
                    $subAction = isset($_GET['sub']) ? urlencode($_GET['sub']) : 'site-images';
                    break;
        
                case 'stats':
                    $subAction = isset($_GET['sub']) ? urlencode($_GET['sub']) : 'statistics';
                    break;
                case 'users':
                    $subAction = isset($_GET['sub']) ? urlencode($_GET['sub']) : 'all-users';
                    break;
                default:
                    break;
            }
        }
        
        switch($action){
            case 'about-services':
                echo about($action,$subAction);
                break;
            case 'galleries':
                echo galleries($action,$subAction);
                break;
    
            case 'stats':
                echo stats($action,$subAction);
                break;
            case 'users':
                echo users($action,$subAction);
                break;
            default:
                http_response_code(403);
                $status = array('success' => false);
                $status['error_code'] = '403';
                $status['error'] = 'Wrong action'.$action;
                $status['message'] = 'Specify an action, e.g an action = stats';
                echo json_encode($status);
                break;
        }
    }else{
        http_response_code(405);
        $status = array('success' => false);
        $status['error_code'] = '405';
        $status['error'] = 'Wrong endpoint';
        $status['message'] = 'Use GET instead';
        die(json_encode($status));
    }

?>
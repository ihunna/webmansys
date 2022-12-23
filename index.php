<?php 
    require_once('functions.php');
    require_once('includes/actions.php');
    
    if(empty($_SESSION['user_id']) || $_SESSION['status'] === 'blocked'){
        redirect('login.php');
    }
    
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
    
    require_once('includes/header.php');
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
            echo  '<div class="alert-box" 
                    style="text-align:center; font-weight:500; background-color:#ff3860; bottom:0">
                    Wrong action specified
            </div>';
            break;
    }

    require_once('includes/footer.php');
?>
    
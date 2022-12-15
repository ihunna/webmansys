<?php
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $name_tag =  strtoupper(str_split($username)[0]);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | <?php echo site_name?></title>
        <?php
            require_once('tags.php');
        ?>
    </head>
<body>
    <div class="top-bar">
        <div class="top-bar-header">
            <h2>
                Admin panel
            </h2>
        </div>
       
        <ul class="top-bar-list">
            <li class="top-bar-item" id="profile-link">
                <?php
                echo'
                <span class="top-bar-item">'.$name_tag.'</span>
                '.$username.'
                <div class="short-p-details" id="short-p-details">
                    <h4>'.$username.'</h4>
                    <p>'.$email.'</p>
                    <br>
                    <div href="" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout </div>
                </div>';
                ?>
            </li>
            <li class="top-bar-item logout">
                <i class="fa-solid fa-right-from-bracket"></i> Logout 
            </li>
        </ul>
        <button id="menu-btn">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <div class="menu-sm">
            <div class="overlay"></div>
            <ul class="side-bar-sm">
                <div class="short-p-details-sm">
                    <?php
                     echo'<div class="p-picture">
                        <span>'.$name_tag.'</span>
                    </div>
                    <div class="short-p-details" id="short-p-details">
                        <h4>'.$username.'</h4>
                        <p>'.$email.'</p>
                        <div class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout </div>
                    </div>';
                    ?>
                </div>
                <ul class="side-bar-sm-list">
                    <li class="side-bar-item" id="about-btn">
                        <div class="side-bar-item-btn">
                            About/Services <i class="<?php if($action == 'about-services'){echo 'fa-solid fa-angle-up';}else{echo 'fa-solid fa-angle-down ';}?>"></i>
                        </div>
                        <ul class="side-bar-submenu <?php if($action == 'about-services'){echo 'show';}?>" id="about-ul">
                            <li  class="side-bar-submenu-item <?php if($subAction == 'about'){echo 'active';}?>">
                                <a href="index.php?action=about-services&sub=about" >
                                    About
                                </a>
                            </li>
                            <li class="side-bar-submenu-item <?php if($subAction == 'style'){echo 'active';}?>">
                                <a  href="index.php?action=about-services&sub=style">
                                    Style
                                </a>
                            </li>
                            <li  class="side-bar-submenu-item <?php if($subAction == 'unique'){echo 'active';}?>">
                                <a  href="index.php?action=about-services&sub=unique">
                                    Unique
                                </a>
                            </li>
                            <li  class="side-bar-submenu-item <?php if($subAction == 'team-work'){echo 'active';}?>">
                                <a  href="index.php?action=about-services&sub=team-work">
                                    Team Work
                                </a>
                            </li>
                            <li  class="side-bar-submenu-item <?php if($subAction == 'support'){echo 'active';}?>">
                                <a  href="index.php?action=about-services&sub=support">
                                    Support
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="side-bar-item" id="gal-btn">
                        <div class="side-bar-item-btn">
                            Galleries <i class="<?php if($action == 'galleries'){echo 'fa-solid fa-angle-up';}else{echo 'fa-solid fa-angle-down ';}?>"></i>
                        </div>
                        <ul class="side-bar-submenu <?php if($action == 'galleries'){echo 'show';}?>" id="gal-ul">
                            <li  class="side-bar-submenu-item <?php if($subAction == 'site-images'){echo 'active';}?>">
                                <a href="index.php?action=galleries&sub=site-images">
                                   Site-images
                                </a>
                            </li>
                            <li  class="side-bar-submenu-item <?php if($subAction == 'tatoos'){echo 'active';}?>">
                                <a href="index.php?action=galleries&sub=tatoos">
                                    Tatoos
                                </a>
                            </li>
                            <li  class="side-bar-submenu-item <?php if($subAction == 'paintings'){echo 'active';}?>">
                                <a href="index.php?action=galleries&sub=paintings">
                                    Paintings
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="side-bar-item">
                        <a href="index.php?action=stats" class="side-bar-item-btn">
                            Statistics <i class="<?php if($action == 'stats'){echo 'fa-solid fa-angle-up';}else{echo 'fa-solid fa-angle-down ';}?>"></i>
                        </a>
                    </li>
                    <li class="side-bar-item">
                        <a href="index.php?action=users" class="side-bar-item-btn">
                            Users <i class="<?php if($action == 'users'){echo 'fa-solid fa-angle-up';}else{echo 'fa-solid fa-angle-down ';}?>"></i>
                        </a>
                    </li>
                </ul>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="side-bar-section">
            <div class="side-bar">
                <ul class="side-bar-list">
                    <li class="side-bar-item" id="about-btn">
                        <div class="side-bar-item-btn">
                            About/Services <i class="<?php if($action == 'about-services'){echo 'fa-solid fa-angle-up';}else{echo 'fa-solid fa-angle-down ';}?>"></i>
                        </div>
                        <ul class="side-bar-submenu <?php if($action == 'about-services'){echo 'show';}?>" id="about-ul">
                            <li  class="side-bar-submenu-item <?php if($subAction == 'about'){echo 'active';}?>">
                                <a href="index.php?action=about-services&sub=about" >
                                    About
                                </a>
                            </li>
                            <li class="side-bar-submenu-item <?php if($subAction == 'style'){echo 'active';}?>">
                                <a  href="index.php?action=about-services&sub=style">
                                    Style
                                </a>
                            </li>
                            <li  class="side-bar-submenu-item <?php if($subAction == 'unique'){echo 'active';}?>">
                                <a  href="index.php?action=about-services&sub=unique">
                                    Unique
                                </a>
                            </li>
                            <li  class="side-bar-submenu-item <?php if($subAction == 'team-work'){echo 'active';}?>">
                                <a  href="index.php?action=about-services&sub=team-work">
                                    Team Work
                                </a>
                            </li>
                            <li  class="side-bar-submenu-item <?php if($subAction == 'support'){echo 'active';}?>">
                                <a  href="index.php?action=about-services&sub=support">
                                    Support
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="side-bar-item" id="gal-btn">
                        <div class="side-bar-item-btn">
                            Galleries <i class="<?php if($action == 'galleries'){echo 'fa-solid fa-angle-up';}else{echo 'fa-solid fa-angle-down ';}?>"></i>
                        </div>
                        <ul class="side-bar-submenu <?php if($action == 'galleries'){echo 'show';}?>" id="gal-ul">
                            <li  class="side-bar-submenu-item <?php if($subAction == 'site-images'){echo 'active';}?>">
                                <a href="index.php?action=galleries&sub=site-images">
                                   Site-images
                                </a>
                            </li>
                            <li  class="side-bar-submenu-item <?php if($subAction == 'tatoos'){echo 'active';}?>">
                                <a href="index.php?action=galleries&sub=tatoos">
                                    Tatoos
                                </a>
                            </li>
                            <li  class="side-bar-submenu-item <?php if($subAction == 'paintings'){echo 'active';}?>">
                                <a href="index.php?action=galleries&sub=paintings">
                                    Paintings 
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="side-bar-item">
                        <a href="index.php?action=stats" class="side-bar-item-btn">
                            Statistics <i class="<?php if($action == 'stats'){echo 'fa-solid fa-angle-up';}else{echo 'fa-solid fa-angle-down ';}?>"></i>
                        </a>
                    </li>
                    <li class="side-bar-item">
                        <a href="index.php?action=users" class="side-bar-item-btn">
                            Users <i class="<?php if($action == 'users'){echo 'fa-solid fa-angle-up';}else{echo 'fa-solid fa-angle-down ';}?>"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-section">
            <div class="overlay-main">
                <div class="loader">
                    <div class="progress">
                        <div class="progress-bar"></div>
                    </div>
                </div>
            </div>
            <div class="header">
                <?php
                    $links = array_values($_GET);
                    echo '<div class="link-track">';
                    echo '<a href="index.php?action='.$action.'">'.ucfirst($action).'</a>';
                    if(count($links) < 2){
                        echo '
                        <span> ></span>
                        <a href="index.php?action='.$action.'&sub='.$subAction.'">'.ucfirst($subAction).'</a>';
                    }else{
                        $keys = array_keys($_GET);
                        for($i=1; $i < count($links); $i++){
                            if($keys[$i]==='user' || $keys[$i]==='page'){continue;}
                            echo '
                            <span> ></span>
                            <a href="index.php?';
                            for($k = 0; $k < $i+1; $k++)
                            {
                                echo $keys[$k].'=' .$_GET[$keys[$k]].'&';
                            }
                            echo'">'.ucfirst( $links[$i]).'</a>';
                        }
                    }
                    echo '</div>';
                ?>
                <div class="actions">
                    <?php 
                    if ($action == 'about-services'){
                        if(!isset($_GET['whattodo'])){
                            echo '
                            <a href="'.HOST.'/index.php?action='.$action.'&sub='.$subAction.'&whattodo=edit" class="action-btn">
                                Edit <span>'.ucfirst($subAction).'</span>
                            </a>
                            ';
                        }else{

                            echo '
                            <a href="'.HOST.'/index.php?action='.$action.'&sub='.$subAction.'" class="action-btn" id="discard">
                                Discard
                            </a>
                            <div class=" action-btn save" id="save-changes">
                                Save <span>changes</span>
                            </div>
                            ';
                        }
                        }else if($action == 'galleries'){
                            echo '
                            <div class="action-btn" id="upload-image">
                                Upload image
                            </div>
                            ';
                        }else if($action == 'users' || $action == 'stats'){
                            echo '
                                <div class="action-btn">
                                    '.ucfirst($_SESSION['privilege']).'
                                </div>
                                ';
                        }
                    ?>
                </div>
            </div>
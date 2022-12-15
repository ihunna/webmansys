<?php 
    require_once('functions.php');
    if(empty($_SESSION['user_id'])){
        redirect('login.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Home | BLABLA</title>
        <meta charset="utf-8">
        <meta http-equiv="refresh" content="3600">
        <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
        <META HTTP-EQUIV="EXPIRES" CONTENT="Mon, 20 Feb 2012 00:00:01 GMT">
        <meta name="description" content=" Tattoo artist, located in Duisburg Germany">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!--css for account-->
        <link rel="stylesheet" href="./css/account.style.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="css/fontAwesome.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&amp;display=swap" rel="stylesheet">
        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
        <!-- Desperate try to bust the Cache :) -->
        <script>
            setTimeout(function () { window.location.reload(true); }, 60 * 60 * 1000);
        </script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-0NNQ4WG8BM"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }
            gtag('js', new Date());

            gtag('config', 'G-0NNQ4WG8BM');
        </script>
    </head>
    <body>
        <div class="profile-div">
            <div class="profile-card">
                <form action="index-tmp.php" method="post" class="profile-details">
                    <?php
                        if(isset($_POST) && isset($_POST['logout'])){
                            echo  '<div class="successful">
                            You have been logged out
                            </div>';
                            logout();
                        }
                        $user_id = $_SESSION['user_id'];
                        $user = stmtselect("SELECT * FROM users WHERE uid=? LIMIT 1",[$user_id]);
                        if($user){
                            echo '<div>
                            '.$user['username'].' 
                            </div>';
                            echo '<div>
                            '.$user['email'].' 
                            </div>';
                        }
                    ?>
                    <input type="submit" class="logout" name="logout" value="Logout">
                    </form>
            </div>
        </div>

        <script src="./js/account.settings.js?v=<?php echo time(); ?>"></script>
    </body>
</html>
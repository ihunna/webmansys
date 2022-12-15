<?php 
    require_once('functions.php');

    if(isset($_SESSION['loggedin'])){
       redirect('index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Recover password | BLABLA</title>
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
<body class="">
    <div class="form-div">
        <div class="left-display-div-background">
            <div class="left-display-div-overlay">
                <span>
                    <h2 class="">
                        Recover your forgotten password
                    </h2>
                    <p class="">Enter your email address to get your account</p>
                </span>
            </div>
        </div>
        <form action="recover-password.php" method="post">
            <div class="form-holder">
                <span class="header-sm">
                    <h4 class="">
                        Recover your forgotten password
                    </h4>
                    <p class="">Enter your email address to get your account</p>
                </span>
            <input type="hidden" id="g-token" name="g-token">
            <?php 
                 if(isset($_POST) && isset($_POST['email']) && isset($_POST['g-token'])){
                    $email = $_POST['email'];
                    $token = $_POST['g-token'];
                    
                    // check if captcha is valid
                    if(check_captcha($token)){
                        //check if user exists
                        $result = stmtselect("SELECT email FROM users WHERE email=? LIMIT 1",[$email]);
                            if($result){
                                if($result['email'] === $email){
                                    $v_code = md5(rand());
                                    $success = stmtupdate("UPDATE users set v_code=? WHERE email=?",[$v_code,$email]);
                                    if($success){
                                        echo '<div class="successful">
                                                A verification link has been sent to your email.
                                            </div>';
                                    }else{
                                        echo '<div class="unsuccessful">
                                                Something went wrong, try again.
                                            </div>';
                                    }
                                }else{
                                    echo  '<div class="unsuccessful">';
                                    echo 'Account does not exist';
                                    echo '</div>';
                                }
                            }else{
                                echo  '<div class="unsuccessful">';
                                echo 'Account does not exist';
                                echo '</div>';
                            }
                    }else{
                        echo  '<div class="unsuccessful">';
                        echo 'Invalid captcha';
                        echo '</div>';
                    }
                }else if(isset($_POST) && isset($_POST['token']) && isset($_POST['checkEmail']) && isset($_POST['g-token'])){
                    $email = $_POST['checkEmail'];
                    $password = $_POST['password'];
                    $cpassword = $_POST['cpassword'];
                    $token = $_POST['g-token'];
                    $v_token = $_POST['token'];
                    // check if captcha is valid
                    if(check_captcha($token)){
                        //validating input
                        if(validate($email,$password,'','','login')[1]){
                            if($password != $cpassword){
                                $error = 1;
                               return(redirect("recover-password.php?token=$v_token&email=$email&error=$error"));
                            }
                            $v_code = stmtselect("SELECT v_code FROM users WHERE email=? LIMIT 1",[$email])['v_code'];
                            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                            if($v_code === $v_token){
                                try{
                                    $new_token = md5(rand());
                                    stmtupdate("UPDATE users SET password=? WHERE email=?",[$hashed_password,$email]);
                                    stmtupdate("UPDATE users SET v_code=? WHERE email =?",[$new_token,$email]);
                                    echo '<div class="successful">
                                        Password updated <a href="login.php">Login<a>
                                    </div>';
                                    redirect_delay(2,'login.php');
                                }catch(Exception $e){
                                    echo '<div class="unsuccessful">
                                        Something went wrong
                                    </div>';
                                }
                            }else{
                                echo  '<div class="unsuccessful">';
                                echo 'Invalid token';
                                echo '</div>';
                            }
                        }else if(!validate($email,$password,'','','login')[1]){
                            $errors = validate($email,$password,'','','login')[0];
                            echo  '<div class="unsuccessful">';
                            foreach($errors as $e){
                                echo ' '.$e.'.  ';
                            }
                            echo '</div>';
                        }
                    }else{
                        echo  '<div class="unsuccessful">';
                        echo 'Invalid captcha';
                        echo '</div>';
                    }
                }else if(isset($_GET['token'])){
                    if(isset($_GET['error'])){
                        echo '<div class="unsuccessful">
                        Passwords does not match
                        </div>';
                    }
                    echo '
                        <input type="hidden" name="token" value="'.$_GET['token'].'" readonly>
                        <div class="input-control">
                            <label for="checkEmail">Email</label>
                            <input type="email" name="checkEmail" value="'.$_GET['email'].'" readonly>
                            <div class="error"></div>
                        </div>
                        <div class="input-control">
                            <label for="password">New password</label>
                            <input type="password" name="password" id="password">
                            <div class="error"></div>
                        </div>
                        <div class="input-control">
                            <label for="cpassword">New password</label>
                            <input type="password" name="cpassword" id="cpassword">
                            <div class="error"></div>
                        </div>
                        <div class="form-footer-flex">
                            <div>
                                Not registered? <a href="signup.php">Signup</a>
                            </div>
                            <div>
                                Already have an account? <a href="login.php">Login</a>
                            </div>
                        </div>
                        <input class="submit-btn" type="submit" value="Change password">
                        </form>
                        </div>
                        <script src="https://www.google.com/recaptcha/api.js?render=6Ldba6kiAAAAAD9ugFtg1QJwxUqMV_b1cuHQSuoJ"></script>
                        <script src="./js/account.settings.js?v=<?php echo time(); ?>"></script>
                    </body>
                    </html>';
                    die();
                }
            ?>
                <div class="input-control">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email">
                    <div class="error"></div>
                </div>
                <div class="form-footer-flex">
                    <div>
                        Not registered? <a href="signup.php">Signup</a>
                    </div>
                    <div>
                        Already have an account? <a href="login.php">Login</a>
                    </div>
                </div>
                <input class="submit-btn" type="submit" value="Change password">
            </div>
        </form>
    </div>
    <script src="https://www.google.com/recaptcha/api.js?render=6Ldba6kiAAAAAD9ugFtg1QJwxUqMV_b1cuHQSuoJ"></script>
    <script src="./js/account.settings.js?v=<?php echo time(); ?>"></script>
</body>
</html>
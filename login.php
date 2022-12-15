<?php 
    require_once('functions.php');
    require_once('tracking.php');

    if(isset($_SESSION['loggedin']) && $_SESSION['status'] !== 'blocked'){
       redirect('index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | <?php echo site_name?></title>
    <?php
         require_once('includes/tags.php');
    ?>
</head>
<body class="">
    <div class="form-div">
        <div class="left-display-div-background">
            <div class="left-display-div-overlay">
                <span>
                    <h2 class="">
                        Login to manage your account
                    </h2>
                    <p class="">Enter every detail correctly</p>
                </span>
            </div>
        </div>
        <form action="login.php" method="post" id="login-form">
            <div class="form-holder">
            <span class="header-sm">
                    <h4 class="">
                        Login to manage your account
                    </h4>
                    <p class="">Enter every detail correctly</p>
                </span>
            <?php 
                 if(isset($_POST) && isset($_POST['password']) && isset($_POST['g-token'])){
                    $email = $_POST['email'];
                    $password =$_POST['password'];
                    $token = $_POST['g-token'];
                    
                    // check if captcha is valid
                    if(check_captcha($token)){
                        //check if inputs are valid and login if valid
                        if(validate($email,$password,'','','login')[1]){
                            //check if user exists
                            $result = stmtselect("SELECT * FROM users WHERE email=? LIMIT 1",[$email]);
                            if($result){
                                if(password_verify($password,$result['password'])){
                                    $_SESSION['user_id'] = $result['user_id'];
                                    $_SESSION['email'] = $result['email'];
                                    $_SESSION['username'] = $result['username'];
                                    $_SESSION['status'] = $result['status'];
                                    $_SESSION['privilege'] = $result['privilege'];
                                    $_SESSION['loggedin'] = true;
                                    if($result['status'] === 'blocked'){
                                        echo  '<div class="unsuccessful">
                                            Sorry, you have been blocked.
                                        </div>';
                                    }else{
                                        stmtupdate("UPDATE users 
                                                    SET last_seen = CURRENT_TIMESTAMP 
                                                    WHERE user_id =?",[$result['user_id']]);
                                        echo  '<div class="successful">
                                                Login successful
                                            </div>';
                                        redirect_delay(2,'index.php');
                                    }
                                }else{
                                    echo  '<div class="unsuccessful">
                                            Incorrect password
                                            </div>';
                                }
                            }else{
                                echo  '<div class="unsuccessful">
                                        Account does not exist
                                        </div>';
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
                        echo  '<div class="unsuccessful">
                                Invalid captcha
                                </div>';
                    }
                }
            ?>
                <input type="hidden" id="g-token" name="g-token">
                <div class="input-control">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email">
                    <div class="error"></div>
                </div>
                <div class="input-control">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password">
                    <div class="error"></div>
                </div>
                <div class="form-footer-flex">
                    <div>
                        Not registered? <a href="signup.php">Signup</a>
                    </div>
                    <a href="recover-password.php">
                       Forgot password?
                    </a>
                </div>
                <input class="submit-btn" type="submit" name="login-btn" value="Login">
            </div>
        </form>
    </div>

    <!-- google recatpcha -->
    <script src='https://www.google.com/recaptcha/api.js?render=<?php echo site_key;?>'></script>
    
    <!-- input validation -->
    <script>
        window.addEventListener('load',()=>{
            //asigning captcha token
            try{
            grecaptcha.ready(function() {
                grecaptcha.execute('<?php echo site_key; ?>', {action: 'submit'}).then(function(token) {
                    document.getElementById('g-token').value = token;
                    });
                });
            }catch(error){
                console.log(error);
            }
            const lform = document.getElementById('login-form');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            
            lform.addEventListener('submit', e => {
                e.preventDefault();
                if(validateInputs(lform) > 1){
                    lform.submit();
                };
            });
    
            const setError = (element, message) => {
                const inputControl = element.parentElement;
                const errorDisplay = inputControl.querySelector('.error');
    
                errorDisplay.innerText = message;
                inputControl.classList.add('error');
                inputControl.classList.remove('success')
            }
    
            const setSuccess = element => {
                const inputControl = element.parentElement;
                const errorDisplay = inputControl.querySelector('.error');
    
                errorDisplay.innerText = '';
                inputControl.classList.add('success');
                inputControl.classList.remove('error');
            };
    
            const isValidEmail = email => {
                const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            }
    
            const validateInputs = (form) => {
                let count = 0;
                const emailValue = email.value.trim();
                const passwordValue = password.value.trim();
    
                if(emailValue === '') {
                    setError(email, 'Email is required');
                    count --;
                } else if (!isValidEmail(emailValue)) {
                    setError(email, 'Provide a valid email address');
                    count --;
                } else {
                    setSuccess(email);
                    count ++;
                }
    
                if(passwordValue === '') {
                    setError(password, 'Password is required');
                    count --;
                } else if (passwordValue.length < 8 ) {
                    setError(password, 'Password must be at least 8 character.')
                    count --;
                } else {
                    setSuccess(password);
                    count ++;
                }
            return count;
            }
        });
    </script>
</body>
</html>
<?php 
    require_once('functions.php');

    if(isset($_SESSION['loggedin'])){
       redirect('login.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Signup | <?php echo site_name?></title>
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
                        Signup to manage your account
                    </h2>
                    <p class="">Enter every detail correctly</p>
                </span>
            </div>
        </div>
        <form action="signup.php" method="post" id="signup-form">
            <div class="form-holder">
                <span class="header-sm">
                    <h4 class="">
                        Signup to manage your account
                    </h4>
                    <p class="">Enter every detail correctly</p>
                </span>
            <?php 
                 if(isset($_POST) && isset($_POST['username']) && isset($_POST['g-token'])){
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $cpassword = $_POST['c-password'];
                    $token = $_POST['g-token'];

                    if(count_rows("SELECT Count(*) FROM users WHERE status=?",['active'])[1] >= MAX_REG){
                        echo  '<div class="unsuccessful">
                                   Number of registrations exceeded, max '.MAX_REG.'.
                                </div>';
                    }else{
                        // check if captcha is valid
                        if(check_captcha($token)){
                        if(validate($email,$password,$username,$cpassword,'signup')[1]){
                            //check for duplicate email
                            $emails = stmtselect("SELECT email FROM users WHERE email=?",[$email]);
                            if(!$emails){
                                //inserting a new user into db
                                $v_code = md5(rand());
                                $user_id =  md5(rand());
                                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                                $success = stmtinsert("INSERT INTO 
                                users (username, email, password,status,privilege,v_code,user_id) 
                                VALUES(?,?,?,?,?,?,?)",
                                [$username,$email,$hashed_password,'active','admin',$v_code,$user_id]);
                                
                                if($success){
                                    echo  '<div class="successful">
                                        Account creation successful <a href="login.php">Login<a>
                                        </div>';
                                }
        
                                redirect_delay(2,'login.php');
                            }else{
                                echo  '<div class="unsuccessful">
                                        Email already exists
                                        </div>';
                            }
                        }else if(!validate($email,$password,$username,$cpassword,'signup')[1]){
                            $errors = validate($email,$password,$username,$cpassword,'signup')[0];
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
                }
            ?>
                <input type="hidden" id="g-token" name="g-token">
                <div class="input-control">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username">
                    <div class="error"></div>
                </div>
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
                <div class="input-control">
                    <label for="c-password">Confirm password</label>
                    <input type="password" name="c-password" id="c-password">
                    <div class="error"></div>
                </div>
                <div class="form-footer-flex">
                    <div>
                        Already have an account? <a href="login.php">Login</a>
                    </div>
                </div>
                <input class="submit-btn" type="submit" name="signup-btn" value="Register">
            </div>
        </form>
    </div>

    <!-- google recatpcha -->
        <script src='https://www.google.com/recaptcha/api.js?render=<?php echo site_key;?>'></script>

    <!-- input validation -->
    <script>
        // console.log(site_key)
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
            const sform = document.getElementById('signup-form');
            const lform = document.getElementById('login-form');
            const username = document.getElementById('username');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const cpassword = document.getElementById('c-password');
    
            sform.addEventListener('submit', e => {
                e.preventDefault();
                if(validateInputs(sform) > 3){
                    sform.submit();
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
            
                const usernameValue = username.value.trim();
                const emailValue = email.value.trim();
                const passwordValue = password.value.trim();
                const cpasswordValue = cpassword.value.trim();
    
                if(usernameValue === '') {
                    setError(username, 'Username is required');
                    count --
                } else if(usernameValue.length < 8 || usernameValue.length > 20){
                    setError(username, 'Username should be between 8 and 20 chars');
                    count --
                } else {
                    setSuccess(username);
                    count ++
                }
    
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
                } else if(passwordValue.length < 8 ) {
                    setError(password, 'Password must be at least 8 character.')
                    count --;
                } else {
                    setSuccess(password);
                    count ++;
                }
    
                if(cpasswordValue === '') {
                    setError(cpassword, 'Please confirm your password');
                    count --;
                } else if (cpasswordValue !== passwordValue) {
                    setError(cpassword, "Passwords doesn't match");
                    count --;
                } else {
                    setSuccess(cpassword);
                    count ++;
                }
            return count;
        }
        });
    </script>
</body>
</html>
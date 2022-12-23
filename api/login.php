<?php
     require_once('../functions.php');

     function login_api($email,$password){
        $status = array('success' => false);

         //check if inputs are valid and login if valid
         if(validate($email,$password,'','','login')[1]){
            //check if user exists
            $result = stmtselect("SELECT * FROM users WHERE email=? LIMIT 1",[$email]);
            if($result){
                if(password_verify($password,$result['password'])){
                    if($result['status'] === 'blocked'){
                        http_response_code(403);
                        $status['error'] = 'Not authorised';
                        $status['error_code'] = 403;
                        $status['message'] = 'You have been blocked';
                    }else{
                        stmtupdate("UPDATE users 
                                    SET last_seen = CURRENT_TIMESTAMP 
                                    WHERE user_id =?",[$result['user_id']]);

                        $a_token = md5(rand());
                        try{
                            $check_token = count_rows("SELECT COUNT(*) FROM access_tokens WHERE user_id =?",[$result['user_id']])[1];
                            if($check_token <= 0){
                                //Adding access token for this user
                                stmtinsert("INSERT INTO 
                                access_tokens (token, user_id,expires_at) 
                                VALUES(?,?,NOW() + INTERVAL 48 HOUR)",
                                [$a_token,$result['user_id']]);
                            }else{
                                $token = stmtupdate("UPDATE access_tokens 
                                SET token =?,
                                expires_at = NOW() + INTERVAL 48 HOUR
                                WHERE user_id =?",
                                [$a_token,$result['user_id']]);
                            }
                            $status['success'] = true;
                            $status['message'] = 'Login successful';
                            $status['access_token'] = $a_token;
                        }catch(Exception){
                            http_response_code(401);
                            $status['error'] = 'Error with login';
                            $status['message'] = 'Error with query';
                            $status['error_code'] = 401;
                        }
                    }
                }else{
                    http_response_code(403);
                    $status['error'] = 'Not authorised';
                    $status['error_code'] = 403;
                    $status['message'] = 'Incorrect password';
                }
            }else{
                http_response_code(403);
                $status['error'] = 'Not authorised';
                $status['error_code'] = 403;
                $status['message'] = 'Account does not exist';
            }
    
        }else if(!validate($email,$password,'','','login')[1]){
            $errors = validate($email,$password,'','','login')[0];
            http_response_code(403);
            $status['error'] = 'Not authorised';
            $status['error_code'] = 403;
            $status['message'] = json_encode($errors);
        }

        return $status;
     }

     if(($_SERVER['REQUEST_METHOD'] === 'POST') && file_get_contents('php://input')){
        $data = json_decode(file_get_contents('php://input'));
        die(json_encode(login_api($data->email,$data->password)));
    }else{
        http_response_code(405);
        $status = array('success' => false);
        $status['error_code'] = 405;
        $status['error'] = 'Wrong endpoint';
        $status['message'] = 'Use POST instead';
        die(json_encode($status));
    }
?>
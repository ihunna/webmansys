<?php
    require_once('../functions.php');

    function handledata($data,$user_id){
        $status = array('success' => false);
        if($data->type === 'textual'){
            switch($data->operation){
                case 'edit':
                    if(saveText($data,$user_id)){
                        $status['success'] = true;
                          $status['data'] = $data;
                          $status['message'] = 'Upload was successful.';
                      }else{
                          http_response_code(500);
                          $status['message'] = 'Error editing article';
                          $status['error_code'] = 500;
                      }
                      break;
                case 'delete':
                    if(deleteText($data,$user_id)){
                        $status['success'] = true;
                          $status['data'] = $data;
                          $status['message'] = 'Deleted article.';
                      }else{
                          http_response_code(500);
                          $status['message'] = 'Error deleting article';
                          $status['error_code'] = 500;
                      }
                      break;
                default:
                    http_response_code(400);
                    $status['message'] ='Invalid endpoint';
                    $status['error_code'] = 400;
                    break;
            }
        }else if($data->type === 'image'){
            switch($data->operation){
                case 'upload':
                    if(saveImage($data,$user_id)){
                        $status['success'] = true;
                        $status['data'] = $data;
                        $status['message'] = 'Upload was successful.';
                    }else{
                        http_response_code(500);
                        $status['message'] = 'Error uploading';
                        $status['error_code'] = 500;
                    }
                    break;
                case 'edit':
                    if(editImage($data,$user_id)){
                        $status['success'] = true;
                        $status['data'] = $data;
                        $status['message'] = 'Update was successful.';
                    }else{
                        global $error;
                        http_response_code(500);
                        $status['error'] = 'Error editing';
                        $status['message']= $error['message'];
                        $status['error_code'] = 500;
                    }
                    break;
                case 'delete':
                    if(deleteImage($data,$user_id)){
                        $status['success'] = true;
                        $status['data'] = $data;
                        $status['message'] = 'Deleted image';
                    }else{
                        global $error;
                        http_response_code(500);
                        $status['error'] = 'Error deleting image';
                        $status['message']= $error['message'];
                        $status['error_code'] = 500;
                    }
                    break;
                default:
                    $status['message'] = 'Choose an action to perform'; 
            }
        }else{
            http_response_code(500);
            $status['message'] = 'This form of data is not allowed in the database.';
            $status['error_code'] = 500;
        }

        return $status;
    }

    if(($_SERVER['REQUEST_METHOD'] === 'POST') && file_get_contents('php://input')){
        $data = json_decode(file_get_contents('php://input'));
        if(isset($_SESSION['loggedin'])){
            $data = $data->data;
            if(!check_captcha($data->token)){
                http_response_code(401);
                $status['message'] = 'Invalid captcha, try again.';
                $status['error_code'] = 401;
                die(json_encode($status));
            }else{
                die(json_encode(handledata($data,$_SESSION['user_id'])));
            }
        }else if($data->origin ==='api_req'){
                if(!isset($_SERVER['CONTENT_TYPE']) || $_SERVER['CONTENT_TYPE'] !== 'application/json'){
                    http_response_code(401);
                    $status['error'] = 'You are not authorised.';
                    $status['message'] = 'Accepts only json, specify content-type:application-json in the header';
                    $status['error_code'] = 401;
                    die(json_encode($status));
                }
                $u_token = (isset($_SERVER['HTTP_AUTHORISATION']))? $_SERVER['HTTP_AUTHORISATION']: false;
                if(!$u_token){
                    http_response_code(401);
                    $status['error'] = 'You are not authorised.';
                    $status['message'] = 'Access token required';
                    $status['error_code'] = 401;
                    die(json_encode($status));
                }else{
                    $u_token = str_replace('Bearer ','',$u_token);
                    $user_id = stmtselectSingle("SELECT user_id 
                    FROM access_tokens 
                    WHERE expires_at > NOW() 
                    AND token =? LIMIT 1",[$u_token]);
                    
                    if(!$user_id){
                        http_response_code(401);
                        $status['error'] = 'You are not authorised.';
                        $status['message'] = 'Invalid access token';
                        $status['error_code'] = 401;
                        die(json_encode($status));
                    }else{
                        $status = stmtselectSingle("SELECT status
                        FROM users WHERE user_id=? 
                        LIMIT 1",[$user_id]);
                        if($status && $status === 'blocked'){
                            http_response_code(401);
                            $status['error'] = 'You are not authorised.';
                            $status['message'] = 'Your account has been blocked';
                            $status['error_code'] = 401;
                            die(json_encode($status));
                        }else if(!$status){
                            http_response_code(401);
                            $status['error'] = 'You are not authorised.';
                            $status['message'] = 'Error with query';
                            $status['error_code'] = 401;
                            die(json_encode($status));
                        }
                    }
                }
                die(json_encode(handledata($data,$user_id)));
        }else{
            http_response_code(401);
            $status['message'] = 'You are not authorised.';
            $status['error_code'] = 401;
            die(json_encode($status));
        }
    }else{
        http_response_code(405);
        $status = array('success' => false);
        $status['error_code'] = 405;
        $status['error'] = 'Wrong endpoint';
        $status['message'] = 'Use POST instead';
        die(json_encode($status));
    }
   
?>
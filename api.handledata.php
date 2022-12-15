<?php
    require_once('functions.php');

    if(isset($_POST) && file_get_contents('php://input')){
        $status = array('success' => false);
        if(isset($_SESSION['loggedin'])){
            $data = json_decode(file_get_contents('php://input'));
            $data = $data -> data;
            if(!check_captcha($data->token)){
                http_response_code(401);
                $status['message'] = 'Invalid captcha, try again.';
            }else{
                if($data->type === 'textual'){
                    switch($data->operation){
                        case 'edit':
                            if(saveText($data)){
                                $status['success'] = true;
                                  $status['data'] = $data;
                                  $status['message'] = 'Upload was successful.';
                              }else{
                                  http_response_code(500);
                                  $status['message'] = saveText($data);
                                  $status['error_code'] = 500;
                              }
                              break;
                        case 'delete':
                            if(deleteText($data)){
                                $status['success'] = true;
                                  $status['data'] = $data;
                                  $status['message'] = 'Deleted article.';
                              }else{
                                  http_response_code(500);
                                  $status['message'] = deleteText($data);
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
                            if(saveImage($data)){
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
                            if(editImage($data)){
                                $status['success'] = true;
                                $status['data'] = $data;
                                $status['message'] = 'Update was successful.';
                            }else{
                                http_response_code(500);
                                $status['message'] = 'Error editing';
                                $status['error_code'] = 500;
                            }
                            break;
                        case 'delete':
                            if(deleteImage($data)){
                                $status['success'] = true;
                                $status['data'] = $data;
                                $status['message'] = 'Deleted image';
                            }else{
                                http_response_code(500);
                                $status['message'] = deleteImage($data);
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
            }
        }else{
            http_response_code(401);
            $status['message'] = 'You are not authorised.';
            $status['error_code'] = 401;
        }
        echo json_encode($status);

    }
   
?>
<?php
    require_once('config.php');
    
    function redirect($url) {
        header("Location:$url");
    }

    function redirect_delay($delay,$url) {
        header("refresh: $delay; url=$url");
    }

    //number formating 
    function num_format($num) {

        if($num>1000) {
      
              $x = round($num);
              $x_number_format = number_format($x);
              $x_array = explode(',', $x_number_format);
              $x_parts = array('k', 'm', 'b', 't');
              $x_count_parts = count($x_array) - 1;
              $x_display = $x;
              $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
              $x_display .= $x_parts[$x_count_parts - 1];
      
              return $x_display;
      
        }
      
        return $num;
      }

    function check_captcha($token){
        try{
            $secret_key = secret_key;
            $ip = $_SERVER['REMOTE_ADDR'];
            $url = "https://www.google.com/recaptcha/api/siteverify";
            $data = array('secret' => $secret_key, 'response' => $token, 'remoteip'=> $ip);
    
            // use key 'http' even if you send the request to https://...
            $options = array('http' => array(
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n", 
                'method'  => 'POST',
                'content' => http_build_query($data)
            ));
    
            $context  = stream_context_create($options);
            $result = @file_get_contents($url, false, $context);
            $response = json_decode($result);
    
            if(@$response -> success)
            {
               return true;
            }
            else
            {
                return false;
            }
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    function validate($email,$password,$username,$cpassword,$type){
        $usernameErr = $emailErr = $passwordErr = $cpasswordErr = "";
        $errors = array();
        try{
            if($type == 'signup'){
                if(empty($username)) {
                    $usernameErr = "userame is required";
                    array_push($errors,$usernameErr);
                }else if(strlen($username) < 8 || strlen($username) > 20){
                    $usernameErr = "Username should be between 8 and 20 chars";
                    array_push($errors,$usernameErr);
                }else{
                    $errors = array_diff($errors, array($usernameErr));
                }

                if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Enter a valid email";
                    array_push($errors,$emailErr);
                }else{
                    $errors = array_diff($errors, array($emailErr));                
                }
            
                if(empty($password) || strlen($password) < 8) {
                    $passwordErr = "Password is required, at least 8 characters";  
                    array_push($errors,$passwordErr);
                }else{
                    $errors = array_diff($errors, array($passwordErr));
                }
        
                if($cpassword !== $password) {
                    $cpasswordErr = "Password does not match";  
                    array_push($errors,$cpasswordErr);
                } else{
                    $errors = array_diff($errors, array($cpasswordErr));
                }
            } else{
                if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Enter a valid email";
                    array_push($errors,$emailErr);
                } else{
                    $errors = array_diff($errors, array($emailErr));
                }
            
                if (empty($password) || strlen($password) < 8) {
                    $passwordErr = "Password is required, at least 8 characters";  
                    array_push($errors,$passwordErr);
                }else{
                    $errors = array_diff($errors, array($passwordErr));
                }
            }
            if (count($errors) > 0){
                return [$errors,false];
            }else{
                return [$errors,true];
            }
        }
        catch (Exception $e){
            echo $e;
        }
    
    }

    function stmtcreate($query){
        try{
            global $db;
            $db->exec($query);
        }catch(PDOException $e){
            return $e;
        }
    }

    function stmtdelete($query,$values){
        try{
            global $db;
            $statement = $db->prepare($query);
            $result = $statement->execute($values);
            return $result;
        }catch(PDOException $e){
            return $e;
        }
    }

    function stmtinsert($query,$values){
        try{
            global $db;
            $statement = $db->prepare($query);
            $result = $statement->execute($values);
            return $result;
        }catch(PDOException $e){
            return $e;
        }
    }

    function stmtupdate($query,$values){
        try{
            global $db;
            $statement = $db->prepare($query);
            $result = $statement->execute($values);
            return $result;
        }catch(PDOException $e){
            return $e;
        }
    }
 
    function stmtselectAll($query, $values){
        try{
            global $db;
            $statement = $db->prepare($query);
            $statement->execute($values);
            $result = $statement->fetchall();
            return $result;
        }catch(PDOException $e){
            return $e;
        }
    }

    function stmtselect($query, $values){
        try{
            global $db;
            $statement = $db->prepare($query);
            $statement->execute($values);
            $result = $statement->fetch();
            return $result;
        }catch(PDOException $e){
            return $e;
        }
    }

    function count_rows($query,$values){
        try{
            global $db;
            $statement = $db->prepare($query);
            $statement->execute($values);
            $result = $statement->fetchColumn();
            return array(true,$result);
        }catch(PDOException $e){
            return array(false,$e);
        }
    }

    //creating visitors table if not exists
    stmtcreate(
        "CREATE TABLE IF NOT EXISTS visitors(
            id INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            ip VARCHAR(255) UNIQUE,
            country VARCHAR(255),
            city VARCHAR(255),
            browser  VARCHAR(255),
            os_name VARCHAR(255),
            visit_count int(255),
            status VARCHAR(255),
            visit_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )"
        );

    //creating users table if not exists
    stmtcreate(
        "CREATE TABLE IF NOT EXISTS users(
            uid INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
            username VARCHAR(20) NOT NULL,
            email VARCHAR(50) NOT NULL,
            password VARCHAR(255) NOT NULL,
            user_id VARCHAR(255) NOT NULL,
            status VARCHAR(255) NOT NULL,
            privilege VARCHAR(255) NOT NULL,
            v_code VARCHAR(255) NOT NULL,
            last_seen TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
            )"
        );
    //creating images table if not exists
    stmtcreate(
        "CREATE TABLE IF NOT EXISTS images(
          id INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
          category VARCHAR(255) NOT NULL,
          sub_category VARCHAR(255) NOT NULL,
          img_url  VARCHAR(255) NOT NULL,
          img_name VARCHAR(255) NOT NULL,
          uploaded_by VARCHAR(255) NOT NULL,
          up_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL
         )"
     ); 
    //creating textuals table if not exists
    stmtcreate(
        "CREATE TABLE IF NOT EXISTS textuals(
          id INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
          category VARCHAR(255) NOT NULL,
          sub_category VARCHAR(255)  UNIQUE NOT NULL,
          data  VARCHAR(2000) NOT NULL,
          uploaded_by VARCHAR(255) NOT NULL,
          reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL
         )"
     );  

    function get_visitor($ip){
        $result = stmtselect("SELECT * 
            FROM visitors 
            WHERE ip =?",[$ip]);
        return $result;
    }

    function saveText($data){
        $success;     
         $cat = $data->category;
         $sub_cat = $data->sub_category;
         $by = $_SESSION['user_id'];
         $data = json_encode($data->data);
         
         $rows = count_rows(
            "SELECT COUNT(*) FROM textuals 
            WHERE uploaded_by =? 
            AND sub_category =?",[$_SESSION['user_id'],$sub_cat]);

         if($rows[0]){
            $success = ($rows[1] > 0)? stmtupdate(
                "UPDATE textuals 
                SET category=?,
                sub_category =?,
                data =?,
                uploaded_by =?",
                [$cat,$sub_cat,$data,$by]):stmtinsert(
                "INSERT INTO textuals 
                (category,sub_category,data,uploaded_by) 
                VALUES(?,?,?,?)",[$cat,$sub_cat,$data,$by]);
         }else{ 
            return $rows[1];
         }
         
        return $success;
    }

    function deleteText($data){
        $result = false;
        try{
            $cat = $data -> category;
            $sub_cat = $data -> sub_category;
            $result = stmtdelete(
                "DELETE FROM textuals 
                 WHERE category =? 
                 AND sub_category =? 
                ",[$cat,$sub_cat]
            );
            return $result;
        }catch(Exception $e){
            return $e;
        }
    }

    function saveImage($data){
        $success = false;
        try{    
             $cat = $data->category;
             $sub_cat = $data->sub_category;
             $by = $_SESSION['user_id'];
             $data = $data->data;
             foreach($data as $d){
                 $folderPath = ($sub_cat == 'site-images')? img_folder .'/'. $sub_cat .'/' : img_folder .'/';
                 $img_name = $d->image_name .$d->xtension;
                 $img_url =  HOST .'/' .$folderPath  .$img_name;
                 $img_blob = $d->image_blob;
    
                 $image_parts = explode(";base64,", $img_blob);
                 $image_base64 = base64_decode($image_parts[1]);
                 $file = $folderPath . $img_name;
                 $success =  file_put_contents($file, $image_base64);
                 if($success){
                    stmtinsert("INSERT INTO images (category,sub_category,img_url,img_name,uploaded_by) 
                    VALUES(?,?,?,?,?)",[$cat,$sub_cat,$img_url, $img_name,$by]);
                 }
             }
            }catch(Exception $e){
                $success = $e->getMessage();
            }
        return $success;
    }

    function getImages($cat,$start,$end){
        $result = stmtselectAll(
            "SELECT img_url FROM images 
             WHERE sub_category=?
             ORDER BY id DESC
             LIMIT $start,$end",[$cat]
        );
        return $result;
    }

    function editImage($data){
        try{
            $sub_cat = $data->sub_category;
            $data = $data -> data[0];
            $img_name = $data -> image_name;
            $old_name = $data -> old_name;
            $img_blob = $data -> image_blob;
            $folderPath = ($sub_cat == 'site-images')? img_folder .'/'. $sub_cat .'/' : img_folder .'/';
            $new_url = HOST .'/' .$folderPath .$img_name;

            if ($img_blob !== ''){
                try{
                    unlink($folderPath .$old_name);
                    $image_parts = explode(";base64,", $img_blob);
                    $image_base64 = base64_decode($image_parts[1]);
                    $file = $folderPath . $img_name;
                    file_put_contents($file, $image_base64);
                }catch(Exception $e){
                    return $e;
                }


                $result = stmtupdate(
                    "UPDATE images 
                     SET img_url =?,img_name =?
                     WHERE img_name =?
                    ",[$new_url,$img_name,$old_name]
                );
                return $result;
            }else if($img_blob == ''){
                try{
                    rename($folderPath .$old_name,$folderPath .$img_name);
                }catch(Exception $e){
                    return $e;
                }
                $result = stmtupdate(
                    "UPDATE images 
                     SET img_url =?,img_name =?
                     WHERE img_name =?
                    ",[$new_url,$img_name,$old_name]
                );
                return $result;
            }
        }catch(Exception $e){
            return $e;
        }
    }

    function deleteImage($data){
        try{
            $data = $data -> data[0];
            $img_name = $data -> image_name;
            $folderPath = img_folder .'/';
                try{
                    unlink($folderPath .$img_name);
                }catch(Exception $e){
                    return $e;
                }


                $result = stmtdelete(
                    "DELETE FROM images 
                     WHERE img_name =?
                    ",[$img_name]
                );
                return $result;
        }catch(Exception $e){
            return $e;
        }
    }

    function send_mail($msg,$address){
        
    }

    function logout(){
        try{
            session_destroy();
            return json_encode(array('message' => 'Logout successful'));
        }catch(Execption $e){
            return json_encode(array('error' => $e, 'message' => 'Something went wrong'));
        }
    }

?>
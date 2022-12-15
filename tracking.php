<?php
    require_once('functions.php');

    trackVisitor();

    function trackVisitor(){
        try{
            //getting visitor's ip
            $ip = ($_SERVER['REMOTE_ADDR'] == '127.0.0.1')? '':$_SERVER['REMOTE_ADDR'];

            //getting visitor's location
            $ipdata = @json_decode(file_get_contents(
            "http://www.geoplugin.net/json.gp?ip=" . $ip));
            // print_r($ipdata);
            
            $ip = $_SERVER['REMOTE_ADDR'];
            $country = $ipdata -> geoplugin_countryName;
            $city = $ipdata -> geoplugin_city;

            //getting visitors browser
            $user_agent = str_replace(' ','%20',$_SERVER["HTTP_USER_AGENT"]);
            $browser = @json_decode(file_get_contents("https://www.useragentstring.com/?uas=" .$user_agent. "&getJSON=all"));
            $os_name = $browser -> os_name;
            $browser = $browser -> agent_name;
            $rows = get_visitor($ip);
            if($rows){
                //update visit count if already visted or insert new if not
                 stmtupdate(
                    "UPDATE visitors SET country =?, city =?, browser=?, os_name =?, visit_count=?
                    WHERE ip =?",
                    [$country,$city,$browser,$os_name,$rows['visit_count']+1,$ip]);
            }else{
                stmtinsert("INSERT INTO visitors
                    (ip,country,city,browser,os_name,visit_count,status)
                    VALUES (?,?,?,?,?,?,?)
                ",[$ip,$country,$city,$browser,$os_name,1,'active']);
            }
            return true;
        }catch(Exception $e){
            return false;
        }
    }

?>
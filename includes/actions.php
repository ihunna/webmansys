<?php
    function about($action,$subAction){
        global $data;
        $textual= stmtselect("SELECT * FROM textuals WHERE category =? AND sub_category=?",[$action,$subAction]);
        if(isset($_GET['whattodo'])){
            $data = ($textual)? json_decode($textual['data']) : array();
            echo '<div class="texttuals-display" id="editor">
                    <div class="instruct">
                        <p><span>1</span> &nbsp;Click the + icon to choose editor.</p>
                        <p><span>2</span> &nbsp;Click the menu icon to choose feautres.</p>
                    </div>';
                    if($data){
                        echo '<div style="padding:20px;">
                        <h4>Old '.$subAction.' data</h4>';
                        echo '<div style="border: 0.5px solid gray; padding:10px; max-height: 200px; overflow-y:scroll">';
                    foreach($data as $d){
                        if($d -> type == 'header'){
                            echo '<h'.$d -> data -> level.' class="h-header">
                                    '.$d -> data -> text.' 
                                </h'.$d -> data -> level.'>';
                            echo '<br>';
                        }else if($d -> type == 'paragraph'){
                            echo '
                                    '.$d -> data -> text.'
                                ';
                            echo '<br><br>';
                        }else if($d -> type == 'quote'){
                            echo '<q cite="">
                                    '.$d -> data -> text.' 
                                    </q> &nbsp
                                    <fig-caption style="text-align:'.$d -> data -> alignment.';width:auto">
                                    '.$d -> data -> caption.'
                                    </fig-caption>';
                            echo '<br><br>';
                        }else if($d -> type == 'list'){
                            echo'<div style="padding:0px 20px;width:100%">';
                                echo ($d -> data -> style = 'ordered')? '<ol>':'<ul>';
                                    foreach($d -> data -> items as $item){
                                        echo '<li>
                                            '.$item.'
                                        </li>';
                                    }
                                echo ($d -> data -> style = 'ordered')? '</ol>':'</ul>';
                            echo'</div>';
                            echo '<br><br>';
                        }
                   }
                   echo '</div>
                   </div>';
                    }
                    echo '<div class="save save-footer">Save</div>
                </div>';
        }else{
            echo '<div class="texttuals-display not-edit" id="texttuals-display">';
                    if($textual){
                        $data = json_decode($textual['data']);
                        foreach($data as $d){
                            if($d -> type == 'header'){
                                echo '<h'.$d -> data -> level.' class="h-header">
                                        '.$d -> data -> text.' 
                                    </h'.$d -> data -> level.'>';
                                echo '<br>';
                            }else if($d -> type == 'paragraph'){
                                echo '
                                        '.$d -> data -> text.'
                                    ';
                                echo '<br><br>';
                            }else if($d -> type == 'quote'){
                                echo '<q cite="">
                                        '.$d -> data -> text.' 
                                        </q> &nbsp
                                        <fig-caption style="text-align:'.$d -> data -> alignment.';width:auto">
                                        '.$d -> data -> caption.'
                                        </fig-caption>';
                                echo '<br><br>';
                            }else if($d -> type == 'list'){
                                echo'<div style="padding:0px 20px;width:100%">';
                                    echo ($d -> data -> style = 'ordered')? '<ol>':'<ul>';
                                        foreach($d -> data -> items as $item){
                                            echo '<li>
                                                '.$item.'
                                            </li>';
                                        }
                                    echo ($d -> data -> style = 'ordered')? '</ol>':'</ul>';
                                echo'</div>';
                                echo '<br><br>';
                            }
                       }
                    }else{
                        echo '<h2 style="width:100%;text-align:center;color:#00000080;margin-top:18%">No data, click on "Edit" to add one</h2>';
                    }
            echo '</div>';
        }
    }

    function galleries($action,$subAction){
        $page = (isset($_GET['page']))? $_GET['page'] : 0;
        $num_per_page = 8;
        $total_imgs = count_rows(
            "SELECT COUNT(*) FROM images 
            WHERE sub_category =?",
            [$subAction])[1];
        $num_links = ceil($total_imgs/$num_per_page);
        $start = $page*$num_per_page;

        $images = getImages($subAction,$start,$num_per_page);

        echo'<div class="gallery">';
        if($total_imgs > 0){
            echo '<ul class="image-list" id="image-list">';
                foreach($images as $img){
                    echo '
                    <li>
                        <div class="overlay"></div>
                        <img src="'.$img['img_url'].'?t=' . time() . '" alt="">
                        <div class="actions">
                            <div href="" class="delete">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </div>
                            <div href="" class="edit">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </div>
                        </div>
                    </li>
                    ';
            }
        }else{
            echo'
                <ul class="image-list no-image" id="image-list">
                <h1>No images to view </h1>
                ';
        }
        echo '<div class="image-details" id="image-editor">
        <div class="actions">
            <div href="" class="cancel" id="cancel">
                Cancel
            </div>
            <div href="" class="save" id="save">
                Save
            </div>
        </div>
            <div class="img-edit">
                <img id="img-src" alt="">
                <div class="image-input-details">
                    <label class="file-upload">
                        <input type="file" id="img-input" name="img-input" accept="image/gif, image/jpeg, image/png, image/ico"/>
                        Choose image
                    </label>
                    <ul class="img-name" id="img-name">
                    </ul>
                    <textarea name="img-name-change" placeholder="Change image name"></textarea>
                </div>
            </div>  
        </div>
    </ul>
    </div>';
       if($total_imgs > $num_per_page){
            echo'
            <div class="pagination">';
            if($page > 0){
                $prev = $page - 1;
                echo '<a href="index.php?action='.$action.'&sub='.$subAction.'&page='.$prev.'" class="p-links prev">Prev</a>';
            }

            $threshold = (isMobile()) ? 5:$num_per_page;

            $k = ($page >= $threshold)? $page-$threshold:0;
            for($i = 0; $i < $num_links; $i++){
                $j = ($k+1)+ $i;
                $l = $j-1;
                echo "<a href='index.php?action=$action&sub=$subAction&page=$l' class='p-links'>$j</a>";
                if($i >= $threshold){
                    if($page < $num_links - 1){
                        $next = $page+1;
                        $last_page = $num_links - 1;
                        echo "<a href='index.php?action=$action&sub=$subAction&page=$j' class='p-links'>...</a>";
                        echo "<a href='index.php?action=$action&sub=$subAction&page=$last_page' class='p-links'>$num_links</a>";
        
                        echo "
                            <a href='index.php?action=$action&sub=$subAction&page=$next' class='p-links next'>Next</a>
                        </div>";
                    }
                    break;
                }
            }
        }
    }

    function stats($action,$subAction){
        global $total_visitors;
        global $today_visitors;
        global $this_month;
        $total_visitors = count_rows("SELECT Count(*) FROM visitors",[]);
        $total_visitors = ($total_visitors[0] && $total_visitors[1])? $total_visitors[1] : 0;

        $this_month = count_rows(
                                 "SELECT Count(*) FROM visitors
                                 WHERE MONTH(visit_date) = MONTH(now())
                                 AND YEAR(visit_date) =YEAR(now())",[]);
        $this_month = ($this_month[0] && $this_month[1])? $this_month[1] : 0;

        $today_visitors = count_rows(
                            "SELECT Count(*) FROM visitors
                            WHERE DATE(visit_date) = DATE(now())",[]);
        $today_visitors = ($today_visitors[0] && $today_visitors[1])? $today_visitors[1] : 0;
        
        echo '
        <div class="stats-cards-holder">
            <div class="stats-card" id="total_visitors">
                <h2>
                    Total visitors
                </h2>
                <h3>
                    '.$total_visitors.'
                </h3>
                <h5 class="pcent">
                    +0%
                </h5>
            </div>
            <div class="stats-card" id="today_visitors">
                <h2>
                    Today visitors
                </h2>
                <h3>
                    '.num_format($today_visitors).'
                </h3>
                <h5 class="pcent">
                    +0%
                </h5>
            </div>
             <div class="stats-card" id="this_month">
                <h2>
                    This month
                </h2>
                <h3>
                    '.num_format($this_month).'
                </h3>
                <h5 class="pcent">
                    +0%
                </h5>
            </div>
        </div>';

        if($subAction === 'ip-details'){
            echo '<div class="custom-table full-details">
                    <h2>'.ucfirst(str_replace('-',' ',$subAction)).'</h2>
                    <div class="stats-details">';
            $ip = (isset($_GET['ip']))? get_visitor($_GET['ip']) : '';
            if($ip == ''){
                echo '<h1 style="margin:auto">No ip specified</h1>';
            }else{
                echo'
                    <div>
                        <h1>
                            '.$ip['ip'].'
                        </h1>
                    </div>
                    <div>
                        <div>
                            <span>Country</span>
                            <span> '.$ip['country'].'</span>
                        </div>
                        <div>
                            <span>City</span>
                            <span> '.$ip['city'].'</span>
                        </div>
                        <div>
                            <span>Browser</span>
                            <span> '.$ip['browser'].'</span>
                        </div>
                        <div>
                            <span>Operating system</span>
                            <span> '.$ip['os_name'].'</span>
                        </div>
                        <div>
                            <span>Visits count</span>
                            <span> '.$ip['visit_count'].'</span>
                        </div>
                        <div>
                            <span>Visit date</span>
                            <span> '.$ip['visit_date'].'</span>
                        </div>
                        <div>
                            <span>Status</span>
                            <span> '.$ip['status'].'</span>
                        </div>
                        <div class="actions">
                            <div class="block-user">
                                Block
                            </div>
                        </div>
                    </div>
                ';
            }
            echo  '
                </div>
            </div>';
        }else{
            $page = (isset($_GET['page']))? $_GET['page'] : 0;
            $num_per_page = 4;
            $start = $page*$num_per_page;
            $next_page = $page+1;
            $num_links = ceil($total_visitors/$num_per_page);

            $visitors = stmtselectAll("SELECT * FROM visitors ORDER BY visit_date DESC 
                                    LIMIT $start,$num_per_page",[]);
            echo'
            <div class="custom-table">
                <h2>Latest visitors</h2>
                <ul class="table-list">
                    <li class="table-list-details">
                        <div class="details">
                            <span> IP</span>
                            <span>Country</span>
                            <span>City</span>
                            <span>Browser</span>
                            <span>OS name</span>
                            <span>Visit Count</span>
                            <span>Time</span>
                        </div>
                    </li>';
                    foreach($visitors as $v){
                        echo'
                        <li class="table-list-details">
                            <a class="details" href="'.HOST .'/index.php?action='.$action.'&sub=ip-details&ip='.$v['ip'].'">
                                <span>'.$v['ip'].'</span>
                                <span>'.$v['country'].'</span>
                                <span>'.$v['city'].'</span>
                                <span>'.$v['browser'].'</span>
                                <span>'.$v['os_name'].'</span>
                                <span>'.$v['visit_count'].'</span>
                                <span>'.$v['visit_date'].'</span>
                                <div class="click-to-view">Click to view</div>
                            </a>
                        </li>';
                    }
                echo '</ul>';
               echo' <div class="paginate">';
                if($page > 0){
                    $prev_page = ($page <= 0)? $page : $page -1;
                    echo '
                    <a href="'.HOST.'/index.php?action='.$action.'&sub='.$subAction.'&page='.$prev_page.'"> <i class="fa-solid fa-angle-left"></i>Previous</a>
                    ';
                }
                if($page < $num_links - 1){
                    echo '
                    <a href="'.HOST.'/index.php?action='.$action.'&sub='.$subAction.'&page='.$next_page.'"> Next <i class="fa-solid fa-angle-right"></i></a>
                    ';
                }
                echo' </div>';
            
            echo '</div>';
        }

    }

    function users($action,$subAction){
        global $total_users;
        global $today_users;
        global $this_month_users;
        $total_users = count_rows("SELECT Count(*) FROM users",[]);
        $total_users = ($total_users[0] && $total_users[1])? $total_users[1] : 0;

        $this_month_users = count_rows(
                                 "SELECT Count(*) FROM users
                                 WHERE MONTH(reg_date) = MONTH(now())
                                 AND YEAR(reg_date) =YEAR(now())",[]);
        $this_month_users = ($this_month_users[0] && $this_month_users[1])? $this_month_users[1] : 0;

        $today_users = count_rows(
                            "SELECT Count(*) FROM users
                            WHERE DATE(reg_date) = DATE(now())",[]);
        $today_users = ($today_users[0] && $today_users[1])? $today_users[1] : 0;
        
        echo '
        <div class="stats-cards-holder">
            <div class="stats-card" id="total_users">
                <h2>
                    Total users
                </h2>
                <h3>
                    '.$total_users.'
                </h3>
                <h5 class="pcent">
                    +0%
                </h5>
            </div>
            <div class="stats-card" id="today_users">
                <h2>
                    Today users
                </h2>
                <h3>
                    '.num_format($today_users).'
                </h3>
                <h5 class="pcent">
                    +0%
                </h5>
            </div>
             <div class="stats-card" id="this_month_users">
                <h2>
                    This month
                </h2>
                <h3>
                    '.num_format($this_month_users).'
                </h3>
                <h5 class="pcent">
                    +0%
                </h5>
            </div>
        </div>';
        if($subAction === 'user-details'){
            echo '<div class="custom-table full-details">
                    <h2>'.ucfirst(str_replace('-',' ',$subAction)).'</h2>
                    <div class="stats-details">';

            $u_id = (isset($_GET['user']))? $_GET['user'] : '';
            if($u_id === ''){
                echo '<h1 style="margin:auto">No user specified</h1>';
            }else{
                $user = stmtselect("SELECT * FROM users WHERE user_id =?",[$u_id]);
                $admin_btn = ($user['privilege'] === 'admin')? 'Make super': 'Make admin';
                $status_btn = ($user['status'] === 'active')? 'Block': 'Unblock';
                echo'
                    <div>
                        <h1>
                            '.$user['username'].'
                        </h1>
                    </div>
                    <div>
                        <div>
                            <span>Email</span>
                            <span>'.$user['email'].'</span>
                        </div>
                        <div>
                            <span>Username</span>
                            <span>'.$user['username'].'</span>
                        </div>
                        <div>
                            <span>Status</span>
                            <span>'.$user['status'].'</span>
                        </div>
                        <div>
                            <span>Privileges</span>
                            <span>'.$user['privilege'].'</span>
                        </div>
                        <div>
                            <span>Registered on</span>
                            <span>'.$user['reg_date'].'</span>
                        </div>
                        <div>
                            <span>Last seen</span>
                            <span>'.$user['last_seen'].'</span>
                        </div>
                        <div class="actions" id="custom-table-actions">
                            <div class="make-admin">
                                '.$admin_btn.'
                            </div>
                            <div class="delete-user">
                                Delete
                            </div>
                            <div class="block-user">
                               '.$status_btn.'
                            </div>
                        </div>
                    </div>';
                }
               echo '</div>
            </div>
            ';
        }else{
            $page = (isset($_GET['page']))? $_GET['page'] : 0;
            $num_per_page = 4;
            $start = $page*$num_per_page;
            $next_page = $page+1;
            $num_links = ceil($total_users/$num_per_page);

            $users = stmtselectAll("SELECT * FROM users ORDER BY reg_date DESC 
                                    LIMIT $start,$num_per_page",[]);
            echo'
            <div class="custom-table users">
                <h2>Users</h2>
                <ul class="table-list">
                    <li class="table-list-details">
                        <div class="details">
                            <span>Email</span>
                            <span>Username</span>
                            <span>Privilege</span>
                            <span>Reg. date</span>
                        </div>
                    </li>';
                foreach($users as $u){
                    echo '
                    <li class="table-list-details">
                        <a class="details" href="'.HOST .'/index.php?action='.$action.'&sub=user-details&user='.$u['user_id'].'">
                            <span>
                                '.$u['email'].'
                            </span>
                            <span class="username">
                                '.$u['username'].'
                            </span>
                            <span class="user-flag super-admin">
                                '.$u['privilege'].'
                            </span>
                            <span>
                                '.$u['reg_date'].'
                            </span>
                            <div class="click-to-view">Click to view</div>
                            </span>
                        </a>
                    </li>';
                    }
                      echo '</ul>';
                    echo' <div class="paginate">';
                    if($page > 0){
                        $prev_page = ($page <= 0)? $page : $page -1;
                        echo '
                        <a href="'.HOST.'/index.php?action='.$action.'&sub='.$subAction.'&page='.$prev_page.'"> <i class="fa-solid fa-angle-left"></i>Previous</a>
                        ';
                    }
                    if($page < $num_links - 1){
                        echo '
                        <a href="'.HOST.'/index.php?action='.$action.'&sub='.$subAction.'&page='.$next_page.'"> Next <i class="fa-solid fa-angle-right"></i></a>
                        ';
                    }
                    echo' </div>';
                
                echo '</div>';
        }
    }
    
?>





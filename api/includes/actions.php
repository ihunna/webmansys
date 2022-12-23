<?php
    function about($action,$subAction){
        $status = array('success' => false);
        $textual= stmtselect("SELECT * FROM textuals WHERE category =? AND sub_category=?",[$action,$subAction]);
        if($textual && !empty($textual['data'])){
            $status['success'] = true;
            $status['data'] = $textual['data'];
        }else{
            $status['data'] = $textual['data'];
            $status['error'] = 'Error with query or empty lists';
        }
        return json_encode($status);
    }

    function galleries($action,$subAction){
        $status = array('success' => false);
        $page = (isset($_GET['page']))? $_GET['page'] : 0;
        $status['page'] =  $page;

        $num_per_page = (isset($_GET['limit']))? $_GET['limit']:8;
        $status['limit'] =  $num_per_page;

        $total_imgs = count_rows(
            "SELECT COUNT(*) FROM images 
            WHERE sub_category =?",
            [$subAction])[1];
        $status['total_data_count'] = $total_imgs;

        $num_links = ceil($total_imgs/$num_per_page);
        $start = $page*$num_per_page;
        $images = getImages($subAction,$start,$num_per_page);
        $status['data_count'] = count($images);

        if($images && !empty($images)){
            $status['success'] = true;
            $status['data'] = $images;
        }else{
            $status['data'] = $images;
            $status['error'] = 'Error with query or empty lists';
        }
        return json_encode($status);
    }
?>
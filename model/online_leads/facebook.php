<?php

class facebook
{
    public function setApp()
    {
        $appId = $_POST['appId'];
        $appSecret = $_POST['appSecret'];
        $appCallback = $_POST['appCallback'];
        $query = "update app_settings set facebook_appid='".$appId."',facebook_appsecret='".$appSecret."',facebook_callback='".$appCallback."'";
        mysqlQuery($query)or die('Error');
        echo "Success";
    }
    public function fetchData()
    {
        $data = [];
        $query = "SELECT * FROM `facebook_data` where is_done=0";
        $res = mysqlQuery($query)or die('Error');
        if(mysqli_num_rows($res)>0)
        {
            while($db = mysqli_fetch_object($res))
            {
                $decode = json_decode($db->data);
                $data[] = $decode[0];
            }
        }
        echo json_encode($data);
    }
}


?>
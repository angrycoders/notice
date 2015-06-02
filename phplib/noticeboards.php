<?php
if(isset($_GET['term'])){

require_once 'util/input.php';
require_once 'init/DbConnect.php';
require_once 'class/cls_NoticeBoard.php';

$response = array();

$db = new DbConnect();
$con = $db->connect();

if(!mysqli_connect_errno()){
            
    //Get the fields
    $term = sanitize_mysqli($con, $_GET['term']);  
   
    
    //Add record
    $response = check($term);
}

 public function check($term){
        
        $response = array();
                              
                
        if( ($stmt = prepare("SELECT  INTO noticeboards (`user_no`, `avatar_no`,`type`, `title`, `desc`, `date_added`, `date_updated`) VALUES(?,?,?,?,?,?,?)"))) {

            $stmt -> bind_param("dddssss", $user_no, $avatar_no, $type, $title, $desc, $date, $date);
            $stmt -> execute();
            $id = $stmt -> insert_id;
            $stmt -> close();
            
            $response['res'] = 1;
            $response['noticeboard_no'] = $id;
            $response['avatar_no'] = $avatar_no;
            $response['date'] = $date;
            
            return $response;
        } 
        
        $response['res'] = 0;
        return $response;
    }       
      
    
}
?>
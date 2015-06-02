<?php

if(isset($_POST)){
    
    require_once 'util/input.php';
    
    $response = array();
    
    $type = $_POST['Type'];    
    
    switch($type){
        
        case 'add_noticeboard':         
            $response = add_noticeboard();
            break;         
    }
    
    echo json_encode($response);
}

function addImports(){       
    require_once 'init/DbConnect.php';
    require_once 'class/cls_NoticeBoard.php';
}

function add_noticeboard(){
    $response = array();
    
    $allowed   = array();
    $allowed[] = 'Type';   
    $allowed[] = 'User_no'; 
    $allowed[] = 'Type_no';
    $allowed[] = 'Title'; 
    $allowed[] = 'Desc';    
        
    $sent = array_keys($_POST);
    
    if (input_ok($sent, $allowed))
    {
        addImports();       
        
        $db = new DbConnect();
        $con = $db->connect();
        
        if(!mysqli_connect_errno()){
            
            //Get the fields
            $user_no = sanitize_mysqli($con, $_POST['User_no']);  
            $type = sanitize_mysqli($con, $_POST['Type_no']);
            $title = sanitize_mysqli($con, $_POST['Title']);
            $desc = sanitize_mysqli($con, $_POST['Desc']);
            
            //Get a connection to noticeboard
            $noticeboard = new NoticeBoard($con);
            
            //Add record
            $response = $noticeboard->add($user_no, $type, $title, $desc);
        }       
        else{
            $response['res'] = -1;            
        }
        
    }
    else{        
        $response['res'] = -2;        
    }
    
    return $response;
}

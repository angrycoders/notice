<?php

/*
 * Class to deal with all user transactions
 */




class Notice{
    var $con;    
    
    //to pass in the connection
    public function __construct($con) {
        $this->con = $con;
    }
        
    //add a new notice and return the notice no
    public function add($noticeboard_no, $type, $file_ext, $title, $desc, $date_expiry){
        
        $response = array();               
        $date = date('Y-m-d H:i:s');        
                
        if( ($stmt = $this->con->prepare("INSERT INTO notices (`noticeboard_no`, `type`, `file_ext`, `title`, `desc`, `date_expiry`, `date_added`, `date_updated`) VALUES(?,?,?,?,?,?,?,?)"))) {

            $stmt -> bind_param("ddssssss", $noticeboard_no, $type, $file_ext, $title, $desc, $date_expiry, $date, $date);
            $stmt -> execute();
            $id = $stmt -> insert_id;
            $stmt -> close();
            
            $response['res'] = 1;
            $response['notice_no'] = $id; 
            $response['file_ext'] = $file_ext;
            $response['date'] = $date;
            
            return $response;
        } 
        
        $response['res'] = 0;
        return $response;
    }        
}

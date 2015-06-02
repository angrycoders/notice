<?php

/*
 * Class to deal with all user transactions
 */




class NoticeBoard{
    var $con;    
    
    //to pass in the connection
    public function __construct($con) {
        $this->con = $con;
    }
        
    //add a new noticeboard
    public function add($user_no, $type, $title, $desc){
        
        $response = array();
        
        //Get the link to the avatar table
        $avatar_no = $this->get_avatar_no();
                
        $date = date('Y-m-d H:i:s');        
                
        if( ($stmt = $this->con->prepare("INSERT INTO noticeboards (`user_no`, `avatar_no`,`type`, `title`, `desc`, `date_added`, `date_updated`) VALUES(?,?,?,?,?,?,?)"))) {

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
       
    //get avatar no
    public function get_avatar_no(){
        $date = date('Y-m-d H:i:s');
        $query = "INSERT INTO avatars (is_set, date_added, date_updated) VALUES('0', '$date', '$date')"; 
        $this->con->query($query);
        
        return $this->con->insert_id;
    }
       
    //update user info    
    public function update_user_info($user_info_no, $fullname, $phone, $email){
        
        $response = array();        
        
        $date = date('Y-m-d H:i:s');
                      
        if( ($stmt = $this->con-> prepare("UPDATE user_info SET fullname = ? , phone = ? , email = ? , date_updated = ? WHERE user_info_no = ?"))) {
            
            $stmt -> bind_param("ssssd", $fullname, $phone, $email, $date, $user_info_no);
            $stmt -> execute();          
            $stmt -> close();
               
            $response['res'] = 1;
            $response['date'] = $date;
            
            return $response;
        } 
        
        $response['res'] = -1;
        return $response;
    }

    //load all noticeboards belonging to a particular user
    public function loadAll($user_no)
    {
        $res = array();
        $res['count'] = 0;
        $counter = 0;

        $noticeboard_no = $user_no = $avatar_no = $type = $title = $desc = $date_added = $date_updated = "";

        if (($stmt = $this->con->prepare("SELECT * FROM noticeboards WHERE user_no = ?"))) {

            $stmt->bind_param("d", $user_no);
            $stmt->execute();
            $stmt->bind_result($noticeboard_no, $user_no, $avatar_no, $type, $title, $desc, $date_added, $date_updated);

            $res['count'] = $stmt -> num_rows;

            while ($stmt->fetch()) {
                $res[$counter] = array(
                    'noticeboard_no' => $noticeboard_no,
                    'user_no' => $user_no,
                    'avatar_no' => $avatar_no,
                    'type' => $type,
                    'title' => $title,
                    'desc' => $desc,
                    'date_added' => $date_added,
                    'date_updated' => $date_updated
                );

                ++$counter;
            }

            $stmt->close();
        }


        return $res;
    }

}

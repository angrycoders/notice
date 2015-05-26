<?php
/**
 * Created by PhpStorm.
 * User: Keysindicet
 * Date: 5/25/2015
 * Time: 10:33 PM
 */

namespace AngryCoders\Notice\Data;

use AngryCoders\Db\Db;


class NoticeBoard
{

    /**
     * @var Db connection to the db
     */
    private $db;

    const TABLE_NAME = "noticeboard";

    //Construct
    public function __construct()
    {
        $this->db = new Db();

        //Create the table
        $this->db->createTable(self::TABLE_NAME, array(
            "noticeBoardID" => array(Db::INTEGER, 11, Db::PRIMARY_KEY, Db::AUTO_INCREMENT),
            "staffID" => array(Db::INTEGER, 11),
            "title" => array(Db::VARCHAR, 100),
            "dateAdded" => array(Db::DATETIME, 0),
            "dateUpdated" => array(Db::DATETIME, 0)));
    }

    //Add new noticeboard
    public function add($staffID, $title)
    {
        $date = date('Y-m-d H:i:s');
        $this->db->insertRecord(self::TABLE_NAME, array(NULL, $staffID, $title, $date, $date));
    }

    //Delete a noticeBoard
    public function delete($noticeBoardID)
    {
        $this->db->deleteRecord(self::TABLE_NAME, $noticeBoardID, "noticeBoardID");
    }

    //Load all noticeboards
    public function loadAll(){
        $this->db->getRecord()
    }
} 
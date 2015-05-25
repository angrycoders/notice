<?php
/**
 * Created by PhpStorm.
 * User: Keysindicet
 * Date: 5/25/2015
 * Time: 10:33 PM
 */

namespace AngryCoders\Notice\Data;

use AngryCoders\Db\Db;


class Notice
{

    /**
     * @var Db connection to the db
     */
    private $db;

    const TABLE_NAME = "notice";

    //Construct
    public function __construct()
    {
        $this->db = new Db();

        //Create the table
        $this->db->createTable(self::TABLE_NAME, array(
            "noticeID" => array(Db::INTEGER, 11, Db::PRIMARY_KEY, Db::AUTO_INCREMENT),
            "noticeBoardID" => array(Db::INTEGER, 11),
            "accountID" => array(Db::INTEGER, 11),
            "title" => array(Db::VARCHAR, 100),
            "description" => array(Db::TEXT, 0),
            "dateAdded" => array(Db::DATETIME, 0),
            "dateUpdated" => array(Db::DATETIME, 0)));
    }

    //Add new notice
    public function add($noticeBoardID, $accountID, $title, $description)
    {
        $date = date('Y-m-d H:i:s');
        $this->db->insertRecord(self::TABLE_NAME, array(NULL, $noticeBoardID, $accountID, $title, $description, $date, $date));
    }

    //Delete a notice
    public function delete($noticeID)
    {
        $this->db->deleteRecord(self::TABLE_NAME, $noticeID, "noticeID");
    }
} 
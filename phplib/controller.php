<?php
/**
 * Created by PhpStorm.
 * User: Keysindicet
 * Date: 5/25/2015
 * Time: 11:52 PM
 */

require_once '../vendor/autoload.php';

use AngryCoders\Notice\Data\Notice;
use AngryCoders\Notice\Data\NoticeBoard;

if (isset($_POST)) {
    $type = $_POST['type'];
    $res = array();
    switch ($type) {
        case 'add-noticeboard':
            $res = addNoticeBoard();
            break;
        case 'add-notice':
            $res = addNotice();
            break;
        case 'del-noticeboard':
            $res = delNoticeBoard();
            break;
        case 'del-notice':
            break;
        default:
            $res['res'] = '0';
    }

    echo json_encode($res);
}

//Add a noticeboard
function addNoticeBoard()
{

    $staffId = $_POST['staffID'];
    $title = $_POST['title'];

    $noticeBoard = new NoticeBoard();
    $noticeBoard->add($staffId, $title);

    $res = array();
    $res['res'] = 1;
    return $res;
}

//Add a notice
function addNotice()
{

    $noticeBoardID = $_POST['noticeBoardID'];
    $accountID = $_POST['accountID'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    $notice = new Notice();
    $notice -> add($noticeBoardID, $accountID, $title, $description);

    $res = array();
    $res['res'] = 1;
    return $res;
}

//Delete NoticeBoard
function delNoticeBoard()
{
    $noticeBoardID = $_POST['noticeBoardID'];
    $noticeBoard = new NoticeBoard();

    $noticeBoard ->delete($noticeBoardID);

    $res = array();
    $res['res'] = 1;
    return $res;
}

//Delete Notice
function delNotice()
{
    $noticeID = $_POST['noticeID'];
    $notice = new Notice();

    $notice ->delete($notice);

    $res = array();
    $res['res'] = 1;
    return $res;
}

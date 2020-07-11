<?php
require_once("../_system/config.php");
require_once("../_system/database.php");
$resultarray = array();
$result = array();
$_GET["username"] = 'Admin2';
if (isset($_GET["candidate_id"]) && isset($_GET["election_id"]) && isset($_GET["username"])) {
    $username = mysqli_real_escape_string($connect, $_GET["username"]);
    $candidate_id = mysqli_real_escape_string($connect, $_GET["candidate_id"]);
    $election_id = mysqli_real_escape_string($connect, $_GET["election_id"]);
    $sql_checkvote = 'SELECT id FROM votelog WHERE username = "'. $username .'" AND election_id = "'. $election_id .'"';
    $res_checkvote = mysqli_query($connect, $sql_checkvote);
    if ($res_checkvote) {
        $num_checkvote = mysqli_num_rows($res_checkvote);
        if ($num_checkvote == 0) {
            if (isset($_GET["action"])) {
                if ($_GET["action"] == "notwishtovote") {
                    $sql_votecandidate = 'INSERT INTO votelog (username, election_id) VALUES ("'. $username .'", "'. $election_id .'")';
                    $res_votecandidate = mysqli_query($connect, $sql_votecandidate);
                    if ($res_votecandidate) {
                        $result["msg_title"] = 'สำเร็จ!';
                        $result["msg_alert"] = 'บันทึกข้อมูลสำเร็จ';
                        $result["icon"] = 'success';
                        $result["href"] = 1;
                    } else {
                        $result["msg_title"] = 'ผิดพลาด!';
                        $result["msg_alert"] = 'เกิดข้อผิดพลาดในการบันทึกข้อมูล #ErrID: QUERY_01';
                        $result["icon"] = 'error';
                    }
                }
            } else {
                $sql_checkcandidate = 'SELECT cdd_id FROM candidatelist WHERE cdd_id = "'. $candidate_id .'" AND election_id = "'. $election_id .'"';
                $res_checkcandidate = mysqli_query($connect, $sql_checkcandidate);
                if ($res_checkcandidate) {
                    $num_checkcandidate = mysqli_num_rows($res_checkcandidate);
                    if ($num_checkcandidate == 1) {
                        $sql_votecandidate = 'INSERT INTO votelog (username, election_id) VALUES ("'. $username .'", "'. $election_id .'")';
                        $res_votecandidate = mysqli_query($connect, $sql_votecandidate);
                        if ($res_votecandidate) {
                            $sql_addscore = 'UPDATE candidatelist SET score=score+"1" WHERE election_id = "'. $election_id .'" AND cdd_id = "'. $candidate_id .'"';
                            $res_addscore = mysqli_query($connect, $sql_addscore);
                            if ($res_addscore) {
                                $result["msg_title"] = 'สำเร็จ!';
                                $result["msg_alert"] = 'ลงคะแนนสำเร็จ';
                                $result["icon"] = 'success';
                                $result["href"] = 1;
                            } else {
                                $result["msg_title"] = 'ผิดพลาด!';
                                $result["msg_alert"] = 'เกิดข้อผิดพลาดในการลงคะแนน #ErrID: QUERY_02';
                                $result["icon"] = 'error';
                            }
                        } else {
                            $result["msg_title"] = 'ผิดพลาด!';
                            $result["msg_alert"] = 'เกิดข้อผิดพลาดในการลงคะแนน #ErrID: QUERY_03';
                            $result["icon"] = 'error';
                        }
                    } else {
                        $result["msg_title"] = 'ผิดพลาด!';
                        $result["msg_alert"] = 'ไม่พบผู้สมัครเลือกตั้งในฐานข้อมูล #ErrID: Candidate_Member_Not_Found';
                        $result["icon"] = 'error';
                    }
                } else {
                    $result["msg_title"] = 'ผิดพลาด!';
                    $result["msg_alert"] = 'เกิดข้อผิดพลาดในการตรวจสอบข้อมูล #ErrID: QUERY_04';
                    $result["icon"] = 'error';
                }
            }
        } else {
            $result["msg_title"] = 'ผิดพลาด!';
            $result["msg_alert"] = 'ไม่สามารถลงคะแนนซ้ำได้';
            $result["icon"] = 'error';
        } 
    } else {
        $result["msg_title"] = 'ผิดพลาด!';
        $result["msg_alert"] = 'เกิดข้อผิดพลาดในการตรวจสอบข้อมูล #ErrID: QUERY_05';
        $result["icon"] = 'error';
    }
} else {
    $result["msg_title"] = 'Error!';
    $result["msg_alert"] = 'XD';
    $result["icon"] = 'error';
}
array_push($resultarray,$result);
echo json_encode($resultarray);
//print_r($result);
<?php
require_once("../_system/config.php");
require_once("../_system/database.php");
$datenow = date("Y-m-05 H:i:s");
if (isset($_GET["keyword"])) {
    $keyword = mysqli_real_escape_string($connect, $_GET["keyword"]);
    if ($_GET["keyword"] == "" || $_GET["keyword"] == "NULL" || $_GET["keyword"] == NULL) {
        $sql_votelist = 'SELECT * FROM election';
    } else {
        $sql_votelist = 'SELECT * FROM election WHERE election_id LIKE "%'. $keyword .'%" OR title LIKE "%'. $keyword .'%" OR description = "%'. $keyword .'%"';
    }
} else {
    $sql_votelist = 'SELECT * FROM election';
}
$res_votelist = mysqli_query($connect, $sql_votelist);
$num_votelist = mysqli_num_rows($res_votelist);

$loopround = 0;
$resultArray = array();
while($result = mysqli_fetch_array($res_votelist,MYSQLI_ASSOC)){
    $datetime1 = new DateTime(date("Y-m-05 H:i:s"));
    if ($result["announcement_time"] <= $datenow) {
        $datetimefor2 = $result["announcement_time"];
        $format_date = "NULL";
        $html = "1";
    } elseif ($result["end_time"] <= $datenow) {
        $datetimefor2 = $result["announcement_time"];
        $format_date = "ประกาศผลใน ";
        $html = "2";
    } elseif ($result["start_time"] <= $datenow) {
        $datetimefor2 = $result["end_time"];
        $format_date = "ปิดการโหวตใน ";
        $html = "3";
    } else {
        $datetimefor2 = $result["start_time"];
        $format_date = "เริ่มการโหวตใน ";
        $html = "4";
    } 
    $datetime2 = new DateTime($datetimefor2);
    $interval = $datetime1->diff($datetime2);
    $cooldowntime = $interval->format('%m เดือน %d วัน %H ชั่วโมง %I นาที %S วินาที');
    $result["format_date"] = $format_date;
    $result["html"] = $html;
    if ($format_date == "NULL") {
        $result["cooldown"] = "NULL";
    } else {
        $result["cooldown"] = $cooldowntime;
    }
    $loopround++;
    array_push($resultArray,$result);
    //print_r($result);
}

echo json_encode($resultArray);
//print_r($resultArray);
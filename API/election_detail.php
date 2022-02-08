<?php
require_once("../_system/config.php");
require_once("../_system/database.php");
$datenow = date("Y-m-d H:i:s");
if (!isset($_GET["keyword"])) {
    $keyword = '';
}
$keyword = mysqli_real_escape_string($connect, $_GET["keyword"]);
$sql_votelist = 'SELECT start_time, end_time, announcement_time FROM election WHERE election_id = "' . $keyword . '"';
$res_votelist = mysqli_query($connect, $sql_votelist);
$num_votelist = mysqli_num_rows($res_votelist);

$resultArray = array();
while ($result = mysqli_fetch_array($res_votelist, MYSQLI_ASSOC)) {
    $datetime1 = new DateTime(date("Y-m-d H:i:s"));
    if ($result["announcement_time"] <= $datenow) {
        $html = "1";
        $format_date = "NULL";
    } elseif ($result["end_time"] <= $datenow) {
        $html = "2";
        $format_date = "ประกาศผลใน ";
    } elseif ($result["start_time"] <= $datenow) {
        $html = "3";
        $format_date = "ปิดการโหวตใน ";
    } else {
        $html = "4";
        $format_date = "เริ่มการโหวตใน ";
    }
    if ($format_date == "NULL") {
        $result["format_date"] = $format_date;
        $result["html"] = $html;
    } else {
        $result["format_date"] = $format_date;
        $result["html"] = $html;
    }
    array_push($resultArray, $result);
    //print_r($result);
}

echo json_encode($resultArray);
    //print_r($resultArray);
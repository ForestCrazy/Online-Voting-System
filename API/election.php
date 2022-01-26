<?php
require_once("../_system/config.php");
require_once("../_system/database.php");
$datenow = date("Y-m-d H:i:s");
$sql_votelist = 'SELECT * FROM election WHERE hidden_time >= NOW()';
if (isset($_GET["keyword"])) {
    $keyword = mysqli_real_escape_string($connect, $_GET["keyword"]);
    if (!$_GET["keyword"] == "" || !$_GET["keyword"] == "NULL" || !$_GET["keyword"] == NULL) {
        $sql_votelist = 'SELECT * FROM election WHERE hidden_time >= NOW() AND (election_id LIKE "%' . $keyword . '%" OR title LIKE "%' . $keyword . '%" OR description = "%' . $keyword . '%")';
        $specificElectionSearch = true;
    }
} else if ($_GET["election_id"]) {
    $election_id = mysqli_real_escape_string($connect, $_GET["election_id"]);
    if (!$_GET["election_id"] == "" || !$_GET["election_id"] == "NULL" || !$_GET["election_id"] == NULL) {
        $sql_votelist = 'SELECT * FROM election WHERE election_id = "' . $election_id . '"';
        $specificElectionSearch = true;
    }
}
$resElectionList = mysqli_query($connect, $sql_votelist);
if ($specificElectionSearch) {
    echo json_encode(mysqli_fetch_assoc($resElectionList));
} else {
    $electionArray = array();
    while ($fetchElection = mysqli_fetch_assoc($resElectionList)) {
        $fetchElection["election_state"] = 1;
        $dateNow = date("Y-m-d H:i:s");
        if (date("Y-m-d H:i:s", strtotime($fetchElection["announcement_time"])) <= $dateNow) {
            $fetchElection["election_state"] = 4;
        } else if (date("Y-m-d H:i:s", strtotime($fetchElection["end_time"])) <= $dateNow) {
            $fetchElection["election_state"] = 3;
        } else if (date("Y-m-d H:i:s", strtotime($fetchElection["start_time"])) <= $dateNow) {
            $fetchElection["election_state"] = 2;
        }
        array_push($electionArray, $fetchElection);
    }
    echo json_encode($electionArray);
}

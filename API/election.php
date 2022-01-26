<?php
require_once("../_system/config.php");
require_once("../_system/database.php");
function electionState($election)
{
    $electionState = 1;
    $dateNow = date("Y-m-d H:i:s");
    if (date("Y-m-d H:i:s", strtotime($election["announcement_time"])) <= $dateNow) {
        $electionState = 4;
    } else if (date("Y-m-d H:i:s", strtotime($election["end_time"])) <= $dateNow) {
        $electionState = 3;
    } else if (date("Y-m-d H:i:s", strtotime($election["start_time"])) <= $dateNow) {
        $electionState = 2;
    }
    return $electionState;
}
$sql_votelist = 'SELECT * FROM election WHERE hidden_time >= NOW()';
$specificElectionSearch = false;
if (isset($_GET["keyword"])) {
    $keyword = mysqli_real_escape_string($connect, $_GET["keyword"]);
    if ($_GET["keyword"] != "" && $_GET["keyword"] != "NULL" && $_GET["keyword"] != NULL) {
        $sql_votelist = 'SELECT * FROM election WHERE hidden_time >= NOW() AND (election_id LIKE "%' . $keyword . '%" OR title LIKE "%' . $keyword . '%" OR description = "%' . $keyword . '%")';
        $specificElectionSearch = true;
    }
} else if ($_GET["election_id"]) {
    $election_id = mysqli_real_escape_string($connect, $_GET["election_id"]);
    if ($_GET["election_id"] != "" && $_GET["election_id"] != "NULL" && $_GET["election_id"] != NULL) {
        $sql_votelist = 'SELECT * FROM election WHERE election_id = "' . $election_id . '"';
        $specificElectionSearch = true;
    }
}
$resElectionList = mysqli_query($connect, $sql_votelist);
if ($specificElectionSearch) {
    $fetchElection = mysqli_fetch_assoc($resElectionList);
    $fetchElection["election_state"] = electionState($fetchElection);
    echo json_encode($fetchElection);
} else {
    $electionArray = array();
    while ($fetchElection = mysqli_fetch_assoc($resElectionList)) {
        $fetchElection["election_state"] = electionState($fetchElection);
        array_push($electionArray, $fetchElection);
    }
    echo json_encode($electionArray);
}

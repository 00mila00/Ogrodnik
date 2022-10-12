<?php
require_once "../../../connect.php";
session_start();
$ID = $_SESSION["ID"];

header("Content-Type: application/json; charset=UTF-8");
$obj = json_decode($_POST["x"], false);
$action = $obj->action;

if ($action == 'retrieve') {
    retrieveReminders($ID);

} else if ($action == 'set') {
    $title = $obj->title;
    $date = $obj->date;

    setReminder($date, $title, $ID);
} else if ($action == 'remove') {
    $reminder_id = $obj->ID;

    removeReminder($reminder_id);
}

function retrieveReminders($ID) {
    $con = connect();
    $stmt = $con->prepare("SELECT * FROM reminders WHERE user_ID=(?)");
    $stmt->bind_param('i', $ID);
    $stmt->execute();
    $result = $stmt->get_result();

    $rows = array();

    while($row = $result->fetch_assoc())
    {
        array_push($rows, $row);
    }

    echo json_encode($rows);
}


function setReminder($date_input, $title, $ID) {
    $date = explode('.', $date_input);

    $day = $date[1];
    $month = $date[0];
    $year = $date[2];

    if (intval($day) < 10) {
        $day = "0".$day;
    }

    if (intval($month) < 10) {
        $month = "0".$month;
    }

    $date_string = $year."-".$month."-".$day;

    $con = connect();
    $stmt = $con->prepare("INSERT INTO reminders (reminder_date, reminder_type, user_ID)
            VALUES(?, ?, ?)");
    $stmt->bind_param('ssi', $date_string, $title, $ID);
    $stmt->execute();

    $stmt_r = $con->prepare("SELECT ID from reminders WHERE reminder_date=(?) AND user_ID=(?)");
    $stmt_r->bind_param('si', $date_string, $ID);
    $stmt_r->execute();
    $result = $stmt_r->get_result();

    echo json_encode($result->fetch_assoc());
}

function removeReminder($reminder_ID) {
    $con = connect();
    $stmt = $con->prepare("DELETE FROM reminders WHERE ID = (?)");
    $stmt->bind_param('i', $reminder_ID);
    $stmt->execute();
}

?>
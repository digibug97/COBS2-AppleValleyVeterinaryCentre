<?php

function validate_inputs($datetime, $pet, $reason, $consultant, $errors, $conn) {
    global $errors;

    if (strlen($reason) < 5 || strlen($reason) > 255) {
        $errors[] = "Reason for visit must be 5-255 characters";
    }

    if (empty($datetime)) {
        $errors[] = "Date/Time must be entered";
    }

    return (count($errors) == 0 ? true : false);
}

session_start();

include "../inc/database_connection.php";
include "../inc/toast_hander.php";

$datetime = $_POST["datetime"];
$pet = $_POST["pet"];
$reason = $_POST["reason"];
$consultant = $_POST["vet"];

$errors = [];

if (validate_inputs($datetime, $pet, $reason, $consultant, $errors, $conn)) {
    $sqlNewAppointment = "INSERT INTO appointment (datetime, vetid, petid, reasonforvisit)
    VALUES ('$datetime', $pet, $consultant, '$reason')";
    $rsNewAppointment = mysqli_query($conn, $sqlNewAppointment);
    $id = mysqli_insert_id($conn);
    create_toast("success", "Appointment Created", $errors, "../../appointment.php?id=" . $id);
} else {
    create_toast("error", "Appointment Creation Failed", $errors, "../../appointmentadd.php");
}



?>
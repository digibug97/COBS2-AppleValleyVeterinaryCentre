<?php

$id = $_GET['id'];

include "assets/inc/database_connection.php";

function calculate_age($date) {
    $diff = date_diff(date_create($date), date_create());
    $years = $diff -> format("%y");
    if ($years > 0) {
        return $years . " years";
    } else {
        $months = $diff -> format("%m");
        if ($months > 0) {
            return $months . " months";
        } else {
            $days = $diff -> format("%d");
            return $days . " days";
        }
    }
}

function display_pet($conn, $id) {
    $sqlPet = "SELECT pet.*, pet.name AS petname, species.name AS speciesname FROM appointment LEFT JOIN pet ON pet.id = appointment.petid INNER JOIN species ON pet.speciesid = species.id WHERE appointment.id = $id";
    $rsPet = mysqli_query($conn, $sqlPet);
    $petInfo = mysqli_fetch_assoc($rsPet);
    $age = calculate_age($petInfo["dob"]);    
    echo "<p class='name'>" . $petInfo["petname"] . "</p>";
    echo "<p class='general'>";
    echo    "<span class='sex'>" . ($petInfo['sex'] == "M" ? "<i class='fa fa-mars' aria-hidden='true'></i> " : "<i class='fa fa-venus' aria-hidden='true'></i> ") . "</span>";
    echo    $petInfo["speciesname"];
    echo "</p>";
    echo "<p class='dob'>" . date_format(date_create($petInfo["dob"]), "d/m/y") . " (" . $age . ")</p>";
    echo "<div class='contact'>";
    echo    "<p class='address'>" . $petInfo["address"] . "</p>";
    echo    "<p class='contactnumber'>" . $petInfo["contactnumber"] . "</p>";
    echo "</div>";
}

function display_appointment($conn, $id) {
    $sqlAppointment = "SELECT appointment.id, appointment.datetime, appointment.reasonforvisit, vet.name AS vetname
                        FROM appointment
                        INNER JOIN vet ON appointment.vetid = vet.id
                        WHERE appointment.id = $id";
    $rsAppointment = mysqli_query($conn, $sqlAppointment);
    $appointmentInfo = mysqli_fetch_assoc($rsAppointment);
    echo "<h3>Date/Time</h3>";
    echo "<p class='datetime'>" . date_format(date_create($appointmentInfo["datetime"]), "d/m/y H:i") . "</p>";
    echo "<h3>Consultant</h3>";
    echo "<p class='vet'>" . $appointmentInfo["vetname"] . "</p>";
    echo "<h3>Reason For Visit</h3>";
    echo "<p class='reasonforvisit'>" . $appointmentInfo["reasonforvisit"] . "</p>";
}

function display_treatments($conn, $id) {
    $sqlTreatments = "SELECT treatment.treatment
                        FROM appointment
                        LEFT JOIN appointmenttreatment ON appointment.id = appointmenttreatment.appointmentid
                        INNER JOIN treatment ON treatment.id = appointmenttreatment.treatmentid
                        WHERE appointment.id = $id";
    $rsTreatments = mysqli_query($conn, $sqlTreatments);
    $numberOfTreatments = mysqli_num_rows($rsTreatments);
    if ($numberOfTreatments > 0) {
        for ($i = 1; $i <= $numberOfTreatments; $i++) {
            $thisTreatment = mysqli_fetch_assoc($rsTreatments);
            echo "<li><i class='fa fa-check' aria-hidden='true'></i> " . $thisTreatment["treatment"] . "</li>";
        }
    } else {
        echo "<p>No treatment recorded</p>";
    }
    
}


?>



<!DOCTYPE html>
<html>
    <?php include "assets/inc/head.php";?>
    <body id="appointment" class="flex-container">
        <?php include "assets/inc/sidemenu.php";?>
        <div class="page-contents">
            <h1>Appointment</h1>
            <div class="flex-container">
                <div id="appointment-pet">
                    <h2><i class="fa fa-paw" aria-hidden="true"></i> Pet/Patient</h2>
                    <?php display_pet($conn, $id);?>
                </div>
                <div id="appointment-info">
                    <h2><i class="fa fa-user-md" aria-hidden="true"></i> Visit</h2>
                    <?php display_appointment($conn, $id);?>
                </div>
                <div id="appointment-treatments">
                    <h2><i class="fa fa-medkit" aria-hidden="true"></i> Treatment</h2>
                    <ul>
                        <?php display_treatments($conn, $id);?>
                    </ul>
                    <a class="button" href="treatmentlog.php"><i class="fa fa-plus-circle" aria-hidden="true"></i> Treatment</a>
                </div>     
            </div>
        </div>

    </body>
</html>
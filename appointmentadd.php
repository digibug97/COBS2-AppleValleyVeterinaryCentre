<?php

include "assets/inc/database_connection.php";

function display_pets($conn) {
    $sqlPets = "SELECT id, name FROM pet ORDER BY name ASC";
    $rsPets = mysqli_query($conn, $sqlPets);
    $numPets = mysqli_num_rows($rsPets);
    for ($i = 1; $i <= $numPets; $i++) {
        $thisPet = mysqli_fetch_assoc($rsPets);
        echo "<option value='" . $thisPet["id"] . "'>" . $thisPet["name"] . "</option>";
    }
}

function display_vets($conn) {
    $sqlVets = "SELECT id, name FROM vet ORDER BY name ASC";
    $rsVets = mysqli_query($conn, $sqlVets);
    $numVets = mysqli_num_rows($rsVets);
    for ($i = 1; $i <= $numVets; $i++) {
        $thisVet = mysqli_fetch_assoc($rsVets);
        echo "<option value='" . $thisVet["id"] . "'>" . $thisVet["name"] . "</option>";
    }
}

?>

<!DOCTYPE html>
<html>
    <?php include "assets/inc/head.php";?>
    <body id="appointments" class="flex-container">
        <?php include "assets/inc/sidemenu.php";?>
        <div class="page-contents">
            <h1>Appointments</h1>
            <form id="create-new" method="POST" action="assets/proc/create_appointment_process.php">
                <h2>Create New Appointment</h2>

                <label for="datetime">Date/Time</label>
                <input type="datetime-local" name="datetime"/>

                <label for="pet">Pet/Patient</label>
                <select name="pet">
                    <?php display_pets($conn);?>
                </select>

                <label for="reason">Reason for Visit</label>
                <input type="text" name="reason"/>

                <label for="vet">Consultant</label>
                <select name="vet">
                    <?php display_vets($conn);?>
                </select>

                <input type="submit" value="Search"/>
            </form>
        </div>

    </body>
</html>
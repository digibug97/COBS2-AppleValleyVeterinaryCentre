<?php

include "assets/inc/database_connection.php"; 

$search = isset($_GET['search']) ? $_GET['search'] : "";
$from = isset($_GET['from']) ? $_GET['from'] : "";
$to = isset($_GET['to']) ? $_GET['to'] : "";

function Search($search, $from, $to, $conn) {
    $sqlSearch = "SELECT appointment.id, appointment.datetime, appointment.reasonforvisit, pet.name AS petname, species.name AS species, vet.name AS vetname, COUNT(appointmentid) AS treatments
                    FROM appointment
                    INNER JOIN vet ON appointment.vetid = vet.id
                    INNER JOIN pet ON appointment.petid = pet.id
                    INNER JOIN species ON pet.speciesid = species.id
                    LEFT JOIN appointmenttreatment ON appointment.id = appointmenttreatment.appointmentid";

    if (!empty($search)) {
        $searchClause = "(pet.name LIKE '%$search%'
                        OR vet.name LIKE '%$search%'
                        OR species.name LIKE '%$search%'
                        OR reasonforvisit LIKE '%$search%')";
    }

    if (!empty($from) || !empty($to)) {
        if (!empty($from) && !empty($to)) {
            $dateClause = "(DATE(datetime) >= '$from' AND DATE(datetime) <= '$to')";
        } else if (!empty($from)) {
            $dateClause = "DATE(datetime) = '$from'";
        } else {
            $dateClause = "DATE(datetime) = '$to'";
        }
    }

    if (isset($searchClause)) {
        if (isset($dateClause)) {
            $sqlSearch .= " WHERE " . $searchClause . " AND " . $dateClause;
        } else {
            $sqlSearch .= " WHERE " . $searchClause; 
        }
    } else {
        if (isset($dateClause)) {
            $sqlSearch .= " WHERE " . $dateClause;
        }
    }
            
    $sqlSearch .= " GROUP BY appointment.id
                    ORDER BY appointment.datetime ASC";


    $rsSearch = mysqli_query($conn, $sqlSearch);
    $numberOfAppointments= mysqli_num_rows($rsSearch);

    if ($numberOfAppointments > 0) {
        echo "<tr>";
        echo    "<th>Date/Time</th>";
        echo    "<th>Pet</th>";
        echo    "<th>Species</th>";
        echo    "<th>Consultant</th>";
        echo    "<th>Reason for Visit</th>";
        echo    "<th>Seen</th>";
        echo "</tr>";
        for ($i = 1; $i <= $numberOfAppointments; $i++) {
            $thisPatient = mysqli_fetch_assoc($rsSearch);
            echo "<tr>";
            echo    "<td>" . date_format(date_create($thisPatient['datetime']), "l dS Y, H:i") . "</td>";
            echo    "<td>" . $thisPatient['petname'] . "</td>";
            echo    "<td>" . $thisPatient['species'] . "</td>";
            echo    "<td>" . $thisPatient['vetname'] . "</td>";
            echo    "<td>" . $thisPatient['reasonforvisit'] . "</td>";
            if ($thisPatient['treatments'] > 0) {
                echo "<td><i class='fa fa-check' aria-hidden='true'></i></td>";
            } else {
                echo "<td><i class='fa fa-times' aria-hidden='true'></i></td>";
            }
            echo    "<td class='view button'><a href='appointment.php?id=" . $thisPatient['id'] . "'><i class='fa fa-eye' aria-hidden='true'></i></a></td>";
            echo    "<td class='edit button'><a href='appointmentedit.php?id=" . $thisPatient['id'] . "'><i class='fa fa-pencil' aria-hidden='true'></i></a></td>";
            echo "</tr>";
        }
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
            <form id="search-box" method="GET" action="appointments.php">
                <input type="text" name="search" placeholder="Search" value="<?php echo $search;?>"/>
                <input type="date" name="from" value="<?php echo $from;?>"/>
                <input type="date" name="to" value="<?php echo $to;?>"/>
                <input type="submit" value="Search"/>
                <input type="button" value="View All" onclick="location.href='appointments.php'"/>               
                          
            </form>
            <table id="appointment-search-results" class="data-table">
                <?php Search($search, $from, $to, $conn); ?>
            </table>
        </div>

    </body>
</html>
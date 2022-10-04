<?php

include "assets/inc/database_connection.php"; 

function Search($conn) {
    if (isset($_POST['search'])) {
        $search = $_POST['search'];
    } else {
        $search = "";
    }   

    $sqlSearch = "SELECT pet.*, species.name AS species
                    FROM pet
                    INNER JOIN species ON pet.speciesid = species.id
                    WHERE pet.name LIKE '%$search%'
                    OR pet.address LIKE '%$search%'
                    OR pet.contactnumber LIKE '%$search%'
                    ORDER BY pet.name ASC";
    $rsSearch = mysqli_query($conn, $sqlSearch);
    $numberOfPatients = mysqli_num_rows($rsSearch);

    if ($numberOfPatients > 0) {
        echo "<tr>";
        echo    "<th>Name</th>";
        echo    "<th>Species</th>";
        echo    "<th>Date of Birth</th>";
        echo    "<th>Sex</th>";
        echo    "<th>Address</th>";
        echo    "<th>Contact Number</th>";
        echo "</tr>";
        for ($i = 1; $i <= $numberOfPatients; $i++) {
            $thisPatient = mysqli_fetch_assoc($rsSearch);
            echo "<tr>";
            echo    "<td>" . $thisPatient['name'] . "</td>";
            echo    "<td>" . $thisPatient['species'] . "</td>";
            echo    "<td>" . $thisPatient['dob'] . "</td>";
            echo    "<td class='sex'>" . ($thisPatient['sex'] == "M" ? "<i class='fa fa-mars' aria-hidden='true'></i>" : "<i class='fa fa-venus' aria-hidden='true'></i>") . "</td>";
            echo    "<td>" . $thisPatient['address'] . "</td>";
            echo    "<td>" . $thisPatient['contactnumber'] . "</td>";
            echo    "<td class='edit'><a href='petedit.php?id=" . $thisPatient['id'] . "'><i class='fa fa-pencil' aria-hidden='true'></i></a></td>";
            echo "</tr>";
        }
    }



}

?>

<!DOCTYPE html>
<html>
    <?php include "assets/inc/head.php";?>
    <body id="pets" class="flex-container">
        <?php include "assets/inc/sidemenu.php";?>
        <div class="page-contents">
            <h1>Pets/Patients</h1>
            <form id="search-box" method="POST" action="petsearch.php">
                <input type="text" name="search" placeholder="Search"/>
                <input type="submit" value="Search"/>                
            </form>
            <table id="pet-search-results" class="data-table">
                <?php Search($conn); ?>
            </table>
        </div>

    </body>
</html>
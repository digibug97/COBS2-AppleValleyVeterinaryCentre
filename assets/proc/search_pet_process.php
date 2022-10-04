<?php

$search = $_POST['search'];

$sqlSearch = "SELECT pet.*, species.name AS species
                FROM pet
                INNER JOIN pet ON pet.speciesid = species.id
                WHERE pet.name LIKE '%$search%'
                OR pet.address LIKE '%$search%'
                OR pet.contactnumber LIKE '%$search%'";
$rsSearch = mysqli_query($conn, $sqlSearch);



?>
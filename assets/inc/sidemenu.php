<?php

$today = date('Y-m-d');
$weekStart = date('Y-m-d', strtotime('monday this week'));
$weekEnd = date('Y-m-d', strtotime('sunday this week'));
?>

<div class="sidemenu">
    <h1>Apple Valley<i class="fa fa-pagelines" aria-hidden="true"></i><span>Veterinary Centre</span></h1>

    <ul>
        <li><a href="dashboard.php"><i class="fa fa-area-chart" aria-hidden="true"></i>Dashboard</a></li>
    </ul>

    <h2>Patients & Care</h2>
    <ul>
        <li class="droptrigger" onclick="ManageDropdown(this, 'appointments')"><i class="fa fa-calendar" aria-hidden="true"></i>Appointments<i class="fa fa-caret-right" aria-hidden="true"></i></li>
        <ul id="appointments-dropdown" class="dropdown">
            <li><a href="appointments.php?from=<?php echo $today;?>&to=<?php echo $today;?>"><i class="fa fa-calendar-check-o" aria-hidden="true"></i>Today</a></li>
            <li><a href="appointments.php?from=<?php echo $weekStart;?>&to=<?php echo $weekEnd;?>"><i class="fa fa-calendar-o" aria-hidden="true"></i>This Week</a></li>
            <li><a href="appointments.php"><i class="fa fa-search" aria-hidden="true"></i>Search</a></li>
        </ul>
        <li class="droptrigger" onclick="ManageDropdown(this, 'pets')"><i class="fa fa-paw" aria-hidden="true"></i>Pets/Patients<i class="fa fa-caret-right" aria-hidden="true"></i></li>
        <ul id="pets-dropdown" class="dropdown">
            <li><i class="fa fa-clock-o" aria-hidden="true"></i>Recent</li>
            <li><a href="petsearch.php"><i class="fa fa-search" aria-hidden="true"></i>Search</a></li>
        </ul>
        <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i>Customers</a></li>
        <li><i class="fa fa-paperclip" aria-hidden="true"></i>Prescriptions</li>
        <li><i class="fa fa-heartbeat" aria-hidden="true"></i>Treatments</li>
    </ul>

    <h2>Management</h2>
    <ul>
        <li><i class="fa fa-user-md" aria-hidden="true"></i>Staff</li>
        <li><i class="fa fa-comment" aria-hidden="true"></i>Feedback</li>
    </ul>

    <h2>Account</h2>
    <ul>
        <li><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</li>
    </ul>
</div>

<script>
    function ManageDropdown(button, dropdownName) {
        var state = button.querySelector('.fa-caret-right') == null ? "open" : "closed";
        var dropdown = document.querySelector('#' + dropdownName + '-dropdown');
        if (state == "open") {
            button.querySelector('.fa-caret-down').classList = "fa fa-caret-right";
            dropdown.style.display = "none";
        } else {
            button.querySelector('.fa-caret-right').classList = "fa fa-caret-down";
            dropdown.style.display = "block";
        }
    }
</script>
<?php

    if ($_SESSION['category'] != 'manager'){
        header("location: select_school.php");
    }


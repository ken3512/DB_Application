<?php
    include_once 'api_functions.php';
    if (isset($_POST['RSOID'])) {
        leaveRSO($_POST['RSOID'], $_POST['UserID']);
    }
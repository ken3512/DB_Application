<?php 
    include_once "header.php";
?>
<br>
<?php  

if (isset($_SESSION["ID"])) getUnapprovedRSO($_SESSION["ID"]);
else header("location: ../index");

?>


<?php 
    include_once "footer.php";
?>
<?php
    include_once "header.php";
?>
    <form action="api/createRSO.php" method="POST">
        <input type="text" name="Name" placeholder="RSON Name">
        <br>
        <input type="text" name="M1" placeholder="Member 1">
        <br>
        <input type="text" name="M2" placeholder="Member 2">
        <br>
        <input type="text" name="M3" placeholder="Member 3">
        <br>
        <input type="text" name="M4" placeholder="Member 4">
        <br>
        <button type="submit" name="submit">Register RSO</button>
    </form>

<?php 
    include_once "footer.php";
?>


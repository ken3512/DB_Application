<?php
    include_once "header.php";
?>
<br>

<form action="api/createRSO.php" method="POST">
        <input type="text" name="Name" placeholder="RSON Name">
        <br>
        <select name="M1">
            <?php allStudents(2);?>
        </select>
        <select name="M2">
            <?php allStudents(2);?>
        </select>
        <select name="M3">
            <?php allStudents(2);?>
        </select>
        <select name="M4">
            <?php allStudents(2);?>
        </select>
        <br>
        <button type="submit" name="submit">Register RSO</button>
</form>


<?php
    include_once "footer.php";
?>

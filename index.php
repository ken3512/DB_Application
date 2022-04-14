<?php
    include_once "header.php";
?>

<?php
    if (!isset($_SESSION["ID"])) {
        echo '
            <h2 class="pageTitle">Club Event Organizer Home Page!</h2>
            <p class="desc">Sign up <a href="signup.php">here</a> to make a new account!</p>
            <p class="desc">If you already have an account you can login <a href="login.php">here</a>.</p>
            <p class="desc">Or see all the public events <a href="events.php">here</a>!</p>
        ';
    }
    else {
?>
    <!-- <script src="./scripts/script.js"></script>
    <button onclick="setScrollPosition(200)">Set Scroll Position</button> -->
    <!-- User is logged in display the chatroom -->
    <h2 class="pageTitle">Welcome to the Chatroom!</h2>
    <div class="chatroom_outer">
        <div class="chatroom">
            <!-- Comment form -->
            <p class="desc"><br>Comment in the chatroom:</p>
            <form action="api/chatroomComment.php" method="POST">
                    <textarea class="CommentEntry" name="Comment" rows="4" cols="20" placeholder="Comment..."></textarea><br>
                <button class="commentSubmit" type="submit" name="submit">Comment</button>
            </form>

            <!-- Display comments -->
            <?php
                displayAllChatroomComments();
            ?>
        </div>
    </div>

    
<?php
    }
?>

<?php
    include_once "footer.php";
?>

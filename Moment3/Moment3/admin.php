<?php include ("includes/config.php");?>
<?php
// Initialize the session
session_start(); 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$posts = new Posts();
// Radera post
if(isset($_GET['delete_id'])){
    $delete_id = intval($_GET['delete_id']);
                        
    if($posts->deletePosts($delete_id)) {
        $message = "<p class='bold'>Post raderad!</p>";
    } else { 
        $message = "<div class='bold'>Fel vid radering!</div>";
    }
}
// Add post
if(isset($_POST['title'])){
    $title = $_POST['title'];
    $content = $_POST['content'];
    $username = $_POST['username'];

    if($posts->addPosts($title, $content,$username)) {
        $message = "<div class='bold'>Post skapad!</div>";
    } else {
        $message = "<div class='error'>Fel vid skapande av post!</div>";
    }
}
?>
<?php include("includes/head.php"); ?>
<body>
    <?php include("includes/header.php"); ?>
    <div class="container">
        <div class="row">
            
            <?php include("includes/navigering.php"); ?>
            <div class="right">
                <h2>Hej, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Välkommen till din sida.</h2>
                <div id="info"> 
                <h3>Skapa ett inlägg!</h3>

                <?php if(isset($message)) { echo $message;} ?>

                <form method="post" action="admin.php">
                    <div>
                        <label for="title">Titel:</label><br>
                        <input type="text" name="title" id="title">
                    </div>
                    <div>
                        <label for="content">Innehåll:</label> <br>
                        <textarea name="content" id="content" cols="30" rows="10"></textarea>
                    </div>
                    <div>
                        <label for="username">Användare:</label> <br>
                        <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($_SESSION["username"]); ?>" readonly> 
                    </div>
                    <br>
                    <input type="submit" value="Skapa post" class="btn">
                </form>
                <br>
                <?php 
                    $post_list = $posts->getPosts();

                    foreach($post_list as $c) {
                        echo "<h2>" . $c['title'] . "</h2>"
                        . "<p>" . $c['content'] . "</p>"
                        . "<a href='admin.php?delete_id=". $c['id'] . "'>Radera</a>"
                        . " - <a href='edit.php?id=" . $c['id'] . "'>Uppdatera</a>";
                    }  
                ?>

                </div><!-- /#info -->
                <p>
                    <a href="reset-password.php" class="btn">Återställ läsenord</a>
                    <a href="logout.php" class="btn">Logga ut</a>
                </p>
            </div><!-- /.right -->
            <?php include("includes/footer.php"); ?>
        </div><!-- /.row -->        
    </div><!-- /.container -->  
    <script>
        CKEDITOR.replace( 'content' );
    </script>  
</body>
</html>
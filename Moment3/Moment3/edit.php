<?php include ("includes/config.php");
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
}   else{
    header("Location: admin.php");
}
?>
<?php include("includes/head.php"); ?>
<body>
    <?php include("includes/header.php"); ?>
    <div class="container">
        <div class="row">
        <?php include("includes/navigering.php"); ?>
            <div class="right">
                <div id="info"> 
                    <?php       
                        $posts = new Posts();
                        $details = $posts->getPosts($id);
                        // Ändra post
                        if(isset($_POST['title'])){
                            $title = $_POST['title'] ;
                            $content = $_POST['content'];

                            if($posts->updatePosts($id, $title, $content)){
                                echo "<p>Post skapad!</p>";
                            } else {
                                echo "<p>Fel vid lagring!</p>";
                            }
                        }
                    ?>     
                    <h3>Ändra blogginlägg</h3>
                    <br>

                    <form method="post" action="edit.php?id=<?= $id; ?>">
                        <label for="title">Titel:</label><br>
                        <input type="text" name="title" id="title" value="<?= $details['title'] ??""; ?>"> 
                        <br>
                        <label for="content">Innehåll:</label><br>
                        <textarea name="content" id="content"> <?= $details['content'] ??""; ?></textarea> <br>
                        <br>
                        <input type="submit" value="Updatera post" class="btn" >
                    </form>

                </div><!-- /#info -->
                <p>
                    <a href="reset-password.php" class="btn">Återställ läsenord</a>
                    <a href="logout.php" class="btn">Logga ut</a>
                </p>
            </div><!-- /.right -->
            <?php include("includes/footer.php"); ?>
        </div><!-- /.row -->        
    </div><!-- /.container -->    
</body>
</html>
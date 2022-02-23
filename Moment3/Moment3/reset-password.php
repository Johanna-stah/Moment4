<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "includes/config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Skriv in nytt lösenord.";     
    } elseif(strlen(trim($_POST["new_password"])) < 5){
        $new_password_err = "Lösenordet måste minst ha 5 karaktärer.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Återskapa lösenordet.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Lösenordet matchade inte.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $mysqli->close();
}
?>
<?php require_once "includes/config.php";?>
<?php include("includes/head.php"); ?>
<body>
    <?php include("includes/header.php"); ?>
    <div class="container">
        <div class="row">
        <?php include("includes/navigering.php"); ?>
            <div class="right">
                <div id="info">      
                <h2>Återställ lösenord</h2>
                <p>Fyll i för att återställa ditt lösenord.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
                    <div  <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>>
                        <label>Nytt lösenord</label> <br>
                        <input type="password" name="new_password"  value="<?php echo $new_password; ?>">
                        <span><?php echo $new_password_err; ?></span>
                    </div>
                    <div  <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>>
                        <label>Upprepa lösenord:</label> <br>
                        <input type="password" name="confirm_password" >
                        <span><?php echo $confirm_password_err; ?></span>
                    </div>
                    <div c>
                        <input type="submit" class="btn" value="Skapa">
                        <a class="btn" href="admin.php">Avsluta</a>
                    </div>
                </form>
                </div>
            </div><!-- /.right -->
            <?php include("includes/footer.php"); ?>
        </div><!-- /.row -->        
    </div><!-- /.container -->    
</body>
</html>
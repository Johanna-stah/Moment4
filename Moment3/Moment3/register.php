<?php
// Include config file
require_once "includes/config.php";
 
// Define variables and initialize with empty values
$name = $username = $password = $confirm_password = "";
$name_err = $username_err = $password_err = $confirm_password_err = "";
 

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Skriv in ett användarnamn.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $username_err = "Det här användarnamnet är redan taget.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Något gick fel, prova igen senare!";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Skriv in ett lösenord.";     
    } elseif(strlen(trim($_POST["password"])) < 5){
        $password_err = "Lösenordet måste ha minst 5 karaktärer.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Upprepa lösenorded tack!";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Lösenordet matchade inte!";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (name,username, password) VALUES (?,?, ?)";
         
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sss", $param_name, $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Något gick fel, prova igen senare!";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $mysqli->close();
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
                <h2>Skapa konto</h2>
                <p>Fyll i formuläret för att skapa en inloggning.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>>
                            <label>Förnamn & efternamn:</label> <br>
                            <input type="text" name="name"  value="<?php echo $name; ?>">
                            <span><?php echo $name_err; ?></span>
                        </div>  
                        <div <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>>
                            <label>Användarnamn:</label> <br>
                            <input type="text" name="username"  value="<?php echo $username; ?>">
                            <span><?php echo $username_err; ?></span>
                        </div>    
                        <div <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>>
                            <label>Lösenord:</label> <br>
                            <input type="password" name="password"  value="<?php echo $password; ?>">
                            <span><?php echo $password_err; ?></span>
                        </div>
                        <div <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>>
                            <label>Upprepa lösenord:</label> <br>
                            <input type="password" name="confirm_password"  value="<?php echo $confirm_password; ?>">
                            <span><?php echo $confirm_password_err; ?></span>
                        </div>
                        <br>
                        <div>
                            <input type="submit" class="btn" value="Skapa konto">
                            <input type="reset" class="btn" value="Återställ">
                        </div>
                        <p>Har redan en inloggning? <a href="login.php">Logga in här</a>.</p>
                    </form>
                </div><!-- /#info -->
            </div><!-- /.right -->
            <?php include("includes/footer.php"); ?>
        </div><!-- /.row -->        
    </div><!-- /.container -->    
</body>
</html>
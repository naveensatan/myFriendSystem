<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
        <meta name="description" content="Advanced Web Development :: Assignment 2" />
        <meta name="keywords" content="Jobs,Web,programming" />
        <meta name="author" content="Naveen Satanarachchi (101419432)" />
        <!-- link to style sheet -->
        <link rel="stylesheet" href="style.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <title>My Friend System</title>
    </head>
    <body>
        <div class="main-container">
            <div class="signupform-page-heading">
                <h1>My Friend System</h1>
                <h2>Registration Page</h2>
            </div>
            <div class="signupform-errors">
                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") { //if form is posted
                        include ("signupprocess.php"); //include signup process script
                        $validatinErrors = isValid(); //get any validation errors

                        if (empty($validatinErrors)) { //if there are no validation errors
                            $res = process(); //continue with the registrarion and get the statues

                            if ($res) { //if registration status is succesfull
                                echo "<p>Registered succesfully...</p>";
                            }

                        } else { //if there are validation errors
                            echo "<ul>";
                            foreach($validatinErrors as $err) { //list all validation errors
                                echo "<li>$err</li>";
                            }
                            echo "</ul>";
                        }
                    }
                ?>
            </div>
            <form action="signup.php" method="POST">
                <div class="form-group">
                    <label for="email">Email: </label>
                    <input class="form-control" id="email" type="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' //if the field was given, fill the field with last given, if not leave it blank?>"/>
                </div>
                <div class="form-group">
                    <label for="pName">Profile Name: </label>
                    <input class="form-control" id="pName" type="text" name="pName" value="<?php echo isset($_POST['pName']) ? $_POST['pName'] : '' //if the field was given, fill the field with last given, if not leave it blank?>"/>
                </div>
                <div class="form-group">
                    <label for="password">Password: </label>
                    <input class="form-control" id="password" type="password" name="password"/>
                </div>
                <div class="form-group">
                    <label for="confirm">Confirm Password: </label>
                    <input class="form-control" id="confirm" type="password" name="confirm"/>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <input class="btn btn-primary mb-2" id="login" type="submit" name="register" value="Register"/>
                        </div>
                        <div class="col">
                            <input class="btn btn-danger mb-2" id="cancel" type="reset" name="clear" value="Clear"/>
                        </div>
                    </div>
                </div>
            </form>
            <div class="links-container-signupform">
                <div class="signupform-link-home-container">
                    <a href='index.php' class='signupform-link-home'>Home</a>
                </div>
            </div>
        </div>
    </body>
</html>
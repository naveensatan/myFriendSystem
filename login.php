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
            <div class="loginform-page-heading">
                <h1>My Friend System</h1>
                <h2>Log In Page</h2>
            </div>
            <div class="loginform-errors">
                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") { //if form is posted
                        include ("loginprocess.php"); //include login process
                        $validatinErrors = isValid(); //validate inputs and get any validation errors

                        if (empty($validatinErrors)) { // if there are no validation errors
                            header("location:friendlist.php"); //direct to friend list
                        } else { //if there are any validation errors
                            echo "<ul>";
                            foreach($validatinErrors as $err) { //display validation errors if any
                                echo "<li>$err</li>";
                            }
                            echo "</ul>";
                        }
                    }
                ?>
            </div>
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="email">Email: </label>
                    <input class="form-control" id="email" type="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' //if the field was given, fill the field with last given, if not leave it blank?>"/>
                </div>
                <div class="form-group">
                    <label for="password">Password: </label>
                    <input class="form-control" id="password" type="password" name="password"/>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <input class="btn btn-primary mb-2" id="login" type="submit" name="login" value="Log In"/>
                        </div>
                        <div class="col">
                            <input class="btn btn-danger mb-2" id="cancel" type="reset" name="clear" value="Clear"/>
                        </div>
                    </div>
                </div>
            </form>
            <div class="links-container-loginform">
                <div class="loginform-link-home-container">
                    <a href='index.php' class='loginform-link-home'>Home</a>
                </div>
            </div>
        </div>
    </body>
</html>
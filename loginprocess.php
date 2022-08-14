<?php
session_start(); //start or continue session
function isValid()
{
    $validationErrors = []; //initialize an array for validation errors

    require("settings.php"); //include login details to connect to server and database

    $mysqli = mysqli_init();
    $mysqli->ssl_set(NULL, NULL, "/etc/ssl/cert.pem", NULL, NULL);
    $mysqli->real_connect($HOST, $USERNAME, $PASSWORD, $DATABASE);

    if ($mysqli->connect_errno) {
        echo "<p>Couldn't connect to server: " . $mysqli->connect_error . "</p>";
    }

    $query = "SELECT `friend_id`, `friend_email`, `password`, `profile_name`, `num_of_friends` FROM `friends`"; //query to get details of all users

    $results = $mysqli->query($query) or die($mysqli->errno);

    $row = $results->fetch_assoc();

    $accounts = [];

    while ($row) {
        array_push($accounts, $row); //get values of the row and push to array
        $row = $results->fetch_assoc();
    }

    $mysqli->close();

    if ($_SERVER["REQUEST_METHOD"] = 'POST') { //if form is posted

        if (isset($_POST['email'])) { //if email is set
            if (!empty($_POST['email'])) { //if email empty
                $foundEmail = false; //set inital update status

                foreach ($accounts as $account) { //go through all existing emails
                    if ($account["friend_email"] == $_POST['email']) { //if given email can be found
                        $foundEmail = true; //update found status
                        $matchingAccount = $account; //get the account details of the matching account
                        break; //break the loop
                    }
                }

                if (!$foundEmail) { //if no email can be found
                    array_push($validationErrors, "No account found for given email"); //generate error and push to validation errors array    
                }

                if ($foundEmail) { //if ther's an account for given email
                    if (isset($_POST['password'])) { //if password is set
                        if (!empty($_POST['password'])) { //if password is empty
                            if ($matchingAccount["password"] == $_POST['password']) {  //if the given password mathces the matching account's password
                                if (!isset($_SESSION['userid'])) { //if session variable not set
                                    $_SESSION['userid']; //set session variable
                                }
                                if (!isset($_SESSION['username'])) { //if session variable not set
                                    $_SESSION['username']; //set session variable
                                }
                                if (!isset($_SESSION['num_friends'])) { //if session variable not set
                                    $_SESSION['num_friends']; //set session variable
                                }

                                $_SESSION['userid'] = $matchingAccount["friend_id"]; //assign the matchig account's id to session variable
                                $_SESSION['username'] = $matchingAccount["profile_name"]; //assign the matchig account's name to session variable
                                $_SESSION['num_friends'] = $matchingAccount["num_of_friends"]; //assign the matchig account's number of friends to session variable
                            } else {
                                array_push($validationErrors, "Password entered is not correct. Please try again"); //generate error and push to validation errors array    
                            }
                        } else {
                            array_push($validationErrors, "Please enter your password to login"); //generate error and push to validation errors array
                        }
                    } else {
                        array_push($validationErrors, "Please enter your password to login"); //generate error and push to validation errors array
                    }
                }
            } else {
                array_push($validationErrors, "Please enter your email to login"); //generate error and push to validation errors array    
            }
        } else {
            array_push($validationErrors, "Please enter your email to login"); //generate error and push to validation errors array
        }
    }

    return $validationErrors; //return validation errors
}

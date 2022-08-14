<?php
function isValid()
{
    $validationErrors = []; //initialize an array for validation errors

    require("settings.php"); //include login details to connect to server and database

    $mysqli = mysqli_init();
    $mysqli->ssl_set(NULL, NULL, "/etc/ssl/cert.pem", NULL, NULL);
    $mysqli->real_connect($HOST, $USERNAME, $PASSWORD, $DATABASE);

    if ($mysqli->connect_errno) {
        echo "<p>Couldn't connect to server: " . $mysqli->connect_error . "</p>";
    } else {
        $queryGetEmail = "SELECT friend_email FROM `friends`"; //query to get all emails of users

        $friendEmails = $mysqli->query($queryGetEmail); //execute query and get results
        $row = $friendEmails->fetch_row(); //fetch all emails
        $emails = []; //initialize an array to store fetched emails
        while ($row) { //loop through every row
            array_push($emails, $row[0]); //get the email in row and push to array
            $row = $friendEmails->fetch_row(); //go to next row
        }

        $mysqli->close(); //close connection

    }

    if ($_SERVER["REQUEST_METHOD"] = 'POST') { //if form is posted

        if (isset($_POST['email'])) { //if email is set
            if (!empty($_POST['email'])) { //if email empty
                if (preg_match("/^(([^<>()\[\]\\.,;:\s@']+(\.[^<>()\[\]\\.,;:\s@']+)*)|('.+'))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/", $_POST['email'])) { //if email matches format
                    foreach ($emails as $email) { //go through all existing emails
                        if ($email == $_POST['email']) { //if any of the existing emails match given email
                            array_push($validationErrors, "Entered email already exists"); //generate error and push to validation errors array
                        }
                    }
                } else {
                    array_push($validationErrors, "Please enter a valid email address"); //generate error and push to validation errors array
                }
            } else {
                array_push($validationErrors, "Email is REQUIRED"); //generate error and push to validation errors array    
            }
        } else {
            array_push($validationErrors, "Email is REQUIRED"); //generate error and push to validation errors array
        }

        if (isset($_POST['pName'])) { //if profile name is set
            if (!empty($_POST['pName'])) { //if profile name is empty
                if (!preg_match("/^[A-Za-z]/", $_POST['pName'])) { //if profile name do not match format
                    array_push($validationErrors, "Profile Name must only have letters"); //generate error and push to validation errors array
                }
            } else {
                array_push($validationErrors, "Profile Name is REQUIRED"); //generate error and push to validation errors array
            }
        } else {
            array_push($validationErrors, "Profile Name is REQUIRED"); //generate error and push to validation errors array
        }

        if (isset($_POST['password'])) { //if password is set
            if (!empty($_POST['password'])) { //if password is empty
                if (!preg_match("/^[A-Za-z0-9]/", $_POST['password'])) { //if password do not match format
                    array_push($validationErrors, "Password should only have letters and numbers"); //generate error and push to validation errors array
                } else {
                    $pwd = $_POST['password'];
                }
            } else {
                array_push($validationErrors, "Password is REQUIRED"); //generate error and push to validation errors array
            }
        } else {
            array_push($validationErrors, "Password is REQUIRED"); //generate error and push to validation errors array
        }

        if (!empty($_POST['password'])) {
            if (isset($_POST['confirm'])) { //if confirm password is set
                if (!empty($_POST['confirm'])) { //if confirm password is empty
                    if (!preg_match("/$pwd/", $_POST['confirm'])) { //if passwords doesn't match
                        array_push($validationErrors, "Password doesn't match"); //generate error and push to validation errors array
                    }
                } else {
                    array_push($validationErrors, "Please confirm the password"); //generate error and push to validation errors array
                }
            } else {
                array_push($validationErrors, "Please confirm the password"); //generate error and push to validation errors array
            }
        }
    }

    return $validationErrors; //return validatation errors
}

function process()
{
    $email = $_POST['email']; //get email from form and save it
    $pName = $_POST['pName']; //get pName from form and save it
    $password = $_POST['password']; //get password from form and save it
    $startDate = date("Y-m-j"); //get today's date and save it
    $numOfFriends = 0; //initialize number of friends

    require("settings.php"); //include login details to connect to server and database

    $mysqli = mysqli_init();
    $mysqli->ssl_set(NULL, NULL, "/etc/ssl/cert.pem", NULL, NULL);
    $mysqli->real_connect($HOST, $USERNAME, $PASSWORD, $DATABASE);

    if ($mysqli->connect_errno) {
        echo "<p>Couldn't connect to server: " . $mysqli->connect_error . "</p>";
    } else {
        $queryAddFriend = "INSERT INTO friends (`profile_name`, `friend_email`, `password`, `date_started`, `num_of_friends`) VALUES ('$pName','$email','$password','$startDate',$numOfFriends)"; //query to add user

        $res = $mysqli->query($queryAddFriend) or die($mysqli->error); //execute query and add user

        $mysqli->close(); //close connection
    }

    return $res; //return the status of addition
}

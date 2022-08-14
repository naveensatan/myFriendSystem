<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Advanced Web Development :: Assignment 2" />
    <meta name="keywords" content="Jobs,Web,programming" />
    <meta name="author" content="Naveen Satanarachchi (101419432)" />
    <!-- link to style sheet -->
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>My Friend System</title>
</head>

<body>
    <div class="main-container">
        <div class="mysql-errs">
            <?php
            session_start(); //start or continue session
            $currentUserID = $_SESSION['userid']; //get session value for user id
            $currentUser = $_SESSION['username']; //get session value for user name
            $numOfFriends = $_SESSION['num_friends']; //get session value for number of friends

            if (!isset($_SESSION['userid'])) { //if session variable is not set (no logged in users)
                header("location:login.php"); //redirect to login page
            }

            require("settings.php"); //include login details to connect to server and database

            $mysqli = mysqli_init();
            $mysqli->ssl_set(NULL, NULL, "/etc/ssl/cert.pem", NULL, NULL);
            $mysqli->real_connect($HOST, $USERNAME, $PASSWORD, $DATABASE);

            if ($mysqli->connect_errno) {
                echo "<p>Couldn't connect to server: " . $mysqli->connect_error . "</p>";
            } else {
                $query = "SELECT friend_id2 FROM `myfriends` WHERE friend_id1 = $currentUserID;"; //get friendships of current user
                $queryAllUsers = "SELECT friend_id,profile_name FROM `friends`;"; //get all availabe users

                $results = $mysqli->query($query) or die($mysqli->error);
                $resultsUsers = $mysqli->query($queryAllUsers) or die($mysqli->error);

                $rowMutual = $results->fetch_assoc();
                $rowUsers = $resultsUsers->fetch_assoc();

                $mutualFriends = []; //initialize array for mutual friends
                $allUsers = []; //initialize array for all friends

                while ($rowMutual) { //loop through all rows
                    array_push($mutualFriends, $rowMutual); //get the value of row and push to array
                    $rowMutual = $results->fetch_assoc(); //get next row
                }

                while ($rowUsers) { //loop through all rows
                    array_push($allUsers, $rowUsers); //get the value of row and push to array
                    $rowUsers = $resultsUsers->fetch_assoc(); //get next row
                }

                $mysqli->close();
            }
            ?>
        </div>
        <div class="friendlist-page-heading">
            <h1>My Friend System</h1>
            <!-- display currntly logged in user's name -->
            <h2><?php echo $currentUser ?>'s Friend List Page</h2>
            <!-- display currntly logged in user's number of friends -->
            <p>Total number of friends is <?php echo $numOfFriends ?></p>
        </div>
        <div class="friendlist-page-body">
            <?php

            $mysqli = mysqli_init();
            $mysqli->ssl_set(NULL, NULL, "/etc/ssl/cert.pem", NULL, NULL);
            $mysqli->real_connect($HOST, $USERNAME, $PASSWORD, $DATABASE);

            if ($mysqli->connect_errno) {
                echo "<p>Couldn't connect to server: " . $mysqli->connect_error . "</p>";
            } else {
                $friendList = []; //initialize an array for friends
                if (!empty($mutualFriends)) { //if there are friends for current user
                    foreach ($mutualFriends as $mutual) { //go through all friends of current user
                        $x = $mutual["friend_id2"]; //get current user's friend name
                        $queryGet = "SELECT friend_id,profile_name FROM `friends` WHERE friend_id = $x ORDER BY profile_name"; //query to get the profile name of the current user's friend

                        $result = $mysqli->query($queryGet) or die($mysqli->error);

                        $row = $result->fetch_assoc();

                        while ($row) { //loop through all rows
                            array_push($friendList, $row); //get the name of the first row and push to array
                            $row = $result->fetch_assoc(); //loop to next row
                        }
                    }

                    echo "<table class='table table-hover'>"; //create a table

                    //sort friend list
                    foreach ($friendList as $key => $entry) {
                        $name[$key] = $entry['profile_name'];
                    }
                    array_multisort($name, SORT_ASC, $friendList);


                    foreach ($friendList as $friend) { //go through all friends
                        echo "<tr><td>" . $friend['profile_name'] . "</td><td><a class='badge badge-danger mb-3' href=\"unfriend.php?id=" . $friend['friend_id'] . "\">Unfriend</a></td></tr>"; //list names of the current user's friends
                    }
                    echo "</table>";
                }
            }

            $mysqli->close(); //close database connection
            ?>
        </div>
        <!-- links to other pages -->
        <div class="links-container-friendlist">
            <div class="link-friendlist-container">
                <a href='friendadd.php' class='addfriend_link_friendlist'>Add Friends</a>
            </div>
            <div class="link-friendlist-container">
                <a href='logout.php' class='logout_link_friendlist'>Logout</a>
            </div>
        </div>
    </div>
</body>

</html>
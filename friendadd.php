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
        <?php
        session_start(); //start/continue the session
        if (!isset($_SESSION['userid'])) { //if session variable 'user id' is NOT set (no logged in users)
            header("location:login.php"); //redirect to login form
        }
        $currentUserID = $_SESSION['userid']; //get session varioble 'user id'
        $currentUser = $_SESSION['username']; //get session varioble 'user name'
        $numOfFriends = $_SESSION['num_friends']; //get session varioble 'number of friends'
        ?>

        <div class="friendadd-page-heading">
            <h1 class="">My Friend System</h1>
            <!-- display currntly logged in user's name -->
            <h2><?php echo $currentUser ?>'s Add Friend Page</h2>
            <!-- display currently logged in user's number of friends -->
            <p>Total number of friends is <?php echo $numOfFriends ?></p>
        </div>

        <div class="friendadd-page-body">
            <?php
            require("settings.php"); //include db connection details

            $mysqli = mysqli_init();
            $mysqli->ssl_set(NULL, NULL, "/etc/ssl/cert.pem", NULL, NULL);
            $mysqli->real_connect($HOST, $USERNAME, $PASSWORD, $DATABASE);

            if ($mysqli->connect_errno) {
                echo "<p>Couldn't connect to server: " . $mysqli->connect_error . "</p>";
            } else {
                //mysql query to get users that are NOT friends of the currently logged in user
                $query = "SELECT profile_name,friend_id FROM `friends`
                        WHERE friend_id IN
                        (SELECT DISTINCT(friend_id1) FROM `myfriends` 
                        WHERE friend_id1 NOT IN (SELECT friend_id2 FROM myfriends 
                                                 WHERE friend_id1 = $currentUserID)
                                                 AND friend_id1 <> $currentUserID)
                        OR (num_of_friends = 0 AND friend_id <> $currentUserID) ORDER BY profile_name";

                $results = $mysqli->query($query) or die($mysqli->error);

                $perspectiveFriends = []; //initialize an array to store query results

                $rowFriends = $results->fetch_assoc();

                while ($rowFriends) { //loop through every available row in results
                    array_push($perspectiveFriends, $rowFriends); //push data in row to array
                    $rowFriends = $results->fetch_assoc(); //fetch the next row
                }

                $mysqli->close();
            }

            echo "<table class='table table-hover'>"; //create a table to show query results
            foreach ($perspectiveFriends as $friend) { //go through every row data
                $name = $friend["profile_name"]; //get the value of field name 'profile_name'
                echo "<tr><td>" . $name . "</td><td><a class='badge badge-primary mb-3' href=\"addfriend.php?id=" . $friend['friend_id'] . "\">Add as friend</a></td></tr>"; //list the name and the button to add as a friend
            }
            echo "</table>"; //end table
            ?>
        </div>
        <!-- links to Friend List and Logout-->
        <div class="friendadd-links-container">
            <div class="link-friendadd">
                <a href='friendlist.php' class='friendlist_link_friendadd'>Friend List</a>
            </div>
            <div class="link-friendadd">
                <a href='logout.php' class='logout_link_friendadd'>Logout</a>
            </div>
        </div>
    </div>
</body>

</html>
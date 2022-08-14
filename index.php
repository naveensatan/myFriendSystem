<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Advanced Web Development :: Assignment 2" />
    <meta name="keywords" content="Jobs,Web,programming" />
    <meta name="author" content="Naveen Satanarachchi (101419432)" />
    <!-- link to style sheet -->
    <link rel="stylesheet" href="style.css" />
    <title>My Friend System</title>
</head>

<body>
    <div class="main-container">
        <div class="heading-container">
            <h1 class="heading">My Friend System</h1>
        </div>
        <!-- student details -->
        <div class="details-container">
            <p class='index_name'>Name: Naveen Priyanjith Satanarachchi</p>
            <p class='index_studentid'>Student ID: 101419432</p>
            <a href="mailto:101419432@student.swin.edu.au" class='index_email'>Email: 101419432@student.swin.edu.au</a>
        </div>
        <!-- statement -->
        <div class="statement-container">
            <p class='index_statement'>I declare that this assignment is my individual work. I have not worked collaboratively nor have I copied from any other student’s work or from any other source</p>
        </div>
        <!-- links to other pages -->
        <div class="links-container">
            <div class="link-signup">
                <p><a href='signup.php' class='index_link_signup'>Sign-Up</a></p>
            </div>
            <div class="link-login">
                <p><a href='login.php' class='index_link_login'>Log-In</a></p>
            </div>
            <div class="link-about">
                <p><a href='about.php' class='index_link_about'>About the assignment</a></p>
            </div>
        </div>
    </div>
    <?php
    require_once("settings.php"); //get server logins

    $mysqli = mysqli_init();
    $mysqli->ssl_set(NULL, NULL, "/etc/ssl/cert.pem", NULL, NULL);
    $mysqli->real_connect($HOST, $USERNAME, $PASSWORD, $DATABASE);

    if ($mysqli->connect_errno) {
        echo "<p>Couldn't connect to server: " . $mysqli->connect_error . "</p>";
    } else {
        $queryFriends = "CREATE TABLE IF NOT EXISTS friends(friend_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,friend_email VARCHAR(50) NOT NULL,password VARCHAR(20) NOT NULL,profile_name VARCHAR(30) NOT NULL,date_started DATE NOT NULL,num_of_friends INT UNSIGNED);"; //mysql query for friends table
        $queryMyFriends = "CREATE TABLE IF NOT EXISTS myfriends(friend_id1 INT NOT NULL,friend_id2 INT NOT NULL)"; //mysql query for my friends table
        $queryCheckFriendsTable = "SELECT * FROM `friends`"; //query to check if table is empty
        $queryCheckMyFriendsTable = "SELECT * FROM `myfriends`"; //query to check if table is empty

        try {
            runQuery($mysqli, $queryFriends);
            runQuery($mysqli, $queryMyFriends);
            $resFriend = runQuery($mysqli, $queryCheckFriendsTable);
            $resMyFriend = runQuery($mysqli, $queryCheckMyFriendsTable);

            if (mysqli_num_rows($resFriend) == 0) { //if friend table is empty
                $queryAddFriends = "INSERT INTO friends (`date_started`,`friend_email`,`num_of_friends`,`password`,`profile_name`)
                        VALUES ('2021-04-13','nate@abc.com',3,'nate123','Nate Haywood'),
                        ('2021-02-21','john@abc.com',2,'joh123','John Constantine'),
                        ('2020-12-20','sarah@abc.com',2,'sarah123','Sarah Lance'),
                        ('2021-01-18','jack@abc.com',2,'jack123','Jeferson Jackson'),
                        ('2021-04-24','martin@abc.com',3,'martin123','Martin Stein'),
                        ('2021-07-11','raymond@abc.com',0,'raymond123','Raymond Palmer'),
                        ('2021-10-13','leo@abc.com',3,'leo123','Leonard Snart'),
                        ('2020-11-18','mick@abc.com',2,'mick123','Mick Rory'),
                        ('2021-03-31','zari@abc.com',3,'zari123','Zari Tomaz'),
                        ('2021-02-28','amaya@abc.com',0,'amaya123','Amaya Jiwe')"; //query to add sample data
                runQuery($mysqli, $queryAddFriends);
            }

            if (mysqli_num_rows($resMyFriend) == 0) { //if myfriend table is empty
                $queryAddMyfriends = "INSERT INTO myfriends (`friend_id1`,`friend_id2`)
                        VALUES (1,9),
                        (9,1),
                        (2,3),
                        (3,2),
                        (4,1),
                        (1,4),
                        (5,9),
                        (9,5),
                        (4,9),
                        (9,4),
                        (1,7),
                        (7,1),
                        (8,5),
                        (5,8),
                        (3,7),
                        (7,3),
                        (8,7),
                        (7,8),
                        (2,5),
                        (5,2)"; //query to add sample data
                runQuery($mysqli, $queryAddMyfriends);
            }
        } catch (MySQLException $e) {
            echo "Failed to run query " . $e;
        }
    }
    $mysqli->close();
    ?>
</body>

</html>
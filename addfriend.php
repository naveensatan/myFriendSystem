<?php
session_start(); //start or continue session
$currentUserID = $_SESSION['userid']; //get current session user id
$currentUser = $_SESSION['username']; // get current session user name

$profileId = $_GET['id']; //get the correspondig id of the user that needs to be added

require("settings.php"); //include login details to connect to server and database

$mysqli = mysqli_init();
$mysqli->ssl_set(NULL, NULL, "/etc/ssl/cert.pem", NULL, NULL);
$mysqli->real_connect($HOST, $USERNAME, $PASSWORD, $DATABASE);

if ($mysqli->connect_errno) {
    echo "<p>Couldn't connect to server: " . $mysqli->connect_error . "</p>";
} else {
    $addQuery = "INSERT INTO myfriends (friend_id1,friend_id2) VALUES ($currentUserID,$profileId);
                INSERT INTO myfriends (friend_id1,friend_id2) VALUES ($profileId,$currentUserID)"; //query to insert friendship
    $updateQuery = "UPDATE friends SET num_of_friends = num_of_friends + 1 WHERE friend_id = $currentUserID;
                    UPDATE friends SET num_of_friends = num_of_friends + 1 WHERE friend_id = $profileId;"; //query to update number of friends

    $mysqli->multi_query($addQuery) or die($mysqli->errno); //execute adding query
    $mysqli->next_result();
    $mysqli->multi_query($updateQuery) or die($mysqli->errno);


    $mysqli->close();

    $numOfFriends = $_SESSION['num_friends']; //get the current user's number of friends
    $numOfFriends++; //increment by 1
    $_SESSION['num_friends'] = $numOfFriends; //assign the incremented value back
    header("location:friendadd.php"); //redirect to friend add page    
}

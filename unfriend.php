<?php
session_start(); //continue / start session
$currentUserID = $_SESSION['userid']; //get current value of session variable
$currentUser = $_SESSION['username']; //get current value of session variable

$profileId = $_GET['id']; //get the corresponding profile id of the user that needs to be removed

require("settings.php"); //include login details to connect to server and database

$mysqli = mysqli_init();
$mysqli->ssl_set(NULL, NULL, "/etc/ssl/cert.pem", NULL, NULL);
$mysqli->real_connect($HOST, $USERNAME, $PASSWORD, $DATABASE);

if ($mysqli->connect_errno) {
    echo "<p>Couldn't connect to server: " . $mysqli->connect_error . "</p>";
} else {
    $deleteQuery = "DELETE FROM myfriends WHERE (friend_id1,friend_id2) IN (($currentUserID,$profileId),($profileId,$currentUserID))"; //query to delete friendship
    $updateQuery = "UPDATE friends SET num_of_friends = num_of_friends - 1 WHERE friend_id = $currentUserID;
                    UPDATE friends SET num_of_friends = num_of_friends - 1 WHERE friend_id = $profileId;"; //queries to update number of friends for both parties

    $mysqli->query($deleteQuery) or die($mysqli->errno); //execute adding query
    // $mysqli->next_result();
    $mysqli->multi_query($updateQuery) or die($mysqli->errno);

    $mysqli->close();

    $numOfFriends = $_SESSION['num_friends']; //get session variable for number of friends
    $numOfFriends--; //decrement by 1
    $_SESSION['num_friends'] = $numOfFriends; //assign the decremented value back to session variable
    header("location:friendlist.php"); //redirect to friendlist page
}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Advanced Web Development :: Assignment 2" />
    <meta name="keywords" content="Jobs,Web,programming" />
    <meta name="author" content="Naveen Satanarachchi (101419432)" />
    <title>Jobs Posting System</title>
    <!-- custom css -->
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <div class="main-container">
        <div class="aboutpage-heading">
            <h1 class="heading">My Friend System - About</h1>
        </div>
        <!-- questions & answers-->
        <div class="body-container">
            <p>What tasks you have not attempted or not completed?</p>
            <p class="answers"> Task 1,2 and 3 are attempted and completed. Extra challenge is not attempted.</p>
            <p>What special features have you done, or attempted, in creating the site that we should know about?</p>
            <p class="answers">Bootstrap styles have been used for styling of forms and "Flexbox" layout model has been used in custom CSS to layout pages.</p>
            <p>Which parts did you have trouble with?</p>
            <p class="answers">Had to refer multiple resources to figure out the MYSQL query to generate results for friendadd.php script. Struggled with executing multiple "multi_query" statements as the 2nd "multi_query" kept failing to execute because the database connection was busy until the 1st query is executed. Resolved the issue using "mysqli_next_result" where it forces the database connection to wait until one query is executed.</p>
            <p>What would you like to do better next time?</p>
            <p class="answers"> I would try to brush up my knowledge in MySQL to understand and write comprehensive queries get results, other than using programming techniques to manipulate results.</p>
            <p>Screenshot of a discussion.</p>
            <div class="scrennshots-container">
                <img src="images/discussion.png" alt="discussion_screenshot" />
            </div>
        </div>
        <!-- page links -->
        <div class="aboutpage-links-container">
            <div class="aboutpage-links">
                <a href="friendlist.php">Friend List</a>
            </div>
            <div class="aboutpage-links">
                <a href="friendadd.php">Add Friends</a>
            </div>
            <div class="aboutpage-links">
                <a href="index.php">Return to Home Page</a>
            </div>
        </div>
    </div>
</body>

</html>
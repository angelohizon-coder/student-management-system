<?php
    #the include_once keyword is used to embed PHP code from another file.
    include_once("connections/connections.php");

    $connection = connection();

    #checks if there's an connection error
    if($connection->connect_error) {
        echo $connection->connect_error;
    }

    #if session is empty then the next thing to do is to start it
    if(!isset($_SESSION)) {
        session_start();
    }

    #if session is empty then the next thing to do is to start it
    if(isset($_SESSION['UserLogin'])) {
        echo "Welcome ".$_SESSION['UserLogin'];
    } else {
        echo "Welcome Guest";
    }

    #isset check if there's value
    #$_POST by itself checks all POST request and response
    #$_POST['submit'] checks the element with name "submit" if there's a post
    if(isset($_POST['submit'])) {

        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $gender = $_POST['gender'];

        $sql = "INSERT INTO `student_list`(`first_name`, `last_name`, `gender`) VALUES ('$firstname', '$lastname', '$gender')";

        $addStudents = $connection->query($sql) or die ($connection->error);

        #the purpose of this function is to redirect the page
        echo header("Location: index.php");
    }
?>

<html>
    <head>
        <title>PHP Tutorial sa Tagalog</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>
        <form action="" method="post">

            <label for="firstname">First Name</label>
            <input type="text" name="firstname" id="firstname">

            <label for="lastname">Last Name</label>
            <input type="text" name="lastname" id="lastname">

            <label for="gender">Gender</label>
            <select name="gender" id="gender">
                <option value="Male">Male</option>
                <!-- default option is female -->
                <option value="Female" selected="selected">Female</option>
            </select>

            <input type="submit" name="submit" value="Submit Form">

        </form>
    </body>
</html>
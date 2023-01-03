<?php
    #the include_once keyword is used to embed PHP code from another file.
    include_once("connections/connections.php");

    $connection = connection();
    $editChecker = false;

    #checks if there's an connection error
    if($connection->connect_error) {
        echo $connection->connect_error;
    }

    #if session is empty then the next thing to do is to start it
    if(!isset($_SESSION)) {
        session_start();
    }

    #if session is empty then the next thing to do is to start it
    if(isset($_SESSION['Access']) && $_SESSION['Access'] == "admin") {
        echo "Welcome ".$_SESSION['Access'];
    } else {
        echo header("Location: index.php");
    }

    if(isset($_GET['ID'])) {
        $id = $_GET['ID'];
        $sql = "SELECT * FROM student_list WHERE id = '$id'";

        $student_info = $connection->query($sql) or die ($connection->error);
        $row = $student_info->fetch_assoc();
    }

    if(isset($_POST['edit'])) {
        $editFirstname = $_POST['editFirstname'];
        $editLastname = $_POST['editLastname'];
        $editGender = $_POST['editGender'];
        $sql = "UPDATE `student_list` SET `first_name`='$editFirstname',`last_name`='$editLastname',`gender`='$editGender' WHERE id = '$id'";

        $edit_user_information = $connection -> query($sql) or die($connection -> error);

        $editChecker = true;
    }
?>

<html>
    <head>
        <title>PHP Tutorial sa Tagalog</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>
        <br>
        <br>
        
        <nav class='navbar'>
            <div class='nav-link'>
                <a href="details.php?ID=<?php echo $_GET['ID'] ?>">Return</a>
            </div>
            <a href="logout.php">Logout</a>
        </nav>
        <br>
        <h1>Edit Account Details</h1>
        <form action="" method="POST">
            <label for="editFirstname">First Name: </label>
            <input type="text" name="editFirstname" id="editFirstname" value="<?php echo $row['first_name']?>" >
            <br><br>
            <label for="editLastname">Last Name: </label>
            <input type="text" name="editLastname" id="editLastname" value="<?php echo $row['last_name']?>">
            <br><br>
            <label for="editGender">Gender: </label>
            <select name="editGender" id="editGender">
                <option value="<?php echo $row['gender']?>" selected="Selected">Current Value: <?php echo $row['gender']?></option>
                <option value="Male">Male</option>
                <!-- default option is female -->
                <option value="Female">Female</option>
            </select>
            <br><br>
            <input type="submit" value="Submit" name="edit">
            <br><br>
            <?php
                if($editChecker) {
                    echo "Sucessfully edit user information";
                }
            ?>
        </form>
    </body>
</html>
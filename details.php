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

    if(isset($_POST['delete'])) {
        $deleteId = $row['id'];
        $sql = " DELETE FROM `student_list` WHERE id = '$deleteId'";

        $delete_user_information = $connection -> query($sql) or die ($connection -> error);

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
        <br>
        <br>
        
        <nav class='navbar'>
            <div class='nav-link'>
                <a href="index.php">Return</a>
                <a href="edit.php?ID=<?php echo $row['id'] ?>">Edit</a>
                <form action="" method="POST">
                    <input type="submit" value="Delete" name="delete">
                </form>
            </div>
            <a href="logout.php">Logout</a>
        </nav>
        <br>
        <p name="firstname">First Name: <?php echo $row['first_name']?></p>
        <p name="lastname">Last Name: <?php echo $row['last_name']?></p>
        <p name="gender">Gender: <?php echo $row['gender']?></p>
    </body>
</html>
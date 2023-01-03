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

    $search = $_GET['search'];
    #wildcard search
    $sql = "SELECT * FROM student_list WHERE first_name LIKE '%$search%' || last_name LIKE '%$search%' ORDER BY id DESC";
    #if command is correct then the query will be saved in the students variable
    #else it will to an error
    $students = $connection->query($sql) or die ($connection->error);
    $row = $students->fetch_assoc();
?>

<html>
    <head>
        <title>PHP Tutorial sa Tagalog</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>
        <h1>Student Management System</h1>
        <br>
        <br>

        <form action="" method="GET">
            <input type="text" name="search">
            <input type="submit" value="Search">
        </form>

        <nav class='navbar'>
            <div>
                <a href="add.php">Add New</a>
            </div>
            <a href="logout.php">Logout</a>
        </nav>
        <table>
            <thead>
                <tr>
                    <?php if($_SESSION['Access'] == "admin") { ?>
                        <th></th>
                    <?php }?>
                    <th>First Name</th>
                    <th>Last Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    #only do this when there's content within the table
                    if(isset($row)){
                        do{
                ?>
                    <tr>
                        <?php if($_SESSION['Access'] == "admin") { ?>
                            <td>
                                <!-- pass the information to another page through GET request/response -->
                                <a href="details.php?ID=<?php echo $row['id']?>">View</a>
                            </td>
                        <?php }?>
                        <td><?php echo $row['first_name']?></td>
                        <td><?php echo $row['last_name']?></td>
                    </tr>
                <?php
                        } while($row = $students->fetch_assoc());
                    }
                ?>
            </tbody>
        </table>

        <!-- Old Version -->
        <?php
            #will fetch each record if the SQL is for reading (select)
            #then print the first_name and last_name
            #do{
        ?>

        <!-- <p> -->
            <?php
                #echo $row['first_name']." ".$row["last_name"]."\n";
            ?>
        <!-- </p> -->

        <?php
            #} while($row = $students->fetch_assoc());
        ?>
    </body>
</html>
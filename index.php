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

    #pagination start

    if(isset($_GET['page_no']) && $_GET['page_no'] !== "") {
        $page_no = $_GET['page_no'];
    } else {
        $page_no = 1;
    }

    $next_page = $page_no + 1;
    $previous_page = $page_no - 1;

    #limits the number of records within a page of the table
    $total_records_per_page = 10;

    #offset is basically a way to skip records
    $offset = ($page_no - 1) * $total_records_per_page;

    $sql = "SELECT * FROM student_list LIMIT $offset, $total_records_per_page";
    #if command is correct then the query will be saved in the students variable
    #else it will to an error
    $students = $connection->query($sql) or die ($connection->error);
    $row = $students->fetch_assoc();

    $number_of_records = $connection->query("SELECT COUNT(*) as total_records FROM student_list") or die($connection->error);
    $records = mysqli_fetch_array($number_of_records);
    $total_records = $records['total_records'];
    $total_number_of_pages = ceil($total_records / $total_records_per_page);
    #pagination end
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

        <!-- action allows us to redirect to another page -->
        <form action="result.php" method="GET">
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

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                    <!-- enables or disables an anchor depending on the condition within the ternary operator -->
                    <!-- the same is true with href wherein it will do a GET request and on the header will instantiated at the start of pagination section -->
                    <a class="page-link <?= ($page_no <= 1) ? 'disabled' : "" ?>" <?= ($page_no > 1) ? "href=?page_no=".$previous_page : '' ?> aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                
                <!-- showcases the number of pages within the table -->
                <?php for($counter = 1; $counter <= $total_number_of_pages; $counter++) { ?>
                    <li class="page-item"><a class="page-link" href="?page_no=<?php echo $counter?>"><?php echo $counter ?></a></li>
                <?php } ?>

                <li class="page-item">
                    <!-- same concept is applied for the next page but differs since the preceding one focuses on previous pages -->
                    <a class="page-link <?= ($page_no >= $total_number_of_pages) ? 'disabled' : "" ?>" <?= ($page_no < $total_number_of_pages) ? "href=?page_no=".$next_page : '' ?> aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>

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
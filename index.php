<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>mNotes - TODO APP | PHP CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">



    <?php
    $insert = false;
    $update = false;
    $delete = false;
    //Database Connection 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "notes";


    // Create Connection
    $conn = mysqli_connect($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection Failed" . $conn->connect_error);
    }

    // Delete Data from database
    if (isset($_GET['delete'])) {
        $no = $_GET['delete'];
        $sql = "DELETE FROM `note` WHERE `note`.`no` = $no";
        $result = mysqli_query($conn, $sql);
        $delete = true;
    }
    // Delete Message
    if ($delete) {
        echo '<div class="z-3 position-absolute top-[50px] start-50 w-25 alert alert-success alert-dismissible fade show" role="alert">Data Deleted successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    } else {
        echo '<div class="z-3 position-absolute top-[50px] start-50 w-25 alert alert-danger alert-dismissible fade show" role="alert">' . 'Error Deleting data : ' . $conn->error . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    }

    // Insert and Update Data
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['noEdit'])) {
            // Update the record
            $no = $_POST['noEdit'];
            $title = $_POST["titleEdit"];
            $description = $_POST["descriptionEdit"];

            // SQL query to insert data
            $sql = "UPDATE `note` SET `title` = '$title', `description` = '$description' WHERE `note`.`no` = $no";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $update = true;
            }
            // Update Message
            if ($update) {
                echo '<div class="z-3 position-absolute top-[50px] start-50 w-25 alert alert-success alert-dismissible fade show" role="alert">Data Updated successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            } else {
                echo '<div class="z-3 position-absolute top-[50px] start-50 w-25 alert alert-danger alert-dismissible fade show" role="alert">' . 'Error Updating data : ' . $conn->error . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
        } else {
            // Retrieve data from the form
            $title = $_POST["title"];
            $description = $_POST["description"];

            // SQL query to insert data
            $sql = "INSERT INTO `note` (`title`, `description`) VALUES ( '$title', '$description')";
            //$result = mysqli_query($conn, $sql);
            if ($conn->query($sql) === true) {
                $insert = true;
            }
            // Insert Message
            if ($insert) {
                echo '<div class="z-3 position-absolute top-[50px] start-50 w-25 alert alert-success alert-dismissible fade show" role="alert">Data inserted successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            } else {
                echo '<div class="z-3 position-absolute top-[50px] start-50 w-25 alert alert-danger alert-dismissible fade show" role="alert">' . 'Error inserting data : ' . $conn->error . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
        }
    }



    ?>


</head>

<body>
    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mNotesModal">
        Edit
    </button> -->

    <!-- Modal -->
    <div class="modal fade" id="mNotesModal" tabindex="-1" aria-labelledby="mNotesModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="mNotesModal">Update This Note!</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <input type="hidden" name="noEdit" id="noEdit">
                        <div class="mb-3">
                            <label for="titleEdit" class="form-label">Title</label>
                            <input type="text" name="titleEdit" class="form-control" id="titleEdit">
                        </div>
                        <div class="mb-3">
                            <label for="descriptionEdit" class="form-label">Description</label>
                            <textarea class="form-control" name="descriptionEdit" id="descriptionEdit" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Note</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Heder Section -->
    <header class="position-relative">
        <!-- Navigation  -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="/">mNotes</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/">Contact Us</a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>


    <!-- TODO Application -->
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <h2 class="mt-5 mb-3">Add your note!</h2>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" id="title">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Note</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Display Data -->

    <section class="container">
        <div class="row justify-content-md-center mt-5">
            <div class="col-md-8">
                <table class="table table-striped py-3" id="myTable">
                    <thead class="text-bg-dark">
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Time</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query data for display
                        $query = "SELECT * FROM note";
                        $data = mysqli_query($conn, $query);
                        // Display Data
                        if (mysqli_num_rows($data) > 0) {
                            $no = 0;
                            while ($row = mysqli_fetch_assoc($data)) {
                                $no++;
                                echo "<tr>" . "<th scope='row'>" . $no . "</th>"
                                    . "<td >" . $row["title"] . "</td>"
                                    . "<td >" . $row["description"] . "</td>"
                                    . "<td >" . $row["time"] . "</td>"
                                    . "<td> <button id=" . $row['no'] . " class='btn btn-sm btn-primary edit' >Edit</button> <button id=d" . $row['no'] . " class='btn btn-sm btn-danger delete' >Delete</button></td>" .
                                    "</tr>";
                            }
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="./main.js"></script>

</body>

</html>
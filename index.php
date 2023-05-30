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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve data from the form
        $title = $_POST["title"];
        $description = $_POST["description"];

        // SQL query to insert data
        $sql = "INSERT INTO `note` (`title`, `description`) VALUES ( '$title', '$description')";
        //$result = mysqli_query($conn, $sql);
        if ($conn->query($sql) === true) {
            $insert = true;
        } else {
            $insert = false;
        }
    }



    ?>


</head>

<body>
    <!-- Heder Section -->
    <header>
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
        <?php
        if ($insert) {
            echo '<div class="position-absolute top-[30px] start-50 w-25 alert alert-success alert-dismissible fade show" role="alert">Data inserted successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        } else {
            echo '<div class="position-absolute top-[30px] start-50 w-25 alert alert-danger alert-dismissible fade show" role="alert">' . 'Error inserting data : ' . $conn->error . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
        ?>
    </header>


    <!-- TODO Application -->
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <h2 class="mt-5 mb-3">Add your note!</h2>
                    <div class="mb-3">
                        <label for="title" class="form-label">Tile</label>
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
                                echo '<tr>
                            <th scope="row">' . $no . '</th>'
                                    . '<th >' . $row["title"] . '</th>'
                                    . '<th >' . $row["description"] . '</th>'
                                    . '<th >' . $row["time"] . '</th>'
                                    . '<th>' . "Edit" . '</th>'

                                    . '</tr>';
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

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
</body>

</html>
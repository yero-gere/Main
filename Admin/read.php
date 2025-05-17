<?php
// read.php
include('db.php');

$sql = "SELECT id, username, email FROM users";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn{
            position:relative;
            top:-100%;
            left:50%;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>User List</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["id"]. "</td>
                                <td>" . $row["username"]. "</td>
                                <td>" . $row["email"]. "</td>
                                <td>
                                    <a href='update.php?id=" . $row["id"] . "' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='delete.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm'>Delete</a>

                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No users found</td></tr>";
                }
                ?>
            <a href='create.php' class='btn btn-danger btn-sm'>Create</a>

            </tbody>

        </table>

        <button class="btn btn-warning btn-lg"><a href="./adminDashboard.html">go to back</a></button>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>

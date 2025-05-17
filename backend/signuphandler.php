<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "./config.php";  
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role=$_POST["role"];
    $errors = [];


    try {
        // Validation
        if (empty($email)) {
            $errors[] = "Email is required.";
        } 

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        if (empty($username)) {
            $errors[] = "Username is required.";
        }

        if (empty($password)) {
            $errors[] = "Password is required.";
        } elseif (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
            $errors[] = "Password must be at least 8 characters and include a letter and a number.";
        }

        // Check for existing email or username
        if (empty($errors)) {
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
            $stmt->bind_param("ss", $email, $username);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $errors[] = "Email or username already exists.";
            }
            $stmt->close();
        }

        // If valid, insert user
        if (empty($errors)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (email, username, password,role) VALUES (?, ?, ?,?)");
            $stmt->bind_param("ssss", $email, $username, $hashed_password,$role);
            if ($stmt->execute()) {
                // Redirect before echoing success message
                header("Location: ../login.html");
                exit;
            } else {
                $errors[] = "Error: " . $stmt->error;
            }
            $stmt->close();
        }

        // If there are errors, display them
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        }

    } catch (mysqli_sql_exception $e) {  // Corrected exception
        die("Signup failed, please try again! " . $e->getMessage());
    }

    // Close the connection properly
    $mysqli->close();
}
?>

<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $stage_name = $_POST['stage_name'];
    $origin = $_POST['origin'];
    $genre = $_POST['genre'];
    $active_since = $_POST['active_since'];

    $sql = "INSERT INTO artist (name, stage_name, origin, genre, active_since) VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $stage_name, $origin, $genre, $active_since);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $message = "New record created successfully.";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    
    // Redirect ke halaman utama dengan pesan status
    header("Location: read.php?message=" . urlencode($message));
    exit();
}
?>

<html>
<head>
    <title>Add New Artist</title>
    <style>
        /* CSS styles */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            width: 300px;
            margin: 0 auto;
        }
        fieldset {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }
        legend {
            font-weight: bold;
            font-size: 1.2em;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="submit"] {
            padding: 8px;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .success {
            color: #008000;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .error {
            color: #FF0000;
            font-weight: bold;
            margin-bottom: 10px;
        }
        a.back-link {
            display: inline-block;
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }
        a.back-link:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <fieldset>
            <legend>Add New Artist</legend>
            <label for="name">Name:</label>
            <input type="text" name="name" required><br>
            <label for="stage_name">Stage Name:</label>
            <input type="text" name="stage_name" required><br>
            <label for="origin">Origin:</label>
            <input type="text" name="origin" required><br>
            <label for="genre">Genre:</label>
            <input type="text" name="genre" required><br>
            <label for="active_since">Active Since:</label>
            <input type="text" name="active_since" required><br><br>
            <input type="submit" value="Submit">
        </fieldset>
    </form>
    <a href="read.php" class="back-link">Kembali ke Daftar</a>
</body>
</html>

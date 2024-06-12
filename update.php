<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id = $_POST['user_id'];
    $name = $_POST['name'];
    $stage_name = $_POST['stage_name'];
    $origin = $_POST['origin'];
    $genre = $_POST['genre'];
    $active_since = $_POST['active_since'];

    // Siapkan statement SQL untuk update
    $sql = "UPDATE artist SET name = ?, stage_name = ?, origin = ?, genre = ?, active_since = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
        exit();
    }

    $stmt->bind_param("sssssi", $name, $stage_name, $origin, $genre, $active_since, $id);

    // Eksekusi statement
    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
    
    // Redirect ke halaman utama setelah update
    header("Location: read.php");
    exit();
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $sql = "SELECT * FROM artist WHERE id=?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
        exit();
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $stage_name = $row['stage_name'];
        $origin = $row['origin'];
        $genre = $row['genre'];
        $active_since = $row['active_since'];
        $id = $row['id'];
    } else {
        echo "<div class='error'>No artist found with this ID.</div>";
        exit();
    }

    $stmt->close();
} else {
    echo "<div class='error'>No ID provided.</div>";
    exit();
}
?>

<html>
<head>
    <title>Edit Artist</title>
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
    <h2>Edit Artist</h2>
    <form action="update.php" method="post">
        <fieldset>
            <legend>Personal information:</legend>
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required><br>
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($id); ?>">
            <label for="stage_name">Stage Name:</label>
            <input type="text" name="stage_name" value="<?php echo htmlspecialchars($stage_name); ?>" required><br>
            <label for="origin">Origin:</label>
            <input type="text" name="origin" value="<?php echo htmlspecialchars($origin); ?>" required><br>
            <label for="genre">Genre:</label>
            <input type="text" name="genre" value="<?php echo htmlspecialchars($genre); ?>" required><br>
            <label for="active_since">Active Since:</label>
            <input type="text" name="active_since" value="<?php echo htmlspecialchars($active_since); ?>" required><br>
            <input type="submit" value="Update" name="update">
        </fieldset>
    </form>
    <a href="read.php" class="back-link">Kembali ke Daftar</a>
</body>
</html>

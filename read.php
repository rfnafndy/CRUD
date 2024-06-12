<?php
include "config.php";

// Pagination configuration
$results_per_page = 10;

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$start_from = ($page - 1) * $results_per_page;

if (isset($_GET['filter_name']) && !empty($_GET['filter_name'])) {
    $filter_name = $_GET['filter_name'];
    $sql = "SELECT * FROM artist WHERE name LIKE '%$filter_name%' LIMIT $start_from, $results_per_page";
} else {
    $sql = "SELECT * FROM artist LIMIT $start_from, $results_per_page";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>List of Artists</title>
    <style>
        /* CSS styling */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .table-container {
            margin: auto;
            margin-top: 50px;
            width: 75%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #6fbf73;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .action {
            display: inline-block;
            padding: 6px 12px;
            text-decoration: none;
            color: #fff;
            border-radius: 4px;
        }

        .create-button {
            display: inline-block;
            margin-bottom: 10px;
            background-color: #007bff;
        }

        .update-button {
            background-color: #FFA500;
        }

        .delete-button {
            background-color: #dc3545;
        }

        .pagination {
            text-align: center;
        }

        .pagination a {
            color: black;
            float: left;
            padding: 8px 16px;
            text-decoration: none;
            transition: background-color .3s;
            border: 1px solid #ddd;
            margin: 0 4px;
        }

        .pagination a.active {
            background-color: #007bff;
            color: white;
            border: 1px solid #007bff;
        }

        .pagination a:hover:not(.active) {
            background-color: #ddd;
        }

        .filter-container {
            float: right;
            margin-bottom: 10px;
        }

        .filter-container input[type="text"] {
            padding: 6px;
            width: 200px;
            box-sizing: border-box;
        }

        .filter-container input[type="submit"] {
            padding: 6px 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .top-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            margin-top: 75px;
            padding: 20px;
            border: 1px solid #888;
            width: 30%;
            -webkit-animation-name: slide-down;
            -webkit-animation-duration: 0.5s;
            animation-name: slide-down;
            animation-duration: 0.5s;
        }

        @-webkit-keyframes slide-down {
            from {
                top: -300px;
                opacity: 0;
            }
            to {
                top: 75px;
                opacity: 1;
            }
        }

        @keyframes slide-down {
            from {
                top: -300px;
                opacity: 0;
            }
            to {
                top: 75px;
                opacity: 1;
            }
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="table-container">
        <div class="top-controls">
            <a class="action create-button" href="#" onclick="openCreateModal()">Create</a>
            <div class="filter-container">
                <form action="" method="GET">
                    <input type="text" name="filter_name" placeholder="Filter by Name">
                    <input type="submit" value="Filter">
                </form>
            </div>
        </div>
        <!-- Tabel data -->
        <table>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Stage Name</th>
                <th>Origin</th>
                <th>Genre</th>
                <th>Active Since</th>
                <th colspan="2">Action</th>
            </tr>
            <?php
            // Mengatur nomor indeks
            $index = 1;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    // Menampilkan nomor indeks
                    echo "<td>" . $index++ . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['stage_name'] . "</td>";
                    echo "<td>" . $row['origin'] . "</td>";
                    echo "<td>" . $row['genre'] . "</td>";
                    echo "<td>" . $row['active_since'] . "</td>";
                    echo "<td><a class='action update-button' href='#' onclick='openUpdateModal(" . $row['id'] . ")'>Update</a></td>";
                    echo "<td><a class='action delete-button' href='delete.php?id=" . $row['id'] . "'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No artists found</td></tr>";
            }
            ?>
        </table>
        <!-- Pagination -->
        <div class="pagination">
            <?php
            $sql_total = "SELECT COUNT(*) AS total FROM artist";
            $result_total = $conn->query($sql_total);
            $row_total = $result_total->fetch_assoc();
            $total_pages = ceil($row_total['total'] / $results_per_page);

            // Tampilkan tombol untuk halaman sebelumnya (jika ada)
            if ($page > 1) {
                echo "<a href='?page=" . ($page - 1) . "'>Previous</a>";
            }

            // Tampilkan nomor halaman
            for ($i = 1; $i <= $total_pages; $i++) {
                // Tambahkan kelas 'active' jika ini halaman yang aktif
                $active_class = ($i == $page) ? "active" : "";
                echo "<a class='$active_class' href='?page=" . $i . "'>" . $i . "</a>";
            }

            // Tampilkan tombol untuk halaman berikutnya (jika ada)
            if ($page < $total_pages) {
                echo "<a href='?page=" . ($page + 1) . "'>Next</a>";
            }
            ?>
        </div>
    </div>

    <!-- Modal untuk menambahkan artist baru -->
    <div id="createModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeCreateModal()">&times;</span>
            <!-- Form to create new data -->
            <form id="createForm" action="create.php" method="POST">
                <label for="name">Name:</label>
                <input type="text" name="name" required><br><br>
                <label for="stage_name">Stage Name:</label>
                <input type="text" name="stage_name" required><br><br>
                <label for="origin">Origin:</label>
                <input type="text" name="origin" required><br><br>
                <label for="genre">Genre:</label>
                <input type="text" name="genre" required><br><br>
                <label for="active_since">Active Since:</label>
                <input type="text" name="active_since" required><br><br>
                <input type="submit" value="Create">
            </form>
        </div>
    </div>

    <!-- Modal untuk mengupdate artist -->
    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeUpdateModal()">&times;</span>
            <!-- Form to update data -->
            <form id="updateForm" action="update.php" method="POST">
                <input type="hidden" name="id" id="update_id">
                <label for="update_name">Name:</label>
                <input type="text" name="name" id="update_name" required><br><br>
                <label for="update_stage_name">Stage Name:</label>
                <input type="text" name="stage_name" id="update_stage_name" required><br><br>
                <label for="update_origin">Origin:</label>
                <input type="text" name="origin" id="update_origin" required><br><br>
                <label for="update_genre">Genre:</label>
                <input type="text" name="genre" id="update_genre" required><br><br>
                <label for="update_active_since">Active Since:</label>
                <input type="text" name="active_since" id="update_active_since" required><br><br>
                <input type="submit" value="Update">
            </form>
        </div>
    </div>

    <script>
        // Function to open create modal
        function openCreateModal() {
            var modal = document.getElementById("createModal");
            modal.style.display = "block";
        }

        // Function to close create modal
        function closeCreateModal() {
            var modal = document.getElementById("createModal");
            modal.style.display = "none";
        }

        // Function to open update modal
        function openUpdateModal(id) {
            var modal = document.getElementById("updateModal");

            // Fetch artist data using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "get_artist.php?id=" + id, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var artist = JSON.parse(xhr.responseText);
                    document.getElementById("update_id").value = artist.id;
                    document.getElementById("update_name").value = artist.name;
                    document.getElementById("update_stage_name").value = artist.stage_name;
                    document.getElementById("update_origin").value = artist.origin;
                    document.getElementById("update_genre").value = artist.genre;
                    document.getElementById("update_active_since").value = artist.active_since;
                    modal.style.display = "block";
                }
            };
            xhr.send();
        }

        // Function to close update modal
        function closeUpdateModal() {
            var modal = document.getElementById("updateModal");
            modal.style.display = "none";
        }

        // Close modal when user clicks outside the modal
        window.onclick = function (event) {
            var createModal = document.getElementById("createModal");
            var updateModal = document.getElementById("updateModal");
            if (event.target == createModal) {
                createModal.style.display = "none";
            }
            if (event.target == updateModal) {
                updateModal.style.display = "none";
            }
        }
    </script>
</body>

</html>

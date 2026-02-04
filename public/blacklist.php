<?php
include '../config/config.php';
include '../src/header.php';

// 1) Naya blacklist entry add karna (form se)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bname   = mysqli_real_escape_string($conn, $_POST['bname']);
    $bmobile = mysqli_real_escape_string($conn, $_POST['bmobile']);
    $breason = mysqli_real_escape_string($conn, $_POST['breason']);

    if (!empty($bmobile)) {
        $sql = "INSERT INTO blacklist (name, mobile, reason, is_active)
                VALUES ('$bname', '$bmobile', '$breason', 1)";
        mysqli_query($conn, $sql);
    }
    // Same page reload
    header("Location: blacklist.php");
    exit();
}

// 2) Block/Unblock toggle (GET se)
if (isset($_GET['toggle_id'])) {
    $id = (int) $_GET['toggle_id'];

    // current status nikalna
    $res = mysqli_query($conn, "SELECT is_active FROM blacklist WHERE id = $id");
    if ($row = mysqli_fetch_assoc($res)) {
        $new_status = $row['is_active'] ? 0 : 1;
        mysqli_query($conn, "UPDATE blacklist SET is_active = $new_status WHERE id = $id");
    }
    header("Location: blacklist.php");
    exit();
}
?>

<div class="card">
    <h2>Blacklist Management</h2>

    <h3>Add New Blacklisted Visitor</h3>
    <form method="post" action="">
        <label>Name (optional):</label><br>
        <input type="text" name="bname"><br><br>

        <label>Mobile (required):</label><br>
        <input type="text" name="bmobile" required><br><br>

        <label>Reason:</label><br>
        <input type="text" name="breason" placeholder="Reason for blocking"><br><br>

        <input class="btn btn-primary" type="submit" value="Add to Blacklist">
    </form>
</div>

<div class="card">
    <h3>Blacklisted Visitors</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Action</th>
            <th>Created At</th>
        </tr>
        <?php
        $sql = "SELECT * FROM blacklist ORDER BY created_at DESC";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['name']."</td>";
                echo "<td>".$row['mobile']."</td>";
                echo "<td>".$row['reason']."</td>";
                echo "<td>".($row['is_active'] ? 'BLOCKED' : 'UNBLOCKED')."</td>";

                $btnText = $row['is_active'] ? 'Unblock' : 'Block';
                $btnClass = $row['is_active'] ? 'btn-secondary' : 'btn-danger';

                echo "<td>
                        <a class='btn ".$btnClass."' href='blacklist.php?toggle_id=".$row['id']."' 
                           onclick=\"return confirm('Change status of this record?');\">
                           $btnText
                        </a>
                      </td>";

                echo "<td>".$row['created_at']."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No blacklist records found</td></tr>";
        }
        ?>
    </table>
</div>

</div>
</body>
</html>

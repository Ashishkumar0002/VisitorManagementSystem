<?php
include '../config/config.php';
include '../src/header.php';

$search = "";
$where = "1=1";

if (isset($_GET['search']) && $_GET['search'] != "") {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $where = "(name LIKE '%$search%' OR mobile LIKE '%$search%' OR person_to_meet LIKE '%$search%')";
}
?>

<div class="card">
    <h2>All Visitors (History)</h2>

    <form method="get" action="">
        <label>Search (Name / Mobile / Person to Meet):</label><br>
        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>">
        <input class="btn btn-primary" type="submit" value="Search">
        <a class="btn btn-secondary" href="visitors_history.php">Clear</a>
        <a class="btn" href="#" onclick="window.print();return false;">Print</a>
    </form>
    <br>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Photo</th><
            <th>ID Proof</th>
            <th>Purpose</th>
            <th>Person to Meet</th>
            <th>Department</th>
            <th>In Time</th>
            <th>Out Time</th>
            <th>Status</th>
            <th>Document</th>
            <th>QR Pass</th>

        </tr>
        <?php
        $sql = "SELECT * FROM visitors WHERE $where ORDER BY in_time DESC";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['name']."</td>";
                echo "<td>".$row['mobile']."</td>";
                // Photo column
echo "<td>";
if (!empty($row['photo_path'])) {
    echo "<a href='".$row['photo_path']."' target='_blank'>View Photo</a>";
} else {
    echo "N/A";
}
echo "</td>";

// ID image column
echo "<td>";
if (!empty($row['id_image_path'])) {
    echo "<a href='".$row['id_image_path']."' target='_blank'>View ID</a>";
} else {
    echo "N/A";
}
echo "</td>";

                echo "<td>".$row['purpose']."</td>";
                echo "<td>".$row['person_to_meet']."</td>";
                echo "<td>".$row['department']."</td>";
                echo "<td>".$row['in_time']."</td>";
                echo "<td>".$row['out_time']."</td>";
                echo "<td>".$row['status']."</td>";
// Document column
echo "<td>";
if (!empty($row['document_path'])) {
    echo "<a href='".$row['document_path']."' target='_blank'>View Doc</a>";
} else {
    echo "N/A";
}
echo "</td>";

                // QR Pass column
              echo "<td>";
if (!empty($row['qr_code_path'])) {
    echo $row['qr_code_path']; // shows VMS-3-20251209
} else {
    echo "<a class='btn btn-primary' href='generate_qr.php?id=".$row['id']."'>Generate QR</a>";
}
echo "</td>";

  

        
            }
        } else {
            echo "<tr><td colspan='10'>No visitors found</td></tr>";
        }
        ?>
    </table>
</div>

</div>
</body>
</html>

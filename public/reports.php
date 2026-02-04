<?php
include '../config/config.php';
include '../src/header.php';
include '../src/auth.php';
require_role(['admin', 'office_admin']);

// Date filter handle karna
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
$to_date   = isset($_GET['to_date']) ? $_GET['to_date'] : '';

$where = "1=1";

if (!empty($from_date) && !empty($to_date)) {
    $where = "DATE(in_time) BETWEEN '$from_date' AND '$to_date'";
} elseif (!empty($from_date)) {
    $where = "DATE(in_time) >= '$from_date'";
} elseif (!empty($to_date)) {
    $where = "DATE(in_time) <= '$to_date'";
}

// Data fetch
$sql = "SELECT * FROM visitors WHERE $where ORDER BY in_time DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="card">
    <h2>Visitor Reports</h2>

    <form method="get" action="">
        <label>From Date:</label><br>
        <input type="date" name="from_date" value="<?php echo htmlspecialchars($from_date); ?>"><br><br>

        <label>To Date:</label><br>
        <input type="date" name="to_date" value="<?php echo htmlspecialchars($to_date); ?>"><br><br>

        <input class="btn btn-primary" type="submit" value="Filter">
        <a class="btn btn-secondary" href="reports.php">Clear</a>

        <!-- Export to Excel (CSV) -->
        <a class="btn btn-primary" 
           href="export_csv.php?from_date=<?php echo urlencode($from_date); ?>&to_date=<?php echo urlencode($to_date); ?>">
           Export to Excel (CSV)
        </a>

        <!-- Print / Save as PDF -->
        <a class="btn" href="#" onclick="window.print();return false;">Print / Save as PDF</a>

        <!-- View Charts -->
        <a class="btn btn-secondary" 
           href="report_charts.php?from_date=<?php echo urlencode($from_date); ?>&to_date=<?php echo urlencode($to_date); ?>">
           View Charts
        </a>
    </form>
</div>

<div class="card">
    <h3>Visitor List (Filtered)</h3>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Purpose</th>
            <th>Person to Meet</th>
            <th>Department</th>
            <th>In Time</th>
            <th>Out Time</th>
            <th>Status</th>
        </tr>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['name']."</td>";
                echo "<td>".$row['mobile']."</td>";
                echo "<td>".$row['purpose']."</td>";
                echo "<td>".$row['person_to_meet']."</td>";
                echo "<td>".$row['department']."</td>";
                echo "<td>".$row['in_time']."</td>";
                echo "<td>".$row['out_time']."</td>";
                echo "<td>".$row['status']."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No visitors found for selected range.</td></tr>";
        }
        ?>
    </table>
</div>

</div>
</body>
</html>

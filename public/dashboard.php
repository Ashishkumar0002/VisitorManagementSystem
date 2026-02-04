<?php
include '../config/config.php';
include '../src/header.php';

// Today visitors
$today_sql = "SELECT COUNT(*) AS total_today FROM visitors WHERE DATE(in_time) = CURDATE()";
$today_res = mysqli_query($conn, $today_sql);
$today_row = mysqli_fetch_assoc($today_res);

// Current IN visitors
$in_sql = "SELECT COUNT(*) AS total_in FROM visitors WHERE status = 'IN'";
$in_res = mysqli_query($conn, $in_sql);
$in_row = mysqli_fetch_assoc($in_res);

// Total visitors
$total_sql = "SELECT COUNT(*) AS total_all FROM visitors";
$total_res = mysqli_query($conn, $total_sql);
$total_row = mysqli_fetch_assoc($total_res);
?>

<div class="card">
    <h2>Dashboard</h2>
    <p><strong>Visitors Today:</strong> <?php echo $today_row['total_today']; ?></p>
    <p><strong>Currently Inside Campus:</strong> <?php echo $in_row['total_in']; ?></p>
    <p><strong>Total Visitors (All Time):</strong> <?php echo $total_row['total_all']; ?></p>
</div>

<div class="card">
    <h3>Today’s Visitors</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Purpose</th>
            <th>Person to Meet</th>
            <th>In Time</th>
            <th>Status</th>
        </tr>
        <?php
        $sql = "SELECT * FROM visitors WHERE DATE(in_time) = CURDATE() ORDER BY in_time DESC";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['name']."</td>";
                echo "<td>".$row['mobile']."</td>";
                echo "<td>".$row['purpose']."</td>";
                echo "<td>".$row['person_to_meet']."</td>";
                echo "<td>".$row['in_time']."</td>";
                echo "<td>".$row['status']."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No visitors today</td></tr>";
        }
        ?>
    </table>
</div>

</div>
</body>
</html>

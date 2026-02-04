<?php
include '../config/config.php';
include '../src/header.php';

// Overstay limit (in hours)
$overstay_limit_hours = 1; // yaha value change karke 3, 4, etc. bhi kar sakte ho
?>

<div class="card">
    <h2>Visitors Currently Inside Campus</h2>
    <p style="font-size: 13px; margin-bottom: 10px;">
        Overstay limit: <strong><?php echo $overstay_limit_hours; ?> hours</strong>.<br>
        Rows highlighted in <span style="background:#ffe6e6; padding:2px 6px; border-radius:3px;">light red</span> 
        are visitors staying longer than this limit.
    </p>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Purpose</th>
            <th>Person to Meet</th>
            <th>In Time</th>
            <th>Duration Inside</th>
            <th>QR Pass</th>
            <th>Action</th>
        </tr>
        <?php
        $sql = "SELECT * FROM visitors WHERE status = 'IN' ORDER BY in_time DESC";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {

                // ---- Duration & Overstay Calculation ----
                $in_time_str = $row['in_time'];
                $in_time_ts  = strtotime($in_time_str);
                $now_ts      = time();

                // seconds difference
                $diff_seconds = $now_ts - $in_time_ts;
                if ($diff_seconds < 0) $diff_seconds = 0; // safety

                $hours   = floor($diff_seconds / 3600);
                $minutes = floor(($diff_seconds % 3600) / 60);

                // Duration string like "01h 25m"
                $duration_str = sprintf("%02dh %02dm", $hours, $minutes);

                // Overstay check
                $is_overstay = ($diff_seconds >= $overstay_limit_hours * 3600);

                // Row class
                $row_class = $is_overstay ? "overstay" : "";

                echo "<tr class='$row_class'>";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['name']."</td>";
                echo "<td>".$row['mobile']."</td>";
                echo "<td>".$row['purpose']."</td>";
                echo "<td>".$row['person_to_meet']."</td>";
                echo "<td>".$row['in_time']."</td>";

                // Duration + Overstay badge
                echo "<td>".$duration_str;
                if ($is_overstay) {
                    echo " <span class='badge-overstay'>Overstay</span>";
                }
                echo "</td>";

                // QR Pass column (agar QR code path hai)
                echo "<td>";
                if (!empty($row['qr_code_path'])) {
                    echo "<img src='".$row['qr_code_path']."' alt='QR Code' height='50'>";
                } else {
                    echo "N/A";
                }
                echo "</td>";

                // Checkout action
                echo "<td><a class='btn btn-danger' href='checkout.php?id=".$row['id']."' onclick=\"return confirm('Mark this visitor as checked-out?');\">Check-out</a></td>";

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No visitors currently inside</td></tr>";
        }
        ?>
    </table>
</div>

</div>
</body>
</html>

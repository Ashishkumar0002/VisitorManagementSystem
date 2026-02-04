<?php
include '../config/config.php';
include '../src/header.php';
include '../src/auth.php';
require_role(['admin', 'office_admin']);

// Date filter
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

// Query: visitors per day
$sql = "SELECT DATE(in_time) AS visit_date, COUNT(*) AS total
        FROM visitors
        WHERE $where
        GROUP BY DATE(in_time)
        ORDER BY visit_date";
$result = mysqli_query($conn, $sql);

$dates = [];
$counts = [];

while ($row = mysqli_fetch_assoc($result)) {
    $dates[] = $row['visit_date'];
    $counts[] = (int)$row['total'];
}
?>

<div class="card">
    <h2>Visitors Chart (Per Day)</h2>
    <p>
        <?php
        if (!empty($from_date) || !empty($to_date)) {
            echo "Filtered by date range: ";
            echo !empty($from_date) ? "From <strong>$from_date</strong> " : "";
            echo !empty($to_date) ? "To <strong>$to_date</strong> " : "";
        } else {
            echo "Showing all available data.";
        }
        ?>
    </p>
    <br>

    <canvas id="visitorsChart" style="max-width: 800px; max-height: 400px;"></canvas>

    <br>
    <a class="btn btn-secondary" href="reports.php?from_date=<?php echo urlencode($from_date); ?>&to_date=<?php echo urlencode($to_date); ?>">Back to Reports</a>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// PHP arrays ko JS me convert kar rahe
const labels = <?php echo json_encode($dates); ?>;
const dataValues = <?php echo json_encode($counts); ?>;

const ctx = document.getElementById('visitorsChart').getContext('2d');

const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Number of Visitors',
            data: dataValues
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                precision: 0
            }
        }
    }
});
</script>

</div>
</body>
</html>

<?php
session_start();
include '../config/config.php';
include '../src/auth.php';
require_role(['admin', 'office_admin']);

// Date filter GET se lene (agar aaye ho to)
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

// Browser ko bol rahe: ye CSV file download karo
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=visitors_report.csv');

// CSV output stream
$output = fopen('php://output', 'w');

// Header row
fputcsv($output, ['ID', 'Name', 'Mobile', 'Purpose', 'Person to Meet', 'Department', 'In Time', 'Out Time', 'Status']);

// Data rows
$sql = "SELECT * FROM visitors WHERE $where ORDER BY in_time DESC";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, [
        $row['id'],
        $row['name'],
        $row['mobile'],
        $row['purpose'],
        $row['person_to_meet'],
        $row['department'],
        $row['in_time'],
        $row['out_time'],
        $row['status']
    ]);
}

fclose($output);
exit;
?>

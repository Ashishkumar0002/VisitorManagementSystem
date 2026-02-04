<?php
include '../config/config.php';
include '../src/header.php';

if (isset($_GET['approve_id'])) {
    $id = (int) $_GET['approve_id'];

    // Fetch pre-reg data
    $res = mysqli_query($conn, "SELECT * FROM pre_registrations WHERE id = $id");
    $pre = mysqli_fetch_assoc($res);

    if ($pre) {
        // Insert into visitors as pre_registered
        $sql = "INSERT INTO visitors
            (name, mobile, email, address, purpose, person_to_meet, department, in_time, status, pre_registered)
            VALUES
            ('{$pre['name']}', '{$pre['mobile']}', '{$pre['email']}', '{$pre['address']}',
             '{$pre['purpose']}', '{$pre['person_to_meet']}', '{$pre['department']}', NOW(), 'IN', 1)";
        mysqli_query($conn, $sql);

        // Mark pre-reg as approved
        mysqli_query($conn, "UPDATE pre_registrations SET status='APPROVED' WHERE id=$id");
    }
    header("Location: pre_reg_list.php");
    exit();
}
?>

<div class="card">
    <h2>Pending Pre-Registrations</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Purpose</th>
            <th>Visit Date</th>
            <th>Action</th>
        </tr>
        <?php
        $sql = "SELECT * FROM pre_registrations WHERE status='PENDING' ORDER BY visit_date ASC";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['name']."</td>";
                echo "<td>".$row['mobile']."</td>";
                echo "<td>".$row['purpose']."</td>";
                echo "<td>".$row['visit_date']."</td>";
                echo "<td><a class='btn btn-primary' href='pre_reg_list.php?approve_id=".$row['id']."'>Approve & Check-in</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No pending pre-registrations</td></tr>";
        }
        ?>
    </table>
</div>

</div>
</body>
</html>

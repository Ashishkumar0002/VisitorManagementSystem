<?php
include '../config/config.php';
include '../src/header.php';
include '../src/auth.php';
require_role(['admin', 'gate_admin']);
?>

<div class="card">
    <h2>Add New Visitor</h2>
  <form action="save_visitor.php" method="post" enctype="multipart/form-data">

        <label>Visitor Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Mobile:</label><br>
        <input type="text" name="mobile"><br><br>

        <label>Email:</label><br>
        <input type="email" name="email"><br><br>

        <label>Address:</label><br>
        <input type="text" name="address"><br><br>

        <label>Visitor Photo:</label><br>
<input type="file" name="photo"><br><br>


        <label>ID Proof Type:</label><br>
        <input type="text" name="id_proof_type" placeholder="Aadhar, DL, etc."><br><br>

        <label>ID Proof Image:</label><br>
<input type="file" name="id_image"><br><br>

        <label>ID Proof Number:</label><br>
        <input type="text" name="id_proof_number"><br><br>

        <label>Visitor Document (Permission Letter / PDF / etc.):</label><br>
<input type="file" name="visitor_doc"><br><br>


        <label>Purpose of Visit:</label><br>
        <input type="text" name="purpose" required><br><br>

        <label>Person to Meet:</label><br>
        <input type="text" name="person_to_meet" required><br><br>

        <label>Department:</label><br>
        <input type="text" name="department" placeholder="CSE, ECE, Admin, etc."><br><br>

        <input class="btn btn-primary" type="submit" value="Save Visitor">
        <a class="btn btn-secondary" href="dashboard.php">Cancel</a>
    </form>
</div>

</div>
</body>
</html>

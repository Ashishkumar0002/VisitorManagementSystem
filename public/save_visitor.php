<?php
include '../config/config.php';
session_start();

/*
 * Helper function: SMS notification (concept using API)
 * NOTE: Isme demo URL use kiya hai. Real SMS ke liye
 * SMS provider ka actual API URL + API KEY lagana padega.
 */
function send_sms_notification($mobile, $name, $purpose, $person_to_meet) {
    if (empty($mobile)) {
        return;
    }

    // SMS message text
    $message = "Dear $name, your visit for '$purpose' to meet '$person_to_meet' is registered.";
    $encoded_message = urlencode($message);

    // Demo API URL (replace with real provider URL)
    $api_url = "https://sms-provider.com/api/send?"
             . "to=" . $mobile
             . "&msg=" . $encoded_message
             . "&api_key=YOUR_API_KEY";

    // HTTP request to SMS API (demo only)
    @file_get_contents($api_url);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Form se text data lena
    $name           = mysqli_real_escape_string($conn, $_POST['name']);
    $mobile         = mysqli_real_escape_string($conn, $_POST['mobile']);
    $email          = mysqli_real_escape_string($conn, $_POST['email']);
    $address        = mysqli_real_escape_string($conn, $_POST['address']);
    $id_proof_type  = mysqli_real_escape_string($conn, $_POST['id_proof_type']);
    $id_proof_number= mysqli_real_escape_string($conn, $_POST['id_proof_number']);
    $purpose        = mysqli_real_escape_string($conn, $_POST['purpose']);
    $person_to_meet = mysqli_real_escape_string($conn, $_POST['person_to_meet']);
    $department     = mysqli_real_escape_string($conn, $_POST['department']);

    // 1.5 Blacklist check (mobile number se)
    if (!empty($mobile)) {
        $blk_sql = "SELECT * FROM blacklist WHERE mobile = '$mobile' AND is_active = 1";
        $blk_res = mysqli_query($conn, $blk_sql);

        if (mysqli_num_rows($blk_res) > 0) {
            // Agar blacklisted hai, to entry roko
            echo "<div style='padding:20px; font-family:Arial;'>
                    <h2 style='color:red;'>Entry Blocked</h2>
                    <p>This visitor is <strong>blacklisted</strong>. New entry is not allowed.</p>
                    <p>Mobile: <strong>$mobile</strong></p>
                    <a href='add_visitor.php' style='display:inline-block; margin-top:10px; padding:8px 14px; background:#333; color:#fff; text-decoration:none; border-radius:4px;'>
                        Go Back
                    </a>
                  </div>";
            exit();
        }
    }

    // 2. Photo, ID image & document ke path variables
    $photo_path     = null;
    $id_image_path  = null;
    $document_path  = null;

    // 3. Upload folders ensure karna
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }
    if (!is_dir('uploads/photos')) {
        mkdir('uploads/photos', 0777, true);
    }
    if (!is_dir('uploads/id')) {
        mkdir('uploads/id', 0777, true);
    }
    if (!is_dir('uploads/docs')) {
        mkdir('uploads/docs', 0777, true);
    }

    // 4. Visitor photo upload
    if (!empty($_FILES['photo']['name'])) {
        $photo_name = time() . "_" . basename($_FILES['photo']['name']);
        $target_photo = "uploads/photos/" . $photo_name;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_photo)) {
            $photo_path = $target_photo;
        }
    }

    // 5. ID proof image upload
    if (!empty($_FILES['id_image']['name'])) {
        $id_name = time() . "_" . basename($_FILES['id_image']['name']);
        $target_id = "uploads/id/" . $id_name;

        if (move_uploaded_file($_FILES['id_image']['tmp_name'], $target_id)) {
            $id_image_path = $target_id;
        }
    }

    // 6. Visitor document upload (PDF / image / letter)
    if (!empty($_FILES['visitor_doc']['name'])) {
        $doc_name = time() . "_" . basename($_FILES['visitor_doc']['name']);
        $target_doc = "uploads/docs/" . $doc_name;

        if (move_uploaded_file($_FILES['visitor_doc']['tmp_name'], $target_doc)) {
            $document_path = $target_doc;
        }
    }

    // 7. Visitor ko database me insert karna
    // Make sure visitors table me ye columns hon:
    // name, mobile, email, address, id_proof_type, id_proof_number,
    // purpose, person_to_meet, department, in_time, status,
    // photo_path, id_image_path, document_path
    $sql = "INSERT INTO visitors 
        (name, mobile, email, address, id_proof_type, id_proof_number,
         purpose, person_to_meet, department, in_time, status,
         photo_path, id_image_path, document_path)
        VALUES 
        ('$name', '$mobile', '$email', '$address', '$id_proof_type', '$id_proof_number',
         '$purpose', '$person_to_meet', '$department', NOW(), 'IN',
         '$photo_path', '$id_image_path', '$document_path')";

    if (mysqli_query($conn, $sql)) {

        // 8. EMAIL NOTIFICATION (agar email diya ho)
        if (!empty($email)) {
            $to = $email;
            $subject = "Your Visit is Registered - Visitor Management System";
            $message = "Dear $name,\n\n"
                     . "Your visit to our college/university has been registered successfully.\n\n"
                     . "Details:\n"
                     . "Name: $name\n"
                     . "Mobile: $mobile\n"
                     . "Purpose: $purpose\n"
                     . "Person to Meet: $person_to_meet\n"
                     . "Department: $department\n\n"
                     . "Thank you.\n"
                     . "Visitor Management System";
            $headers = "From: vms@university.com";

            // Local XAMPP par mail() actual email na bhi bheje,
            // lekin logic complete hai (viva ke liye important).
            @mail($to, $subject, $message, $headers);
        }

        // 9. SMS NOTIFICATION (conceptual, API required)
        send_sms_notification($mobile, $name, $purpose, $person_to_meet);

        // 10. Work complete – dashboard par wapas
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

} else {
    echo "Invalid Request";
}
?>

<?php
session_start();
include "koneksi.php";

// Check if user is logged in
if (!isset($_SESSION['UserID'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senderID = $_SESSION['UserID'];
    $fotoID = $_POST['FotoID'];
    $username = $_POST['username'];

    // Get recipient's UserID
    $recipientQuery = mysqli_query($con, "SELECT UserID FROM user WHERE Username = '$username'");
    
    if (mysqli_num_rows($recipientQuery) === 0) {
        echo json_encode(['success' => false, 'message' => 'Recipient not found']);
        exit;
    }

    $recipient = mysqli_fetch_assoc($recipientQuery);
    $recipientID = $recipient['UserID'];

    // Insert into sharing table with removed message field
    $query = mysqli_query($con, "
        INSERT INTO shared_photos (SenderID, RecipientID, FotoID, ShareDate)
        VALUES ('$senderID', '$recipientID', '$fotoID', NOW())
    ");

    if ($query) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?> 
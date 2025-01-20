<?php
session_start();
include "koneksi.php"; // File koneksi database

// Pastikan user sudah login
if (!isset($_SESSION['UserID'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fotoID'])) {
    $userID = $_SESSION['UserID'];
    $fotoID = $_POST['fotoID'];
    
    // Check if user already liked the photo
    $checkQuery = "SELECT LikeID FROM likefoto WHERE UserID = ? AND FotoID = ?";
    $stmt = $con->prepare($checkQuery);
    $stmt->bind_param("ii", $userID, $fotoID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // User already liked, so unlike
        $deleteQuery = "DELETE FROM likefoto WHERE UserID = ? AND FotoID = ?";
        $stmt = $con->prepare($deleteQuery);
        $stmt->bind_param("ii", $userID, $fotoID);
        $stmt->execute();
        $isLiked = false;
    } else {
        // User hasn't liked, so add like
        $insertQuery = "INSERT INTO likefoto (UserID, FotoID, TanggalLike) VALUES (?, ?, NOW())";
        $stmt = $con->prepare($insertQuery);
        $stmt->bind_param("ii", $userID, $fotoID);
        $stmt->execute();
        $isLiked = true;
    }
    
    // Get updated like count
    $countQuery = "SELECT COUNT(*) as likeCount FROM likefoto WHERE FotoID = ?";
    $stmt = $con->prepare($countQuery);
    $stmt->bind_param("i", $fotoID);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    
    echo json_encode([
        'success' => true,
        'likeCount' => $data['likeCount'],
        'isLiked' => $isLiked
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>

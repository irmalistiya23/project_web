<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['UserID'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_SESSION['UserID'];
    $fotoID = $_POST['fotoID'];
    $comment = $_POST['comment'];
    $currentDate = date('Y-m-d H:i:s');

    // Insert komentar
    $query = "INSERT INTO komentarfoto (FotoID, UserID, IsiKomentar, TanggalKomentar) 
              VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("iiss", $fotoID, $userID, $comment, $currentDate);

    if ($stmt->execute()) {
        // Ambil data user untuk response
        $userQuery = "SELECT Username, Profile FROM user WHERE UserID = ?";
        $userStmt = $con->prepare($userQuery);
        $userStmt->bind_param("i", $userID);
        $userStmt->execute();
        $userData = $userStmt->get_result()->fetch_assoc();

        echo json_encode([
            'success' => true,
            'comment' => htmlspecialchars($comment),
            'date' => $currentDate,
            'username' => htmlspecialchars($userData['Username']),
            'profile' => htmlspecialchars($userData['Profile'] ?? 'default.jpg')
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error adding comment']);
    }
}
?>

<!-- Form Like -->
<?php if (isset($_SESSION['user_id'])): ?>
<form action="like.php" method="POST">
    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
    <button type="submit">Like</button>
</form>
<?php else: ?>
<p>Harap login untuk menyukai.</p>
<?php endif; ?>

<!-- Form Comment -->
<?php if (isset($_SESSION['user_id'])): ?>
<form action="comment.php" method="POST">
    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
    <textarea name="comment" placeholder="Tulis komentar Anda..."></textarea>
    <button type="submit">Kirim Komentar</button>
</form>
<?php else: ?>
<p>Harap login untuk memberikan komentar.</p>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Settings</h2>
    <form method="POST" enctype="multipart/form-data" class="mb-4">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="<?= htmlspecialchars($user['Username']); ?>">
        </div>
        <div class="mb-3">
            <label for="profile" class="form-label">Profile Picture</label><br>
            <img src="uploads/<?= htmlspecialchars($user['Profile']); ?>" alt="Profile" width="100" class="rounded mb-3">
            <input type="file" name="profile" id="profile" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>

    <h3>Photos Uploaded by <?= htmlspecialchars($user['Username']); ?></h3>
    <div class="row">
        <?php while ($judulfoto = $resultPhotos->fetch_assoc()) { ?>
            <div class="col-md-3 mb-3">
                <div class="card">
                    <img src="uploads/<?= htmlspecialchars($judulfoto['LokasiFoto']); ?>" class="card-img-top" alt="<?= htmlspecialchars($judulfoto['JudulFoto']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($judulfoto['JudulFoto']); ?></h5>
                        <p class="card-text"><?= htmlspecialchars($deskripsifoto['DeskripsiFoto']); ?></p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
</body>
</html>

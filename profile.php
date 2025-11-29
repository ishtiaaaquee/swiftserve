<?php
require_once 'includes/functions.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$user = new User();
$user->loadById($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $phone = sanitize($_POST['phone']);
    $address = sanitize($_POST['address']);
    
    if ($user->updateProfile($name, $phone, $address)) {
        $success = 'Profile updated successfully!';
    } else {
        $error = 'Failed to update profile';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Swift Serve</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">
                <i class="fas fa-utensils"></i>
                <a href="index.php">Swift Serve</a>
            </div>
            <div class="nav-actions">
                <a href="index.php" class="btn btn-outline">Back to Home</a>
            </div>
        </div>
    </nav>

    <section style="padding: 3rem 0; min-height: 80vh;">
        <div class="container" style="max-width: 600px;">
            <h1 class="page-title"><i class="fas fa-user-circle"></i> My Profile</h1>
            
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div style="background: var(--white); padding: 2rem; border-radius: 15px; box-shadow: var(--shadow);">
                <form method="POST" class="auth-form">
                    <div class="form-group">
                        <label><i class="fas fa-user"></i> Full Name</label>
                        <input type="text" name="name" value="<?php echo $user->getName(); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" value="<?php echo $user->getEmail(); ?>" disabled>
                        <small style="color: #636e72;">Email cannot be changed</small>
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-phone"></i> Phone</label>
                        <input type="tel" name="phone" value="<?php echo $user->getPhone(); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-map-marker-alt"></i> Delivery Address</label>
                        <textarea name="address" rows="3" required><?php echo $user->getAddress(); ?></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save"></i> Update Profile
                    </button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>

<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND role = 'mentor'");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header('Location: mtdashboard.php');
        exit();
    } else {
        $error = "Invalid username or password";
    }
}

$pageTitle = "Mentor Login | CodeMaster LMS";
include 'header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-lg overflow-hidden">
                <div class="row g-0">
                    <div class="col-md-5 d-none d-md-block bg-gradient-primary text-white p-5">
                        <div class="d-flex flex-column h-100 justify-content-center">
                            <h3 class="fw-bold mb-4">Welcome Back, Mentor!</h3>
                            <p class="mb-0">Share your knowledge and guide the next generation of developers.</p>
                            <div class="mt-auto">
                                <img src="assets/images/login-illustration.svg" alt="Login Illustration" class="img-fluid mt-4">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card-body p-5">
                            <div class="text-center mb-5">
                                <h2 class="fw-bold text-primary">
                                    <i class="fas fa-chalkboard-teacher me-2"></i> Mentor Login
                                </h2>
                                <p class="text-muted">Enter your credentials to access your dashboard</p>
                            </div>
                            
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger border-0 shadow-sm mb-4">
                                    <i class="fas fa-exclamation-circle me-2"></i> <?php echo $error; ?>
                                </div>
                            <?php endif; ?>
                            
                            <form method="POST" class="needs-validation" novalidate>
                                <div class="mb-4">
                                    <label for="username" class="form-label fw-bold">Username</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control py-3" id="username" name="username" placeholder="Enter your username" required>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-bold">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control py-3" id="password" name="password" placeholder="Enter your password" required>
                                    </div>
                                </div>
                                <div class="d-grid mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg py-3 rounded-pill shadow-sm">
                                        <i class="fas fa-sign-in-alt me-2"></i> Login
                                    </button>
                                </div>
                            </form>
                            
                            <div class="text-center pt-3">
                                <p class="text-muted mb-0">New mentor? 
                                    <a href="mtregister.php" class="text-primary fw-bold">Create an account</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
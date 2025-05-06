<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $password = password_hash(sanitizeInput($_POST['password']), PASSWORD_BCRYPT);
    $qualification = sanitizeInput($_POST['qualification']);
    $bio = sanitizeInput($_POST['bio']);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, email, role, qualification, bio) 
                             VALUES (?, ?, ?, 'mentor', ?, ?)");
        $stmt->execute([$username, $password, $email, $qualification, $bio]);
        
        $_SESSION['success'] = "Registration successful! Please login.";
        header('Location: mtlogin.php');
        exit();
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $error = "Username or email already exists";
        } else {
            $error = "An error occurred. Please try again.";
        }
    }
}

$pageTitle = "Mentor Registration | CodeMaster LMS";
include 'header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg overflow-hidden">
                <div class="row g-0">
                    <div class="col-md-5 d-none d-md-block bg-gradient-primary text-white p-5">
                        <div class="d-flex flex-column h-100 justify-content-center">
                            <h3 class="fw-bold mb-4">Become a Mentor</h3>
                            <p class="mb-0">Share your expertise and help shape the future of aspiring developers.</p>
                            <div class="mt-auto">
                                <img src="assets/images/register-illustration.svg" alt="Register Illustration" class="img-fluid mt-4">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card-body p-5">
                            <div class="text-center mb-5">
                                <h2 class="fw-bold text-primary">
                                    <i class="fas fa-user-plus me-2"></i> Mentor Registration
                                </h2>
                                <p class="text-muted">Create your mentor account in minutes</p>
                            </div>
                            
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger border-0 shadow-sm mb-4">
                                    <i class="fas fa-exclamation-circle me-2"></i> <?php echo $error; ?>
                                </div>
                            <?php endif; ?>
                            
                            <form method="POST" class="needs-validation" novalidate>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label for="username" class="form-label fw-bold">Username</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                                            <input type="text" class="form-control py-3" id="username" name="username" placeholder="Choose a username" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-bold">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                                            <input type="email" class="form-control py-3" id="email" name="email" placeholder="Your email address" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label for="password" class="form-label fw-bold">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                                            <input type="password" class="form-control py-3" id="password" name="password" placeholder="Create password" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="qualification" class="form-label fw-bold">Qualification</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fas fa-graduation-cap"></i></span>
                                            <input type="text" class="form-control py-3" id="qualification" name="qualification" placeholder="Your qualifications" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="bio" class="form-label fw-bold">About You</label>
                                    <textarea class="form-control py-3" id="bio" name="bio" rows="3" placeholder="Tell us about your experience and expertise" required></textarea>
                                </div>
                                
                                <div class="d-grid mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg py-3 rounded-pill shadow-sm">
                                        <i class="fas fa-user-plus me-2"></i> Register Now
                                    </button>
                                </div>
                            </form>
                            
                            <div class="text-center pt-3">
                                <p class="text-muted mb-0">Already have an account? 
                                    <a href="mtlogin.php" class="text-primary fw-bold">Login here</a>
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
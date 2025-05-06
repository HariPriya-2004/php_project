<?php 
$pageTitle = "CodeMaster LMS - Learn & Teach Programming";
include 'header.php'; 
?>

<!-- Hero Section -->
<section class="hero-section bg-gradient-primary text-white py-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <h1 class="display-4 fw-bold mb-4">Master Coding with Industry Experts</h1>
                <p class="lead mb-5">Join our interactive learning platform where students and mentors collaborate to build real-world skills.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="stlogin.php" class="btn btn-light btn-lg px-4 py-3 rounded-pill shadow-sm">
                        <i class="fas fa-user-graduate me-2"></i> Student Login
                    </a>
                    <a href="mtlogin.php" class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill shadow-sm">
                        <i class="fas fa-chalkboard-teacher me-2"></i> Mentor Login
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <!-- <img src="assets/images/coding-illustration.svg" alt="Coding Illustration" class="img-fluid rounded-4 shadow"> -->
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Why Choose CodeMaster?</h2>
            <p class="lead text-muted">Experience the best in online coding education</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-3">
                    <div class="card-body text-center p-4">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary mb-4">
                            <i class="fas fa-laptop-code fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Hands-on Learning</h5>
                        <p class="text-muted">Practice with real-world projects and coding exercises.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-3">
                    <div class="card-body text-center p-4">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary mb-4">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Expert Mentors</h5>
                        <p class="text-muted">Learn from professionals with industry experience.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-3">
                    <div class="card-body text-center p-4">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary mb-4">
                            <i class="fas fa-certificate fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Certification</h5>
                        <p class="text-muted">Earn certificates upon course completion.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 bg-primary text-white">
    <div class="container py-5 text-center">
        <h2 class="fw-bold mb-4">Ready to Start Your Journey?</h2>
        <div class="d-flex justify-content-center gap-3">
            <a href="stregister.php" class="btn btn-light btn-lg px-4 py-3 rounded-pill">
                <i class="fas fa-user-graduate me-2"></i> Join as Student
            </a>
            <a href="mtregister.php" class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill">
                <i class="fas fa-chalkboard-teacher me-2"></i> Become Mentor
            </a>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
<?php
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header('Location: stlogin.php');
    exit();
}

// Handle course enrollment
if (isset($_POST['enroll'])) {
    $course_id = sanitizeInput($_POST['course_id']);
    
    // Check if already enrolled
    $stmt = $pdo->prepare("SELECT * FROM enrollments WHERE student_id = ? AND course_id = ?");
    $stmt->execute([$_SESSION['user_id'], $course_id]);
    
    if ($stmt->rowCount() == 0) {
        $stmt = $pdo->prepare("INSERT INTO enrollments (student_id, course_id) VALUES (?, ?)");
        $stmt->execute([$_SESSION['user_id'], $course_id]);
        $_SESSION['enroll_success'] = true;
        header("Location: stcourses.php");
        exit();
    }
}

// Get all courses
$stmt = $pdo->query("SELECT * FROM courses");
$courses = $stmt->fetchAll();

// Get enrolled courses for current student
$stmt = $pdo->prepare("SELECT course_id FROM enrollments WHERE student_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$enrolled_courses = $stmt->fetchAll(PDO::FETCH_COLUMN);

$pageTitle = "Available Courses | CodeMaster LMS";
include 'header.php';
?>

<div class="container py-5">
    <div class="row mb-5">
        <div class="col">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold"><i class="fas fa-book-open me-2"></i>Available Courses</h2>
                <a href="stdashboard.php" class="btn btn-primary rounded-pill">
                    <i class="fas fa-tachometer-alt me-2"></i> My Dashboard
                </a>
            </div>
            
            <?php if (isset($_SESSION['enroll_success'])): ?>
                <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle fa-2x me-3 text-success"></i>
                        <div>
                            <h5 class="alert-heading fw-bold mb-1">Enrollment Successful!</h5>
                            <p class="mb-0">You have been successfully enrolled in the course.</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['enroll_success']); ?>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="row g-4">
        <?php foreach ($courses as $course): ?>
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm overflow-hidden">
                    <div class="card-img-top overflow-hidden" style="height: 200px;">
                        <img src="assets/images/<?php echo htmlspecialchars($course['image_path']); ?>" 
                             class="img-fluid w-100 h-100 object-fit-cover" 
                             alt="<?php echo htmlspecialchars($course['title']); ?>">
                        <?php if (in_array($course['id'], $enrolled_courses)): ?>
                            <span class="badge bg-success position-absolute top-0 end-0 m-3">
                                <i class="fas fa-check me-1"></i> Enrolled
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold"><?php echo htmlspecialchars($course['title']); ?></h5>
                        <p class="card-text text-muted"><?php echo htmlspecialchars($course['description']); ?></p>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <?php if (in_array($course['id'], $enrolled_courses)): ?>
                            <button class="btn btn-success w-100 rounded-pill" disabled>
                                <i class="fas fa-check-circle me-2"></i> Already Enrolled
                            </button>
                        <?php else: ?>
                            <form method="POST">
                                <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                <button type="submit" name="enroll" class="btn btn-primary w-100 rounded-pill">
                                    <i class="fas fa-plus-circle me-2"></i> Enroll Now
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
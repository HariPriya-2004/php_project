<?php
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header('Location: stlogin.php');
    exit();
}

$stmt = $pdo->prepare("SELECT c.* FROM courses c 
                      JOIN enrollments e ON c.id = e.course_id 
                      WHERE e.student_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$enrolled_courses = $stmt->fetchAll();

$pageTitle = "Student Dashboard | CodeMaster LMS";
include 'header.php';
?>

<div class="container py-5">
    <div class="row mb-5">
        <div class="col">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold"><i class="fas fa-tachometer-alt me-2"></i>Student Dashboard</h2>
                    <p class="text-muted mb-0">Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
                </div>
                <a href="stcourses.php" class="btn btn-primary rounded-pill">
                    <i class="fas fa-book-open me-2"></i> Browse Courses
                </a>
            </div>
            
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0"><i class="fas fa-graduation-cap me-2"></i> My Courses</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($enrolled_courses)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-book-open fa-4x text-muted mb-4"></i>
                            <h5 class="fw-bold mb-3">No Courses Enrolled</h5>
                            <p class="text-muted mb-4">You haven't enrolled in any courses yet.</p>
                            <a href="stcourses.php" class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-search me-2"></i> Browse Courses
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="row g-4">
                            <?php foreach ($enrolled_courses as $course): ?>
                                <div class="col-lg-4 col-md-6">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-img-top overflow-hidden" style="height: 180px;">
                                            <img src="assets/images/<?php echo htmlspecialchars($course['image_path']); ?>" 
                                                 class="img-fluid w-100 h-100 object-fit-cover" 
                                                 alt="<?php echo htmlspecialchars($course['title']); ?>">
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($course['title']); ?></h5>
                                            <p class="card-text text-muted"><?php echo substr(htmlspecialchars($course['description']), 0, 100) . '...'; ?></p>
                                        </div>
                                        <div class="card-footer bg-white border-0">
                                            <a href="#" class="btn btn-outline-primary w-100 rounded-pill mb-2">
                                                <i class="fas fa-play-circle me-2"></i> Continue Learning
                                            </a>
                                            <a href="stcourses.php" class="btn btn-outline-secondary w-100 rounded-pill">
                                                <i class="fas fa-arrow-left me-2"></i> Back to Courses
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
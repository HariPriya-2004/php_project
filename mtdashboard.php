<?php
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'mentor') {
    header('Location: mtlogin.php');
    exit();
}

$stmt = $pdo->prepare("SELECT c.* FROM courses c 
                      JOIN mentor_courses mc ON c.id = mc.course_id 
                      WHERE mc.mentor_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$mentor_courses = $stmt->fetchAll();

$pageTitle = "Mentor Dashboard | CodeMaster LMS";
include 'header.php';
?>

<div class="container py-5">
    <div class="row mb-5">
        <div class="col">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold"><i class="fas fa-tachometer-alt me-2"></i>Mentor Dashboard</h2>
                    <p class="text-muted mb-0">Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
                </div>
                <a href="mtcourses.php" class="btn btn-primary rounded-pill">
                    <i class="fas fa-book-open me-2"></i> Browse Courses
                </a>
            </div>
            
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0"><i class="fas fa-chalkboard-teacher me-2"></i> My Teaching Courses</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($mentor_courses)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-book-open fa-4x text-muted mb-4"></i>
                            <h5 class="fw-bold mb-3">No Courses Assigned</h5>
                            <p class="text-muted mb-4">You haven't selected any courses to teach yet.</p>
                            <a href="mtcourses.php" class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-search me-2"></i> Browse Courses
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="row g-4">
                            <?php foreach ($mentor_courses as $course): ?>
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
                                            <a href="mtupload_video.php?course_id=<?php echo $course['id']; ?>" class="btn btn-outline-primary w-100 rounded-pill">
                                                <i class="fas fa-cogs me-2"></i> Manage Course
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
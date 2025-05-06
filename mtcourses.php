<?php
include 'config.php';

// Redirect if not logged in as mentor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'mentor') {
    header('Location: mtlogin.php');
    exit();
}

// Handle course selection
if (isset($_POST['select_course'])) {
    $course_id = sanitizeInput($_POST['course_id']);
    
    // Check if already selected
    $stmt = $pdo->prepare("SELECT * FROM mentor_courses WHERE mentor_id = ? AND course_id = ?");
    $stmt->execute([$_SESSION['user_id'], $course_id]);
    
    if ($stmt->rowCount() == 0) {
        $stmt = $pdo->prepare("INSERT INTO mentor_courses (mentor_id, course_id) VALUES (?, ?)");
        $stmt->execute([$_SESSION['user_id'], $course_id]);
        
        // Set session variable to show success message on dashboard
        $_SESSION['new_user_flow'] = true;
        $_SESSION['selected_course_id'] = $course_id;
        
        header("Location: mtdashboard.php");
        exit();
    }
}

// Get all courses
$stmt = $pdo->query("SELECT * FROM courses");
$courses = $stmt->fetchAll();

// Get mentor's selected courses
$stmt = $pdo->prepare("SELECT course_id FROM mentor_courses WHERE mentor_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$selected_courses = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Check if this is a new user (no courses selected yet)
$is_new_user = empty($selected_courses);

$pageTitle = "My Teaching Courses | CodeMaster LMS";
include 'header.php';
?>

<div class="container py-5">
    <div class="row mb-5">
        <div class="col">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">
                    <i class="fas fa-book-open me-2"></i><?php echo $is_new_user ? 'Select Courses to Teach' : 'Available Courses to Teach'; ?>
                </h2>
                <?php if (!$is_new_user): ?>
                    <a href="mtdashboard.php" class="btn btn-primary rounded-pill">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                <?php endif; ?>
            </div>
            
            <?php if ($is_new_user): ?>
                <div class="alert alert-info border-0 shadow-sm">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle fa-2x me-3"></i>
                        <div>
                            <h5 class="alert-heading fw-bold mb-1">Getting Started</h5>
                            <p class="mb-0">Please select at least one course to start teaching.</p>
                        </div>
                    </div>
                </div>
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
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold"><?php echo htmlspecialchars($course['title']); ?></h5>
                        <p class="card-text text-muted"><?php echo htmlspecialchars($course['description']); ?></p>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <?php if (in_array($course['id'], $selected_courses)): ?>
                            <a href="mtdashboard.php" class="btn btn-success w-100 rounded-pill">
                                <i class="fas fa-chalkboard-teacher me-2"></i> Teach Course
                            </a>
                        <?php else: ?>
                            <form method="POST">
                                <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                <button type="submit" name="select_course" class="btn btn-outline-primary w-100 rounded-pill">
                                    <i class="fas fa-plus-circle me-2"></i> Select Course
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
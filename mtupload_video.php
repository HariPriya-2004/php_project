<?php
include 'config.php';

// Redirect if not logged in as mentor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'mentor') {
    header('Location: mtlogin.php');
    exit();
}

$course_id = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;

// Verify mentor is assigned to this course
$stmt = $pdo->prepare("SELECT mc.*, c.title FROM mentor_courses mc 
                      JOIN courses c ON mc.course_id = c.id 
                      WHERE mc.mentor_id = ? AND mc.course_id = ?");
$stmt->execute([$_SESSION['user_id'], $course_id]);
$mentor_course = $stmt->fetch();

if (!$mentor_course) {
    // If mentor hasn't selected this course yet, assign it first
    if ($course_id > 0) {
        $stmt = $pdo->prepare("INSERT INTO mentor_courses (mentor_id, course_id) VALUES (?, ?)");
        $stmt->execute([$_SESSION['user_id'], $course_id]);
        header("Location: mtupload_video.php?course_id=$course_id");
        exit();
    } else {
        header('Location: mtdashboard.php');
        exit();
    }
}

// Handle video upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['video'])) {
    $upload_dir = 'assets/videos/';
    
    // Create directory if it doesn't exist
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    // Generate unique filename
    $file_ext = strtolower(pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION));
    $file_name = 'mentor_' . $_SESSION['user_id'] . '_course_' . $course_id . '_' . time() . '.' . $file_ext;
    $file_path = $upload_dir . $file_name;
    
    // Validate file type and size
    $allowed_types = ['mp4', 'webm', 'ogg', 'mov', 'avi'];
    $max_size = 100 * 1024 * 1024; // 100MB
    
    if (in_array($file_ext, $allowed_types)) {
        if ($_FILES['video']['size'] <= $max_size) {
            if (move_uploaded_file($_FILES['video']['tmp_name'], $file_path)) {
                // Update database with new video
                $stmt = $pdo->prepare("UPDATE mentor_courses SET video_path = ? WHERE id = ?");
                $stmt->execute([$file_name, $mentor_course['id']]);
                
                // Set success message for SweetAlert
                $_SESSION['upload_status'] = [
                    'type' => 'success',
                    'message' => 'Video uploaded successfully!'
                ];
                header("Location: mtupload_video.php?course_id=$course_id");
                exit();
            } else {
                $error = "Error moving uploaded file.";
            }
        } else {
            $error = "File size exceeds 100MB limit.";
        }
    } else {
        $error = "Only MP4, WebM, OGG, MOV, and AVI files are allowed.";
    }
}

$pageTitle = "Upload Video | CodeMaster LMS";
include 'header.php';
?>

<div class="container py-5">
    <div class="row mb-5">
        <div class="col">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold"><i class="fas fa-video me-2"></i>Upload Lecture Video</h2>
                    <p class="text-muted mb-0">Course: <?php echo htmlspecialchars($mentor_course['title']); ?></p>
                </div>
                <a href="mtcourses.php" class="btn btn-outline-primary rounded-pill">
                    <i class="fas fa-arrow-left me-2"></i> Back to Courses
                </a>
            </div>
        </div>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0"><i class="fas fa-cloud-upload-alt me-2"></i> Upload Video</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($mentor_course['video_path'])): ?>
                        <div class="mb-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0"><i class="fas fa-play-circle me-2"></i> Current Video</h5>
                                <span class="badge bg-primary rounded-pill">
                                    <i class="fas fa-file-video me-1"></i>
                                    <?php echo pathinfo($mentor_course['video_path'], PATHINFO_EXTENSION); ?>
                                </span>
                            </div>
                            <div class="ratio ratio-16x9 mb-3 bg-dark rounded-3 overflow-hidden">
                                <video controls class="w-100">
                                    <source src="assets/videos/<?php echo htmlspecialchars($mentor_course['video_path']); ?>" 
                                            type="video/<?php echo pathinfo($mentor_course['video_path'], PATHINFO_EXTENSION); ?>">
                                    Your browser doesn't support HTML5 video.
                                </video>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    <?php echo htmlspecialchars($mentor_course['video_path']); ?>
                                </small>
                                <a href="#" class="btn btn-sm btn-outline-danger rounded-pill">
                                    <i class="fas fa-trash-alt me-1"></i> Delete
                                </a>
                            </div>
                        </div>
                        <hr class="my-4">
                    <?php endif; ?>
                    
                    <form id="videoUploadForm" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <div class="mb-4">
                            <label for="video" class="form-label fw-bold">
                                <i class="fas fa-file-video me-2"></i> Select Video File
                            </label>
                            <div class="file-upload-wrapper">
                                <input type="file" class="form-control py-3" id="video" name="video" accept="video/*" required>
                            </div>
                            <div class="form-text text-muted mt-2">
                                <i class="fas fa-info-circle me-2"></i>
                                Supported formats: .mp4, .webm, .ogg, .mov, .avi (Max 100MB)
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg py-3 rounded-pill shadow-sm">
                                <i class="fas fa-upload me-2"></i> Upload Video
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 for popup messages -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php if (isset($_SESSION['upload_status'])): ?>
        Swal.fire({
            icon: '<?php echo $_SESSION['upload_status']['type']; ?>',
            title: '<?php echo $_SESSION['upload_status']['type'] == 'success' ? 'Success!' : 'Error!'; ?>',
            text: '<?php echo $_SESSION['upload_status']['message']; ?>',
            confirmButtonColor: '#4e73df',
        });
        <?php unset($_SESSION['upload_status']); ?>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
        Swal.fire({
            icon: 'error',
            title: 'Upload Error',
            text: '<?php echo $error; ?>',
            confirmButtonColor: '#4e73df',
        });
    <?php endif; ?>
    
    // Prevent form resubmission on refresh
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    
    // Client-side validation
    document.getElementById('videoUploadForm').addEventListener('submit', function(e) {
        const fileInput = document.getElementById('video');
        const maxSize = 100 * 1024 * 1024; // 100MB
        
        if (fileInput.files.length > 0) {
            if (fileInput.files[0].size > maxSize) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'File Too Large',
                    text: 'Please select a video smaller than 100MB',
                    confirmButtonColor: '#4e73df',
                });
            }
        }
    });
});
</script>

<?php include 'footer.php'; ?>
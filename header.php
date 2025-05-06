<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'CodeMaster LMS'; ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    
    <!-- Favicon -->
    <link rel="icon" href="assets/images/favicon.ico">
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-lg">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold fs-3" href="index.php">
                <i class="fas fa-laptop-code me-2"></i>CodeMaster
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mx-1">
                        <a class="nav-link px-3 py-2 rounded-3 text-white" href="index.php">
                            <i class="fas fa-home me-1 text-white"></i> Home
                        </a>
                    </li>
                    <li class="nav-item dropdown mx-1">
                        <a class="nav-link dropdown-toggle px-3 py-2 rounded-3 text-white" href="#" id="studentDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-graduate me-1 text-white"></i> Student
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item" href="stlogin.php"><i class="fas fa-sign-in-alt me-2"></i>Login</a></li>
                            <li><a class="dropdown-item" href="stregister.php"><i class="fas fa-user-plus me-2"></i>Register</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown mx-1">
                        <a class="nav-link dropdown-toggle px-3 py-2 rounded-3 text-white" href="#" id="mentorDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-chalkboard-teacher me-1 text-white"></i> Mentor
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item" href="mtlogin.php"><i class="fas fa-sign-in-alt me-2"></i>Login</a></li>
                            <li><a class="dropdown-item" href="mtregister.php"><i class="fas fa-user-plus me-2"></i>Register</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow-1">
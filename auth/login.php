<?php
session_start();
require_once '../config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM Staff WHERE EmailID = ?");
    $stmt->execute([$email]);
    $staff = $stmt->fetch();

    if ($staff && password_verify($password, $staff['Password'])) {
        $_SESSION['staff_id'] = $staff['StaffID'];
        $_SESSION['staff_name'] = $staff['FirstName'] . ' ' . $staff['LastName'];
        $_SESSION['staff_role'] = $staff['Role'];
        $_SESSION['staff_block'] = $staff['BlockAssigned'];
        
        header('Location: ../index.php');
        exit();
    } else {
        $error = 'Invalid credentials';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hostel Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: 100px auto;
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header i {
            font-size: 48px;
            color: #0d6efd;
        }
        .card {
            border: none;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .form-floating {
            margin-bottom: 1rem;
        }
        .btn-login {
            padding: 12px;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <i class="fas fa-building mb-3"></i>
                <h2>Hostel Management System</h2>
                <p class="text-muted">Staff Login</p>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="form-floating">
                            <input type="email" class="form-control" id="email" name="email" 
                                   placeholder="name@example.com" required>
                            <label for="email">Email address</label>
                        </div>

                        <div class="form-floating">
                            <input type="password" class="form-control" id="password" name="password" 
                                   placeholder="Password" required>
                            <label for="password">Password</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-login">Login</button>
                        </div>
                    </form>

                    <!-- Sample Login Details -->
                    <div class="mt-4">
                        <p class="text-muted small">Sample Login:</p>
                        <div class="small">
                            <p class="mb-1"><strong>Warden:</strong> rajesh@hostel.com</p>
                            <p class="mb-1"><strong>Password:</strong> password</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

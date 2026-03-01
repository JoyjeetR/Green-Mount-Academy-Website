<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../sql_connect.php';

    try {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
      
        $query = "SELECT * FROM admin_users WHERE branch = 'ALL'";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if ($username === $result['username']){
                  if ($result && password_verify($password, $result['password'])) {
                        $_SESSION['admin_login'] = true;            
                        header("Location: dashboard.php");
                        exit();
                  }else {
                        $error = "Invalid password.";}
            }else{
                  $error = "Invalid username.";
            }
        }catch (PDOException $e) {
            $error = "Connection failed: " . $e->getMessage();
      }
}
?>
<!DOCTYPE html> 
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Admin Login - Green Mount Academy</title>

      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
      <link rel="stylesheet" href="../css/admin_login.css">
</head>

<body>

      <div class="login-card">

            <div class="text-center mb-4">
                  <h3 class="login-title">
                        <i class="bi bi-shield-lock-fill"></i>Admin Login
                  </h3>
                  <p class="text-muted">Login in to access dashboard</p>
            </div>

            <form method="POST" action="">
                  <!-- Username -->
                  <div class="mb-3">
                        <label class="form-label">Username</label>
                        <div class="input-group">
                              <span class="input-group-text">
                                    <i class="bi bi-person"></i>
                              </span>
                              <input type="text" name="username" class="form-control" placeholder="Enter username"
                                    required>
                        </div>
                  </div>

                  <!-- Password -->
                  <div class="mb-4">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                              <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                              </span>
                              <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Enter password" required>
                              <span class="toggle-eye" onclick="togglePassword()">
                                    <i class="bi bi-eye" id="eyeIcon"></i>
                              </span>
                        </div>
                  </div>

                  <!-- Login Button -->
                  <div class="d-grid">
                        <button type="submit" class="btn btn-login">
                              <i class="bi bi-box-arrow-in-right"></i> Login
                        </button>
                  </div>

            </form>


            <div class="text-center mt-4 login-footer">
                  © 2026 Green Mount Academy
            </div>

      </div>

      <script>

            /* Toggle Password Visibility */
            function togglePassword() {
                  const password = document.getElementById("password");
                  const icon = document.getElementById("eyeIcon");

                  if (password.type === "password") {
                        password.type = "text";
                        icon.classList.remove("bi-eye");
                        icon.classList.add("bi-eye-slash");
                  } else {
                        password.type = "password";
                        icon.classList.remove("bi-eye-slash");
                        icon.classList.add("bi-eye");
                  }
            }

      </script>

</body>

</html>
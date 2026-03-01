<!DOCTYPE html> 
<html lang="en">
<?php
      session_start();
      $branch_login = $_SESSION['branch_login'] ?? false    ;
      $branch_full_name = $_SESSION['branch_full_name'] ;
      $branch_admin_username = $_SESSION['branch_admin_username'] ?? '';

      if($branch_login !== true){
                  header("Location: branch_login.php");
                  exit();
      }
      else{
            try {
                  require_once '../sql_connect.php';

                  $branch = $_SESSION['branch'];

                  $query = "SELECT * FROM enquiry WHERE branch = ?";
                  $stmt = $pdo->prepare($query);
                  $stmt->execute([$branch]);
                  $enquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);
                  $number_of_enquiries = count($enquiries);
                  
                  } catch (PDOException $e) {
                        echo "Connection failed: " . $e->getMessage();
                  }
      }
?>
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Admin Dashboard - Green Mount Academy</title>

      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
      <link rel="stylesheet" href="../css/admin_dashboard.css">
      <link rel="stylesheet" href="../css/branch_admin_theme.css">
</head>

<body class="branch-theme">

      <!-- SIDEBAR -->
      <div class="sidebar" id="sidebar">
            <div class="logo d-flex justify-content-between align-items-center flex-column">
                  <h3><?php echo $branch_full_name ?></h3>
            <div>

                <span><i class="bi bi-mortarboard-fill"></i> Admin Panel</span>
                <button class="btn-close-sidebar d-lg-none" onclick="toggleSidebar()" aria-label="Close sidebar">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            </div>

            <a href="branch_dashBoard.php" class="active"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
            <a href="branch_enquiries.php"><i class="bi bi-envelope me-2"></i>Enquiries</a>
            <a href=""><i class="bi bi-people me-2"></i>Edit Students</a>
            <a href="add_student.php"><i class="bi bi-building me-2"></i>Add Student</a>
            <a href="branch_logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
      </div>

      <!-- MAIN CONTENT -->
      <div class="main-content">

            <!-- TOPBAR -->
            <div class="topbar mb-4 d-flex justify-content-between align-items-center gap-3">
                  <button class="btn btn-outline-success d-lg-none" onclick="toggleSidebar()">
                        <i class="bi bi-list"></i>
                  </button>

                  <div class="admin-name flex-grow-1">
                        Welcome to School Admin Panel . Here Students information/details can edited. Also new student add.
                  </div>

                  <div class="branch-admin-info">
                        <button class="btn btn-success btn-sm">
                              <i class="bi bi-person-circle"></i>
                              <?php echo htmlspecialchars($branch_full_name); ?>
                        </button>
                        <div class="branch-admin-tooltip">
                              <strong><?php echo htmlspecialchars($branch_full_name); ?></strong>
                              <p class="mb-1">Admin: <?php echo htmlspecialchars($branch_admin_username); ?></p>
                              <p class="mb-0 text-muted small">Branch admin control panel</p>
                        </div>
                  </div>
            </div>

            <!-- DASHBOARD CARDS -->
            <div class="row g-4">

                  <div class="col-12">
                        <div class="dashboard-card">
                              <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                          <h4>120 Total Students</h4>
                                          <p> <a href="" class="btn btn-success">See All Students Details</a> </p>
                                    </div>
                                    <i class="bi bi-people-fill"></i>
                              </div>
                        </div>
                  </div>

                  <div class="col-12">
                        <div class="dashboard-card">
                              <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                          <h4><?php echo $number_of_enquiries ?> New Enquiries</h4>
                                          <p> <a href="branch_enquiries.php" class="btn btn-success">See all Enquiries</a> </p>
                                    </div>
                                    <i class="bi bi-envelope-fill"></i>
                              </div>
                        </div>
                  </div>

                  <div class="col-12">
                        <div class="dashboard-card">
                              <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                          <h4>Add New Student To The Database</h4>
                                          <p> <a href="#" class="btn btn-success">Add New Student </a> </p>
                                    </div>
                                    <i class="bi bi-building"></i>
                              </div>
                        </div>
                  </div>



            </div>

      </div>

      <script>
            function toggleSidebar() {
                  document.getElementById("sidebar").classList.toggle("active");
            }
      </script>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
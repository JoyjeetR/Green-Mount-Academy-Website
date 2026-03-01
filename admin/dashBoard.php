<!DOCTYPE html>
<html lang="en">
<?php
      session_start();
      $admin_login = $_SESSION['admin_login'] ?? false;
      if($admin_login !== true){
                  header("Location: admin_login.php");
                  exit();
      }
      try {
            require_once '../sql_connect.php';
            $query = "SELECT * FROM enquiry";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $enquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $number_of_enquiries = count($enquiries);

      } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
      }
?>
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Admin Dashboard - Green Mount Academy</title>

      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
      <link rel="stylesheet" href="../css/admin_dashboard.css">
</head>

<body>

      <!-- SIDEBAR -->
      <div class="sidebar" id="sidebar">
            <div class="logo d-flex justify-content-between align-items-center">
                  <span><i class="bi bi-mortarboard-fill"></i> Admin Panel</span>
                  <button class="btn-close-sidebar d-lg-none" onclick="toggleSidebar()" aria-label="Close sidebar">
                        <i class="bi bi-x-lg"></i>
                  </button>
            </div>

            <a href="dashBoard.php" class="active"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
            <a href="enquiries.php"><i class="bi bi-envelope me-2"></i>Enquiries</a>
            <a href=""><i class="bi bi-people me-2"></i>Students</a>
            <a href="branch_login.php"><i class="bi bi-building me-2"></i>Branch Login</a>
            <a href="admin_logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
      </div>

      <!-- MAIN CONTENT -->
      <div class="main-content">

            <!-- TOPBAR -->
            <div class="topbar mb-4">
                  <button class="btn btn-outline-success d-lg-none" onclick="toggleSidebar()">
                        <i class="bi bi-list"></i>
                  </button>

                  <div class="admin-name">
                        Welcome, To Add or Edit any Information a student please login though branch.
                  </div>

                  <div>
                        <button class="btn btn-success btn-sm">
                              <i class="bi bi-person-circle"></i> Admin
                        </button>
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
                                          <p> <a href="enquiries.php" class="btn btn-success">See all Enquiries</a> </p>
                                    </div>
                                    <i class="bi bi-envelope-fill"></i>
                              </div>
                        </div>
                  </div>

                  <div class="col-12">
                        <div class="dashboard-card">
                              <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                          <h4>8 Branches</h4>
                                          <p> <a href="branch_login.php" class="btn btn-success">Login to Your Perspective branch </a> </p>
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
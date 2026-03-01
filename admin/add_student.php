<!DOCTYPE html> 
<html lang="en">
<?php
      session_start();
      $branch_login          = $_SESSION['branch_login'] ?? false;
      $branch_full_name      = $_SESSION['branch_full_name'];
      $branch_admin_username = $_SESSION['branch_admin_username'] ?? '';

      if ($branch_login !== true) {
            header("Location: branch_login.php");
            exit();
      }

      $error_message   = "";
      $success_message = "";

      try {
            require_once '../sql_connect.php';

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                  $admission_number = htmlspecialchars($_POST['admission_number']);
                  $full_name        = htmlspecialchars($_POST['full_name']);
                  $class            = htmlspecialchars($_POST['class']);
                  $branch           = $_SESSION['branch'];
                  $date_of_birth    = htmlspecialchars($_POST['dob']);
                  $parent_name      = htmlspecialchars($_POST['parent_name']);
                  $contact_number   = htmlspecialchars($_POST['contact_number']);
                  $address          = htmlspecialchars($_POST['address']);
                  $email            = htmlspecialchars($_POST['email']);
                  $monthly_school_fee = isset($_POST['school_fee']) ? (float) htmlspecialchars($_POST['school_fee']) : 0;
                  $transport_fee      = isset($_POST['transport_fee']) ? (float) htmlspecialchars($_POST['transport_fee']) : 0;
                  $hostel_fee         = isset($_POST['hostel_fee']) ? (float) htmlspecialchars($_POST['hostel_fee']) : 0;
                  $total_fee          = $monthly_school_fee + $transport_fee + $hostel_fee;

                  $std_query = "INSERT INTO students (name, admission_no, class, address, number, dob, parent_name, branch, email)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                  $stmt = $pdo->prepare($std_query);
                  $stmt->execute([$full_name, $admission_number, $class, $address, $contact_number, $date_of_birth, $parent_name, $branch, $email]);
                  
                  $student_id = $pdo->lastInsertId();
                  
                  $fee_query = "INSERT INTO fee_records (student_id, monthly_fee, transport_fee, hostel_fee, total_fee) VALUES (?, ?, ?, ?, ?)";
                  $stmt = $pdo->prepare($fee_query);
                  $stmt->execute([$student_id, $monthly_school_fee, $transport_fee, $hostel_fee, $total_fee]);


                  $success_message = "New student added successfully.";
                  header("Location: add_student.php?success=1");
            }
      } catch (PDOException $e) {
            $error_message = "Connection failed: " . $e->getMessage();
      }
?>
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Admin Dashboard - Green Mount Academy</title>

      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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

            <a href="branch_dashBoard.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
            <a href="branch_enquiries.php"><i class="bi bi-envelope me-2"></i>Enquiries</a>
            <a href=""><i class="bi bi-people me-2"></i>Edit Students</a>
            <a href="add_student.php"  class="active"><i class="bi bi-building me-2"></i>Add Student</a>
            <a href="branch_logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
      </div>

      <!-- MAIN CONTENT -->
      <div class="main-content">

            <!-- TOP BAR -->
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
                  <form action="add_student.php" method='post' class="col-12">
                        <div class="dashboard-card p-4 add-student-card">
                              <div class="row">
                                    <h4 class="mb-4 text-center col-12">Add New Student</h4>
                                    <div class="col-md-6">
                                          <div class="mb-3">
                                                <label class="form-label">Admission Number</label>
                                                <input type="number" name="admission_number" class="form-control" placeholder="Enter admission number" required>
                                          </div>
                                    </div>
                                    <div class="col-md-6">
                                          <div class="mb-3">
                                                <label class="form-label">Full Name</label>
                                                <input type="text" name="full_name" class="form-control" placeholder="Enter full name" required>
                                          </div>
                                    </div>
                                    <div class="col-md-6">
                                          <div class="mb-3">
                                                <label class="form-label">Class</label>
                                                <select name="class" class="form-select" required>
                                                      <option value="" selected disabled>Select class</option>
                                                      <option value="PR">Pre-Nursery</option>
                                                      <option value="NUR">Nursery</option>
                                                      <option value="LKG">LKG</option>
                                                      <option value="UKG">UKG</option>
                                                      <option value="1">Class I</option>
                                                      <option value="2">Class II</option>
                                                      <option value="3">Class III</option>
                                                      <option value="4">Class IV</option>
                                                      <option value="5">Class V</option>
                                                      <option value="6">Class VI</option>
                                                      <option value="7">Class VII</option>
                                                      <option value="8">Class VIII</option>
                                                      <option value="9">Class IX</option>
                                                      <option value="10">Class X</option>
                                                      <option value="11">Class XI</option>
                                                      <option value="12">Class XII</option>
                                                </select>
                                          </div>
                                    </div>
                                    <div class="col-md-6">  
                                          <div class="mb-3">
                                                <label class="form-label">Branch</label>
                                                <p><?php echo $branch_full_name ?></p>
                                          </div>
                                    </div>
                                    <div class="col-md-6">
                                          <div class="mb-3">
                                                <label class="form-label">Date of Birth</label>
                                                <div class="input-group dob-picker">
                                                      <span class="input-group-text">
                                                            <i class="bi bi-calendar-event"></i>
                                                      </span>
                                                      <input
                                                            type="date"
                                                            name="dob"
                                                            id="dob"
                                                            class="form-control dob-input"
                                                            max="<?php echo date('Y-m-d'); ?>"
                                                            required
                                                            autocomplete="off"
                                                            placeholder="Select date of birth"
                                                      >
                                                </div>
                                                <small class="text-muted small">Tap the calendar icon to pick the date easily.</small>
                                          </div>
                                    </div>
                                    <div class="col-md-6">
                                          <div class="mb-3">
                                                <label class="form-label">Parent's Name</label>
                                                <input type="text" name="parent_name" class="form-control" placeholder="Enter parent's name" required>
                                          </div>
                                    </div>
                                    <div class="col-md-6">
                                          <div class="mb-3">
                                                <label class="form-label">Contact Number</label>
                                                <input type="text" name="contact_number" class="form-control" placeholder="Enter contact number" pattern="\d{10}" maxlength="10" minlength="10" required 
                                                   oninput="this.value = this.value.replace(/[^0-9]/g, '').substr(0, 10)">
                                          </div>
                                    </div>      
                                    <div class="col-md-6">
                                          <div class="mb-3">
                                                <label class="form-label">Address</label>
                                                <input type="text" name="address" class="form-control" placeholder="Enter address" required>
                                          </div>
                                    </div>
                                    <div class="col-md-6">
                                          <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                                          </div>
                                    </div>
                                    <div class="col-md-6">
                                          <div class="mb-3">
                                                <label class="form-label">Monthly School Fee</label>
                                                <input type="number" name="school_fee" class="form-control" placeholder="Enter monthly school fee" required style="appearance: textfield; -moz-appearance: textfield;">
                                          </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                          <div class="mb-3">
                                                <label class="form-label">Transport Fee</label>
                                                <input type="number" name="transport_fee" class="form-control" placeholder="Enter transport fee" >
                                          </div>
                                    </div>
                                    <div class="col-md-6">
                                          <div class="mb-3">
                                                <label class="form-label">Hostel Fee</label>
                                                <input type="number" name="hostel_fee" class="form-control" placeholder="Enter hostel fee" >
                                          </div>
                                    </div>

                                    </div>
                                    <div class="col-12 text-center">
                                          <button type="submit" class="btn btn-success">
                                                 Add Student
                                          </button>
                                    </div>  
                              </div>


                        </div>
                        
                  </form>

                  <?php if (!empty($success_message)) : ?>
                        <div style="max-width:550px;margin:14px auto 0;font-size:15px;" class="alert alert-success shadow-sm text-center">
                              <?php echo htmlspecialchars($success_message); ?>
                        </div>
                  <?php endif; ?>

                  <?php if (!empty($error_message)) : ?>
                        <div style="max-width:550px;margin:14px auto 0;font-size:15px;" class="alert alert-danger shadow-sm text-center">
                              <?php echo htmlspecialchars($error_message); ?>
                        </div>
                  <?php endif; ?>

            </div>

      </div>

      <script>
            function toggleSidebar() {
                  document.getElementById("sidebar").classList.toggle("active");
            }
      </script>

      <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
      <script>
            document.addEventListener('DOMContentLoaded', function () {
                  if (!window.flatpickr) return;

                  const dobInput = document.getElementById('dob');
                  if (!dobInput) return;

                  const fp = flatpickr(dobInput, {
                        dateFormat: "Y-m-d",
                        altInput: true,
                        altFormat: "F j, Y",
                        maxDate: "today",
                        allowInput: true
                  });

                  const icon = document.querySelector('.dob-picker .input-group-text');
                  if (icon) {
                        icon.addEventListener('click', function () {
                              fp.open();
                        });
                  }
            });
      </script>

</body>

</html>
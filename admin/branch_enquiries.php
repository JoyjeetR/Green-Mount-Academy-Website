<!DOCTYPE html>
<html lang="en">
    <?php 
    session_start();
    $branch_login = $_SESSION['branch_login'] ?? false;    
    $branch_full_name = $_SESSION['branch_full_name'];
    $branch = $_SESSION['branch'];
    $branch_admin_username = $_SESSION['branch_admin_username'] ?? '';
      if(!$branch_login){
                  header("Location: branch_login.php");
                  exit();
      }
    ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Green Mount Academy</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

    <link rel="stylesheet" href="../css/admin_dashboard.css">
    <link rel="stylesheet" href="../css/enquiry.css">
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

        <a href="branch_dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
        <a href="branch_enquiries.php" class="active"><i class="bi bi-envelope me-2"></i>Enquiries</a>
        <a href="#"><i class="bi bi-people me-2"></i>Students</a>
        <a href="add_student.php"><i class="bi bi-building me-2"></i>Add Students</a>
        <a href="branch_logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- TOPBAR -->
        <div class="topbar mb-4 d-flex flex-wrap align-items-center gap-3">
            <button class="btn btn-outline-success d-lg-none" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>

            <div class="admin-name flex-grow-1">
                Welcome, To Add or Edit any Information a student please login though branch.
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

            <?php
            $newFilter    = isset($_GET['newFilter'])    ? $_GET['newFilter']    : '';
            $branchFilter = isset($_GET['branchFilter']) ? $_GET['branchFilter'] : '';
            $classFilter  = isset($_GET['classFilter'])  ? $_GET['classFilter']  : '';
            ?>
            <form class="filter d-flex gap-2 p" method="get" action="">
                <select class="form-select" aria-label="Filter by status" name="newFilter" id="newFilter">
                    <option value=""<?= $newFilter === '' ? ' selected' : '' ?>>All Enquiries</option>
                    <option value="unseen"<?= $newFilter === 'unseen' ? ' selected' : '' ?>>New</option>
                </select>
                <select class="form-select" aria-label="Default select example" name="classFilter" id="classFilter">
                    <option value=""<?= $classFilter === '' ? ' selected' : '' ?>>All Classes</option>
                    <option value="pre-nur"<?= $classFilter === 'pre-nur' ? ' selected' : '' ?>>Pre-Nursery</option>
                    <option value="nur"<?= $classFilter === 'nur' ? ' selected' : '' ?>>Nursery</option>
                    <option value="LKG"<?= $classFilter === 'LKG' ? ' selected' : '' ?>>LKG</option>
                    <option value="UKG"<?= $classFilter === 'UKG' ? ' selected' : '' ?>>UKG</option>
                    <option value="one"<?= $classFilter === 'one' ? ' selected' : '' ?>>Class I</option>
                    <option value="two"<?= $classFilter === 'two' ? ' selected' : '' ?>>Class II</option>
                    <option value="three"<?= $classFilter === 'three' ? ' selected' : '' ?>>Class III</option>
                    <option value="four"<?= $classFilter === 'four' ? ' selected' : '' ?>>Class IV</option>
                    <option value="five"<?= $classFilter === 'five' ? ' selected' : '' ?>>Class V</option>
                    <option value="six"<?= $classFilter === 'six' ? ' selected' : '' ?>>Class VI</option>
                    <option value="seven"<?= $classFilter === 'seven' ? ' selected' : '' ?>>Class VII</option>
                    <option value="eight"<?= $classFilter === 'eight' ? ' selected' : '' ?>>Class VIII</option>
                    <option value="nine"<?= $classFilter === 'nine' ? ' selected' : '' ?>>Class IX</option>
                    <option value="ten"<?= $classFilter === 'ten' ? ' selected' : '' ?>>Class X</option>
                    <option value="eleven"<?= $classFilter === 'eleven' ? ' selected' : '' ?>>Class XI</option>
                    <option value="twelve"<?= $classFilter === 'twelve' ? ' selected' : '' ?>>Class XII</option>
                </select>
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-magnifying-glass"></i> <span class="d-none d-md-inline">Search</span></button>
            </form>
        </div>

        <!-- DASHBOARD CARDS -->
        <div class="row g-4">
        <?php
        try {
            require_once '../sql_connect.php';

            $conditions = [];
            $params = [];

            // Always filter by branch
            $conditions[] = "branch = :branch";
            $params[':branch'] = $branch;

            if ($newFilter === 'unseen') {
                $conditions[] = "status = :status";
                $params[':status'] = 'unseen';
            }

            if (!empty($classFilter)) {
                $conditions[] = "classApplying = :class";
                $params[':class'] = $classFilter;
            }

            // Build query
            $query = "SELECT * FROM enquiry";

            if (!empty($conditions)) {
                $query .= " WHERE " . implode(" AND ", $conditions);
            }

            $stat = $pdo->prepare($query);
            $stat->execute($params);

            $result = $stat->fetchAll(PDO::FETCH_ASSOC);
            $enquiryCount = count($result);
            ?>
            
            <!-- Search Results Count -->
            <div class="search-results-count">
                <i class="bi bi-info-circle me-2"></i>
                <span><?= $enquiryCount ?> <?= $enquiryCount === 1 ? 'enquiry' : 'enquiries' ?> found</span>
            </div>

            <?php
            if($result){
                foreach($result as $row){
        ?>
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="enquiry-card">

                                <div class="enquiry-header d-flex justify-content-between align-items-start flex-wrap">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">
                                            Enquiry #<?= htmlspecialchars($row['id']) ?>
                                        </h6>
                                        <small class="text-muted d-block">
                                            Submitted on <?= htmlspecialchars($row['time']) ?>
                                        </small>
                                    </div>

                                    <div class="mt-2 mt-md-0">
                                        <?php if($row['status'] == 'unseen'): ?>
                                            <span class="badge bg-danger">New</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Contacted</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="enquiry-body">
                                    <div class="row g-3">

                                        <div class="col-lg-4 col-md-6">
                                            <p><strong>Guardian:</strong>
                                                <?= htmlspecialchars($row['guardianName']) ?>
                                            </p>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <p><strong>Student:</strong>
                                                <?= htmlspecialchars($row['studentName']) ?>
                                            </p>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <p><strong>Class:</strong>
                                                <?= htmlspecialchars($row['classApplying']) ?>
                                            </p>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <p><strong>Phone:</strong>
                                                <?= htmlspecialchars($row['phone']) ?>
                                            </p>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <p><strong>Email:</strong>
                                                <?= htmlspecialchars($row['email']) ?>
                                            </p>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <p><strong>Branch:</strong>
                                                <?= htmlspecialchars($row['branch']) ?>
                                            </p>
                                        </div>

                                        <div class="col-12">
                                            <div class="message-box">
                                                <strong>Message:</strong>
                                                <p class="mb-0">
                                                    <?= nl2br(htmlspecialchars($row['message'])) ?>
                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="enquiry-footer d-flex justify-content-end gap-2">
                                <?php if($row['status'] == 'unseen'): ?>
                                    <a href="branch_enquiry_action.php?action=mark_contacted&amp;id=<?= $row['id'] ?>&amp;newFilter=<?= urlencode($newFilter) ?>&amp;branchFilter=<?= urlencode($branchFilter) ?>&amp;classFilter=<?= urlencode($classFilter) ?>"
                                    class="btn btn-sm btn-success"
                                    onclick="return confirm('Mark this enquiry as contacted?');">
                                        <i class="bi bi-check-circle"></i> <span class="d-none d-sm-inline">Mark Contacted</span><span class="d-sm-none">Contacted</span>
                                    </a>
                                    <?php endif; ?>
                                    <a href="branch_enquiry_action.php?action=delete&amp;id=<?= $row['id'] ?>&amp;newFilter=<?= urlencode($newFilter) ?>&amp;branchFilter=<?= urlencode($branchFilter) ?>&amp;classFilter=<?= urlencode($classFilter) ?>"
                                    class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Are you sure you want to delete this enquiry? This is your first confirmation.');">
                                        <i class="bi bi-trash"></i> Delete
                                    </a>

                                </div>

                            </div>
                        </div>
                    </div>
            <?php
                }
            }else{
                echo "<div class='no-enquiries'>
                        <div class='no-enquiries-icon'>
                            <i class='bi bi-envelope-paper'></i>
                        </div>
                        <h5 class='no-enquiries-title'>No Enquiries Found</h5>
                        <p class='no-enquiries-text'>No enquiries found in the database.</p>
                    </div>";
                }
            }catch (PDOException $e) {
            echo "Database connection failed: " . $e->getMessage();}
            ?>
        </div>
    </div>

    <script src="../js/admin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
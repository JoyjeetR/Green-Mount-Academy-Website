<?php
/**
 * Handles enquiry actions: delete and mark as contacted.
 * Requires double confirmation for delete action.
 * Expects GET parameters: action, id, and optional filters.
 * Redirects back to enquiries.php, preserving filters.
 */
$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$confirm = isset($_GET['confirm']) ? $_GET['confirm'] : '';
$newFilter    = isset($_GET['newFilter'])    ? $_GET['newFilter']    : '';
$branchFilter = isset($_GET['branchFilter']) ? $_GET['branchFilter'] : '';
$classFilter  = isset($_GET['classFilter'])  ? $_GET['classFilter']  : '';

if ($id <= 0 || !in_array($action, ['delete', 'mark_contacted'])) {
    header('Location: enquiries.php');
    exit;
}

// Build redirect URL preserving filters
$redirect = 'enquiries.php';
$params = [];
if ($newFilter !== '') {
    $params['newFilter'] = $newFilter;
}
if ($branchFilter !== '') {
    $params['branchFilter'] = $branchFilter;
}
if ($classFilter !== '') {
    $params['classFilter'] = $classFilter;
}
$redirectUrl = $redirect;
if (!empty($params)) {
    $redirectUrl .= '?' . http_build_query($params);
}

// Handle mark_contacted action (no double confirmation needed)
if ($action === 'mark_contacted') {
    require_once '../sql_connect.php';
    
    try {
        $stmt = $pdo->prepare("UPDATE enquiry SET status = 'seen' WHERE id = ?");
        $stmt->execute([$id]);
    } catch (PDOException $e) {
        // Redirect anyway; optional: pass error in query string
    }
    
    header('Location: ' . $redirectUrl);
    exit;
}

// Handle delete action (requires double confirmation)
if ($action === 'delete') {
    // If not confirmed, show confirmation page
    if ($confirm !== 'yes') {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Confirm Delete - Green Mount Academy</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
            <style>
                body {
                    background: #f8f9fa;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    min-height: 100vh;
                    margin: 0;
                }
                .confirm-box {
                    background: white;
                    border-radius: 15px;
                    padding: 2rem;
                    box-shadow: 0 6px 25px rgba(0,0,0,0.1);
                    max-width: 500px;
                    text-align: center;
                }
                .confirm-icon {
                    width: 80px;
                    height: 80px;
                    margin: 0 auto 1.5rem;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background: #fee;
                    border-radius: 50%;
                    color: #dc3545;
                    font-size: 2.5rem;
                }
                .btn-group-confirm {
                    display: flex;
                    gap: 1rem;
                    justify-content: center;
                    margin-top: 1.5rem;
                }
            </style>
        </head>
        <body>
            <div class="confirm-box">
                <div class="confirm-icon">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <h4>Are you absolutely sure?</h4>
                <p class="text-muted">This action cannot be undone. The enquiry will be permanently deleted from the database.</p>
                <div class="btn-group-confirm">
                    <a href="<?= htmlspecialchars($redirectUrl) ?>" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                    <a href="enquiry_action.php?action=delete&id=<?= $id ?>&confirm=yes&<?= http_build_query(array_filter([
                        'newFilter' => $newFilter,
                        'branchFilter' => $branchFilter,
                        'classFilter' => $classFilter
                    ])) ?>" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Yes, Delete Permanently
                    </a>
                </div>
            </div>
        </body>
        </html>
        <?php
        exit;
    }

    // Second confirmation passed, proceed with deletion
    require_once '../sql_connect.php';

    try {
        $stmt = $pdo->prepare("DELETE FROM enquiry WHERE id = ?");
        $stmt->execute([$id]);
    } catch (PDOException $e) {
        // Redirect anyway; optional: pass error in query string
    }

    header('Location: ' . $redirectUrl);
    exit;
}

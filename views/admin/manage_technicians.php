<?php
// views/admin/manage_technicians.php
declare(strict_types=1);

require_once __DIR__ . '/../../models/technician_model.php';

$action = $_POST['action'] ?? $_GET['action'] ?? 'list';
$error  = '';

// Handle delete on this page
if ($action === 'delete') {
    $techID = isset($_POST['techID']) ? (int)$_POST['techID'] : 0;

    if ($techID > 0) {
        try {
            delete_technician($techID);
            // Redirect back to avoid resubmission prompt on refresh
            header('Location: manage_technicians.php');
            exit;
        } catch (PDOException $e) {
            $error = 'Error deleting technician.';
        }
    } else {
        $error = 'No technician selected to delete.';
    }
}

// Always load the list to display
$technicians = get_technicians();

// Shared header/footer live in views root
include __DIR__ . '/../header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Manage Technicians</h2>
    <a href="/PHPAssignment3/index.php" class="btn btn-outline-secondary btn-sm">
        &larr; Back to Home
    </a>
</div>

<?php if ($error !== ''): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<div class="card mb-4 shadow-sm">
    <div class="card-header bg-warning fw-semibold d-flex justify-content-between align-items-center">
        <span>Technician List</span>
        <a href="add_technician.php" class="btn btn-sm btn-dark">
            Add Technician
        </a>
    </div>

    <div class="table-responsive">
        <?php if (count($technicians) === 0): ?>
            <p class="p-3 mb-0">No technicians found.</p>
        <?php else: ?>
            <table class="table table-striped table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($technicians as $tech): ?>
                    <tr>
                        <td><?= htmlspecialchars($tech['firstName'] . ' ' . $tech['lastName']) ?></td>
                        <td><?= htmlspecialchars($tech['email']) ?></td>
                        <td><?= htmlspecialchars($tech['phone']) ?></td>
                        <td class="text-end">
                            <form action="manage_technicians.php" method="post" class="d-inline">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="techID" value="<?= (int)$tech['techID'] ?>">
                                <button
                                    type="submit"
                                    class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Delete this technician?');"
                                >
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php
include __DIR__ . '/../footer.php';
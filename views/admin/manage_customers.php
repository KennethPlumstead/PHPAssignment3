<?php
// views/admin/manage_customers.php
declare(strict_types=1);

require_once __DIR__ . '/../../models/customer_model.php';

$lastName  = '';
$customers = [];
$error     = '';
$message   = '';

if (($_POST['action'] ?? '') === 'search') {
    $lastName = trim($_POST['lastName'] ?? '');

    if ($lastName === '') {
        $error = 'Please enter a last name to search.';
    } else {
        $customers = search_customers($lastName);
        if (count($customers) === 0) {
            $message = 'No customers found with that last name.';
        }
    }
}

include __DIR__ . '/../header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Manage Customers</h2>
    <a href="/PHPAssignment3/index.php" class="btn btn-outline-secondary btn-sm">
        &larr; Back to Home
    </a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white fw-semibold">
        Customer Search
    </div>
    <div class="card-body">
        <?php if ($error !== ''): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="manage_customers.php" method="post" class="row gy-2 gx-2 align-items-end">
            <input type="hidden" name="action" value="search">

            <div class="col-sm-6 col-md-4">
                <label for="lastName" class="form-label mb-1">Last Name:</label>
                <input
                    type="text"
                    name="lastName"
                    id="lastName"
                    class="form-control"
                    value="<?= htmlspecialchars($lastName) ?>"
                >
            </div>

            <div class="col-auto">
                <button type="submit" class="btn btn-primary">
                    Search
                </button>
            </div>
        </form>
    </div>
</div>

<?php if ($message !== ''): ?>
    <div class="alert alert-info">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<?php if (count($customers) > 0): ?>
    <div class="card shadow-sm">
        <div class="card-header bg-light fw-semibold">
            Results
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email Address</th>
                        <th>City</th>
                        <th class="text-end">Select</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($customers as $cust): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($cust['firstName'] . ' ' . $cust['lastName']) ?>
                        </td>
                        <td><?= htmlspecialchars($cust['email'] ?? '') ?></td>
                        <td><?= htmlspecialchars($cust['city'] ?? '') ?></td>
                        <td class="text-end">
                            <!-- IMPORTANT: point to update_customer.php, not view_update_customer.php -->
                            <form action="update_customer.php" method="get" class="d-inline">
                                <input type="hidden" name="customerID"
                                       value="<?= (int)$cust['customerID'] ?>">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    Select
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php
include __DIR__ . '/../footer.php';
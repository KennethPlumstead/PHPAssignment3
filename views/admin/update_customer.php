<?php
// views/admin/update_customer.php
declare(strict_types=1);

require_once __DIR__ . '/../../models/customer_model.php';

$error    = '';
$success  = '';
$customer = null;

// Get customerID from GET (initial) or POST (after submit)
$customerID = isset($_GET['customerID'])
    ? (int)$_GET['customerID']
    : (int)($_POST['customerID'] ?? 0);

if ($customerID <= 0) {
    // No valid customer – go back to search
    header('Location: manage_customers.php');
    exit;
}

if (($_POST['action'] ?? '') === 'update_customer') {
    $firstName   = trim($_POST['firstName'] ?? '');
    $lastName    = trim($_POST['lastName'] ?? '');
    $address     = trim($_POST['address'] ?? '');
    $city        = trim($_POST['city'] ?? '');
    $state       = trim($_POST['state'] ?? '');
    $postalCode  = trim($_POST['postalCode'] ?? '');
    $countryCode = trim($_POST['countryCode'] ?? '');
    $phone       = trim($_POST['phone'] ?? '');
    $email       = trim($_POST['email'] ?? '');
    $password    = trim($_POST['password'] ?? '');

    // You can adjust how strict you want this; this keeps it simple:
    if (
        $firstName === '' ||
        $lastName === ''  ||
        $address === ''   ||
        $city === ''      ||
        $state === ''     ||
        $postalCode === ''||
        $countryCode === ''||
        $phone === ''     ||
        $email === ''
    ) {
        $error = 'All fields except Password are required.';
    } else {
        try {
            // If password is blank, it will not change the existing hash
            update_customer(
                $customerID,
                $firstName,
                $lastName,
                $address,
                $city,
                $state,
                $postalCode,
                $countryCode,
                $phone,
                $email,
                $password
            );

            $success = 'Customer updated successfully.';
        } catch (PDOException $e) {
            $error = 'Error updating customer.';
        }
    }
}

// Always reload the latest customer data
$customer = get_customer($customerID);
if (!$customer) {
    header('Location: manage_customers.php');
    exit;
}

include __DIR__ . '/../header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">View/Update Customer</h2>
    <a href="manage_customers.php" class="btn btn-outline-secondary btn-sm">
        &larr; Search Customers
    </a>
</div>

<?php if ($error !== ''): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<?php if ($success !== ''): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-header bg-secondary text-white fw-semibold">
        Customer Details
    </div>
    <div class="card-body">
        <form action="update_customer.php" method="post" novalidate>
            <input type="hidden" name="action" value="update_customer">
            <input type="hidden" name="customerID" value="<?= (int)$customer['customerID'] ?>">

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="firstName" class="form-label">First Name</label>
                    <input
                        type="text"
                        class="form-control"
                        id="firstName"
                        name="firstName"
                        required
                        value="<?= htmlspecialchars($customer['firstName']) ?>"
                    >
                </div>

                <div class="col-md-6">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input
                        type="text"
                        class="form-control"
                        id="lastName"
                        name="lastName"
                        required
                        value="<?= htmlspecialchars($customer['lastName']) ?>"
                    >
                </div>

                <div class="col-12">
                    <label for="address" class="form-label">Address</label>
                    <input
                        type="text"
                        class="form-control"
                        id="address"
                        name="address"
                        required
                        value="<?= htmlspecialchars($customer['address'] ?? '') ?>"
                    >
                </div>

                <div class="col-md-4">
                    <label for="city" class="form-label">City</label>
                    <input
                        type="text"
                        class="form-control"
                        id="city"
                        name="city"
                        required
                        value="<?= htmlspecialchars($customer['city'] ?? '') ?>"
                    >
                </div>

                <div class="col-md-4">
                    <label for="state" class="form-label">State</label>
                    <input
                        type="text"
                        class="form-control"
                        id="state"
                        name="state"
                        required
                        value="<?= htmlspecialchars($customer['state'] ?? '') ?>"
                    >
                </div>

                <div class="col-md-4">
                    <label for="postalCode" class="form-label">Postal Code</label>
                    <input
                        type="text"
                        class="form-control"
                        id="postalCode"
                        name="postalCode"
                        required
                        value="<?= htmlspecialchars($customer['postalCode'] ?? '') ?>"
                    >
                </div>

                <div class="col-md-4">
                    <label for="countryCode" class="form-label">Country Code</label>
                    <input
                        type="text"
                        class="form-control"
                        id="countryCode"
                        name="countryCode"
                        required
                        value="<?= htmlspecialchars($customer['countryCode'] ?? '') ?>"
                        placeholder="US"
                    >
                </div>

                <div class="col-md-4">
                    <label for="phone" class="form-label">Phone</label>
                    <input
                        type="text"
                        class="form-control"
                        id="phone"
                        name="phone"
                        required
                        value="<?= htmlspecialchars($customer['phone'] ?? '') ?>"
                    >
                </div>

                <div class="col-md-4">
                    <label for="email" class="form-label">Email</label>
                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        required
                        value="<?= htmlspecialchars($customer['email'] ?? '') ?>"
                    >
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label">
                        Password (leave blank to keep existing)
                    </label>
                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                    >
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    Update Customer
                </button>
            </div>
        </form>
    </div>
</div>

<?php
include __DIR__ . '/../footer.php';
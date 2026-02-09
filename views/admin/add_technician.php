<?php
// views/admin/add_technician.php
declare(strict_types=1);

require_once __DIR__ . '/../../models/technician_model.php';

$error = '';

if (($_POST['action'] ?? '') === 'add_technician') {
    $firstName = trim($_POST['firstName'] ?? '');
    $lastName  = trim($_POST['lastName'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $phone     = trim($_POST['phone'] ?? '');
    $password  = trim($_POST['password'] ?? '');

    // All text boxes required, including password
    if (
        $firstName === '' ||
        $lastName === ''  ||
        $email === ''     ||
        $phone === ''     ||
        $password === ''
    ) {
        $error = 'All fields are required.';
    } else {
        try {
            add_technician($firstName, $lastName, $email, $phone, $password);
            header('Location: manage_technicians.php');
            exit;
        } catch (PDOException $e) {
            $error = 'Error adding technician.';
        }
    }
}

include __DIR__ . '/../header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Add Technician</h2>
    <a href="manage_technicians.php" class="btn btn-outline-secondary btn-sm">
        &larr; Back to Technician List
    </a>
</div>

<?php if ($error !== ''): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-header bg-warning fw-semibold">
        New Technician
    </div>
    <div class="card-body">
        <form action="add_technician.php" method="post" novalidate>
            <input type="hidden" name="action" value="add_technician">

            <div class="mb-3">
                <label for="firstName" class="form-label">First name</label>
                <input
                    type="text"
                    name="firstName"
                    id="firstName"
                    class="form-control"
                    required
                    value="<?= htmlspecialchars($_POST['firstName'] ?? '') ?>"
                >
            </div>

            <div class="mb-3">
                <label for="lastName" class="form-label">Last name</label>
                <input
                    type="text"
                    name="lastName"
                    id="lastName"
                    class="form-control"
                    required
                    value="<?= htmlspecialchars($_POST['lastName'] ?? '') ?>"
                >
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-control"
                    required
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                >
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input
                    type="text"
                    name="phone"
                    id="phone"
                    class="form-control"
                    required
                    value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                >
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary">
                Add Technician
            </button>
        </form>
    </div>
</div>

<?php
include __DIR__ . '/../footer.php';
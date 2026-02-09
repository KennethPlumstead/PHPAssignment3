<?php include __DIR__ . '/views/header.php'; ?>

<div class="text-center mb-4">
    <h1 class="fw-bold mb-2">SportsPro Technical Support</h1>
    <p class="text-muted fs-5 mb-0">
        Product management and technical support system
    </p>
</div>

<!-- Administrators -->
<div class="card mb-4 shadow-sm">
    <div class="card-header bg-primary text-white fs-5 fw-semibold">
        Administrators
    </div>
    <ul class="list-group list-group-flush fs-6">
        <li class="list-group-item">
            <a class="text-decoration-none" href="views/admin/product_manager.php">
                Manage Products
            </a>
        </li>
        <li class="list-group-item">
            <a class="text-decoration-none" href="views/admin/manage_technicians.php">
                Manage Technicians
            </a>
        </li>
        <li class="list-group-item">
            <a class="text-decoration-none" href="views/admin/manage_customers.php">
                Manage Customers
            </a>
        </li>
    </ul>
</div>

<!-- Technicians -->
<div class="card mb-4 shadow-sm">
    <div class="card-header bg-warning fs-5 fw-semibold">
        Technicians
    </div>
    <ul class="list-group list-group-flush fs-6">
        <li class="list-group-item">
            <a class="text-decoration-none" href="views/technicians/incidents.php">
                Update Incident
            </a>
        </li>
    </ul>
</div>

<!-- Customers -->
<div class="card mb-4 shadow-sm">
    <div class="card-header bg-success text-white fs-5 fw-semibold">
        Customers
    </div>
    <ul class="list-group list-group-flush fs-6">
        <li class="list-group-item">
            <a class="text-decoration-none" href="views/customers/register_product.php">
                Register Product
            </a>
        </li>
    </ul>
</div>

<?php include __DIR__ . '/views/footer.php'; ?>
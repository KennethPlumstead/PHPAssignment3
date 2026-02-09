<?php
// models/product_model.php

require_once __DIR__ . '/../db/database.php';

/**
 * Get all products ordered by productCode.
 *
 * @return array
 */
function get_products(): array
{
    global $db;

    $query = '
        SELECT productCode, name, version, releaseDate
        FROM products
        ORDER BY productCode
    ';

    $statement = $db->query($query);
    return $statement->fetchAll();
}

/**
 * Get a single product by code.
 *
 * @param string $code
 * @return array|null
 */
function get_product(string $code): ?array
{
    global $db;

    $query = '
        SELECT productCode, name, version, releaseDate
        FROM products
        WHERE productCode = :code
        LIMIT 1
    ';
    $statement = $db->prepare($query);
    $statement->execute([':code' => $code]);
    $product = $statement->fetch();

    return $product ?: null;
}

/**
 * Add a new product.
 *
 * @param string $code
 * @param string $name
 * @param string $version
 * @param string $release_date  YYYY-MM-DD
 */
function add_product(string $code, string $name, string $version, string $release_date): void
{
    global $db;

    $query = '
        INSERT INTO products (productCode, name, version, releaseDate)
        VALUES (:code, :name, :version, :release_date)
    ';
    $statement = $db->prepare($query);
    $statement->execute([
        ':code'         => $code,
        ':name'         => $name,
        ':version'      => $version,
        ':release_date' => $release_date,
    ]);
}

/**
 * Update an existing product.
 *
 * @param string $code
 * @param string $name
 * @param string $version
 * @param string $release_date  YYYY-MM-DD
 */
function update_product(string $code, string $name, string $version, string $release_date): void
{
    global $db;

    $query = '
        UPDATE products
        SET name = :name,
            version = :version,
            releaseDate = :release_date
        WHERE productCode = :code
    ';
    $statement = $db->prepare($query);
    $statement->execute([
        ':code'         => $code,
        ':name'         => $name,
        ':version'      => $version,
        ':release_date' => $release_date,
    ]);
}

/**
 * Delete a product by code.
 *
 * @param string $code
 */
function delete_product(string $code): void
{
    global $db;

    $query = 'DELETE FROM products WHERE productCode = :code';
    $statement = $db->prepare($query);
    $statement->execute([':code' => $code]);
}
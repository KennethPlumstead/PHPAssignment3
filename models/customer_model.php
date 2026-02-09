<?php
// models/customer_model.php
declare(strict_types=1);

require_once __DIR__ . '/../db/database.php';

/**
 * Search customers by last name.
 *
 * @param string $lastName
 * @return array<int, array<string,mixed>>
 */
function search_customers(string $lastName): array
{
    global $db;

    $sql = '
        SELECT customerID, firstName, lastName, email, city
        FROM customers
        WHERE lastName LIKE :lastName
        ORDER BY lastName, firstName
    ';

    $statement = $db->prepare($sql);
    $statement->execute([
        ':lastName' => $lastName . '%', // starts with
    ]);

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get a single customer by ID.
 */
function get_customer(int $customerID): ?array
{
    global $db;

    $sql = '
        SELECT customerID, firstName, lastName, address, city, state,
               postalCode, countryCode, phone, email, passwordHash
        FROM customers
        WHERE customerID = :customerID
        LIMIT 1
    ';

    $statement = $db->prepare($sql);
    $statement->execute([':customerID' => $customerID]);

    $customer = $statement->fetch(PDO::FETCH_ASSOC);
    return $customer ?: null;
}

/**
 * Update a customer.
 *
 * If $password is non-empty, we hash and update it.
 * If it's empty, the existing passwordHash is left alone.
 */
function update_customer(
    int $customerID,
    string $firstName,
    string $lastName,
    string $address,
    string $city,
    string $state,
    string $postalCode,
    string $countryCode,
    string $phone,
    string $email,
    string $password = ''
): void {
    global $db;

    if ($password !== '') {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = '
            UPDATE customers
            SET firstName   = :firstName,
                lastName    = :lastName,
                address     = :address,
                city        = :city,
                state       = :state,
                postalCode  = :postalCode,
                countryCode = :countryCode,
                phone       = :phone,
                email       = :email,
                passwordHash = :passwordHash
            WHERE customerID = :customerID
        ';

        $params = [
            ':firstName'    => $firstName,
            ':lastName'     => $lastName,
            ':address'      => $address,
            ':city'         => $city,
            ':state'        => $state,
            ':postalCode'   => $postalCode,
            ':countryCode'  => $countryCode,
            ':phone'        => $phone,
            ':email'        => $email,
            ':passwordHash' => $passwordHash,
            ':customerID'   => $customerID,
        ];
    } else {
        $sql = '
            UPDATE customers
            SET firstName   = :firstName,
                lastName    = :lastName,
                address     = :address,
                city        = :city,
                state       = :state,
                postalCode  = :postalCode,
                countryCode = :countryCode,
                phone       = :phone,
                email       = :email
            WHERE customerID = :customerID
        ';

        $params = [
            ':firstName'   => $firstName,
            ':lastName'    => $lastName,
            ':address'     => $address,
            ':city'        => $city,
            ':state'       => $state,
            ':postalCode'  => $postalCode,
            ':countryCode' => $countryCode,
            ':phone'       => $phone,
            ':email'       => $email,
            ':customerID'  => $customerID,
        ];
    }

    $statement = $db->prepare($sql);
    $statement->execute($params);
}
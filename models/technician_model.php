<?php
// models/technician_model.php
declare(strict_types=1);

require_once __DIR__ . '/../db/database.php';

/**
 * Get all technicians ordered by last name, first name.
 *
 * @return array<int, array<string,mixed>>
 */
function get_technicians(): array
{
    global $db;

    $sql = '
        SELECT techID, firstName, lastName, email, phone
        FROM technicians
        ORDER BY lastName, firstName
    ';

    $statement = $db->query($sql);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Add a new technician.
 *
 * For this assignment we accept a plain password from the form,
 * hash it here, and store it in the passwordHash column.
 */
function add_technician(
    string $firstName,
    string $lastName,
    string $email,
    string $phone,
    string $password
): void {
    global $db;

    // Hash the password before storing it
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = '
        INSERT INTO technicians (firstName, lastName, email, phone, passwordHash)
        VALUES (:firstName, :lastName, :email, :phone, :passwordHash)
    ';

    $statement = $db->prepare($sql);
    $statement->execute([
        ':firstName'    => $firstName,
        ':lastName'     => $lastName,
        ':email'        => $email,
        ':phone'        => $phone,
        ':passwordHash' => $passwordHash,
    ]);
}

/**
 * Delete a technician by ID.
 */
function delete_technician(int $techID): void
{
    global $db;

    $sql = '
        DELETE FROM technicians
        WHERE techID = :techID
    ';

    $statement = $db->prepare($sql);
    $statement->execute([':techID' => $techID]);
}
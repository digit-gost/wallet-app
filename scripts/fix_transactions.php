<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Core\Database;

$pdo = Database::connect();

try {
    $pdo->beginTransaction();

    // Update transactions where wallet_code currently holds the telephone
    $sql = "UPDATE transactions t SET wallet_code = w.code FROM wallets w WHERE t.wallet_code = w.telephone";
    $count = $pdo->exec($sql);

    $pdo->commit();

    echo "Updated $count transaction(s)\n";
} catch (Throwable $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    echo "Error: " . $e->getMessage() . PHP_EOL;
    exit(1);
}

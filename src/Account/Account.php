<?php

namespace App\Account;

use App\Storage\StorageInterface;
use PDO;

class Account
{
    public function exists(StorageInterface $db, string $number): bool
    {
        $stmt = $db->getConnection()->prepare('SELECT COUNT(*) FROM accounts WHERE account_number = ?');
        $stmt->execute([$number]);

        return $stmt->fetchColumn() > 0;
    }

    public function getByNumber(StorageInterface $db, string $number): ?AccountDTO
    {
        $stmt = $db->getConnection()->prepare('SELECT * FROM accounts WHERE account_number = ?');
        $stmt->execute([$number]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data == []) {
            return null;
        }
        return new AccountDTO(
            $data['id'],
            $data['account_holder'],
            $data['account_number'],
            $data['balance'],
            $data['created_at'],
        );
    }

    public function all(StorageInterface $db): array
    {
        $stmt = $db->getConnection()->query('SELECT * FROM accounts ORDER BY account_number');
        $accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($accounts as $index => $account) {
            $accounts[$index] = new AccountDTO(
                $account['id'],
                $account['account_holder'],
                $account['account_number'],
                $account['balance'],
                $account['created_at'],
            );
        }
        return $accounts;
    }
}

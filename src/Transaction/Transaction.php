<?php

namespace App\Transaction;

use PDO;
use App\Storage\StorageInterface;

class Transaction
{
    public function get(StorageInterface $db, int $limit): array
    {
        $stmt = $db->getConnection()->prepare('SELECT * FROM transactions ORDER BY transaction_date DESC LIMIT :limit');
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->execute();

        $transactions =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($transactions as $index => $transaction) {
            $transactions[$index] = new TransactionDTO(
                $transaction['id'],
                $transaction['from_account'],
                $transaction['to_account'],
                $transaction['amount'],
                $transaction['transaction_date'],
            );
        }
        return $transactions;
    }
}

<?php

namespace App\Actions;

use App\Storage\StorageInterface;
use App\Transaction\TransactionDTO;

class CreateTransactionAction
{
    public function execute(StorageInterface $db, TransactionDTO $transaction): bool
    {
        $transaction = $transaction->toArray();
        $stmt = $db->getConnection()->prepare('INSERT INTO transactions (from_account, to_account, amount) VALUES (?, ?, ?)');

        return $stmt->execute([$transaction['from_account'], $transaction['to_account'], $transaction['amount']]);
    }
}

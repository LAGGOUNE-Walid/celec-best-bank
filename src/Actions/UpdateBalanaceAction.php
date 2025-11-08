<?php

namespace App\Actions;

use App\Account\AccountDTO;
use App\Storage\StorageInterface;

class UpdateBalanaceAction
{
    public function execute(StorageInterface $db, AccountDTO $account, float $amount): bool
    {
        $stmt = $db->getConnection()->prepare("UPDATE accounts SET balance = balance + ? WHERE account_number = ?");
        return $stmt->execute([$amount, $account->getNumber()]);
    }
}

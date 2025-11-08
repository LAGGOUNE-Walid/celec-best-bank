<?php

namespace App\Services;

use App\Account\Account;
use App\Actions\CreateTransactionAction;
use App\Actions\UpdateBalanaceAction;
use App\Storage\StorageInterface;
use App\Transaction\TransactionDTO;
use Exception;

class TransferService
{
    public function transfer(StorageInterface $db, string $fromAccountNumber, string $toAccountNumber, float $amount): array
    {
        if ($fromAccountNumber == $toAccountNumber) {
            return ['success' => false, 'message' => 'Cannot transfer to the same account!'];
        }
        if ($amount <= 0) {
            return ['success' => false, 'message' => 'Amount must be greater than zero!'];
        }
        $db->getConnection()->beginTransaction();
        try {
            $account = new Account;
            $sender = $account->getByNumber($db, $fromAccountNumber);
            if (! $sender) {
                throw new Exception('Sender account not found!');
            }
            if ($sender->getBalance() < $amount) {
                throw new Exception('Insufficient balance!');
            }
            $receiver = $account->getByNumber($db, $fromAccountNumber);
            if (! $receiver) {
                throw new Exception('Receiver account not found!');
            }
            $updateBalanceAction = new UpdateBalanaceAction;
            $updateBalanceAction->execute($db, $sender, -$amount);
            $updateBalanceAction->execute($db, $receiver, $amount);

            $createTransactionAction = new CreateTransactionAction;
            $createTransactionAction->execute($db, new TransactionDTO(-1, $fromAccountNumber, $toAccountNumber, $amount, ''));
            $db->getConnection()->commit();

            return [
                'success' => true,
                'message' => 'Transfer successful! $'.number_format($amount, 2)." transferred from $fromAccountNumber to $toAccountNumber",
            ];
        } catch (Exception $e) {
            $db->getConnection()->rollBack();

            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}

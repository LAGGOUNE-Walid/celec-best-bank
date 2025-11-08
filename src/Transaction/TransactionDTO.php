<?php

namespace App\Transaction;

class TransactionDTO
{
    public function __construct(
        private int $id,
        private string $fromAccount,
        private string $toAccount,
        private float $amount,
        private string $transactionDate
    ){}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'from_account' => $this->fromAccount,
            'to_account' => $this->toAccount,
            'amount' => $this->amount,
            'transaction_date' => $this->transactionDate
        ];
    }

}

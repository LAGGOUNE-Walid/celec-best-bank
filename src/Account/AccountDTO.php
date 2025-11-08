<?php

namespace App\Account;

class AccountDTO
{
    protected int $id;

    protected string $account_number;

    protected string $account_holder;

    protected float $balance;

    protected string $created_at;

    public function __construct(
        int $id,
        string $account_holder,
        string $account_number,
        float $balance,
        string $created_at,
    ) {
        $this->id = $id;
        $this->account_holder = $account_holder;
        $this->account_number = $account_number;
        $this->balance = $balance;
        $this->created_at = $created_at;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'account_holder' => strtoupper($this->account_holder),
            'account_number' => $this->account_number,
            'balance' => $this->balance,
            'created_at' => $this->created_at,
        ];
    }

    public function getBalance(): float
    {
        return $this->balance;        
    }

    public function getNumber(): string
    {
        return $this->account_number;
    }

}

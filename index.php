<?php

use App\Account\Account;
use App\Services\TransferService;
use App\Storage\StorageFactory;
use App\Storage\StorageType;
use App\Transaction\Transaction;

require "vendor/autoload.php";
require "config/database.php";
$storageFactory = new StorageFactory;
$db = $storageFactory->make(StorageType::MARIADB);

$message = '';
$error = '';

$account = new Account;
$transaction = new Transaction;

$accounts = $account->all($db);

$transactions = $transaction->get($db, 10);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $from = $_POST['from_account'] ?? '';
    $to = $_POST['to_account'] ?? '';
    $amount = floatval($_POST['amount'] ?? 0);
    $transferService = new TransferService;
    $result = $transferService->transfer($db, $from, $to, $amount);
    
    if ($result['success']) {
        $message = $result['message'];
    } else {
        $error = $result['message'];
    }
}



require "template.php";
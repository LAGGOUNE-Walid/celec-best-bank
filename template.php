<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Bank Transfer</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        h1 { color: #333; margin-bottom: 20px; }
        .card { background: white; padding: 20px; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        select, input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
        button { background: #007bff; color: white; padding: 12px 30px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background: #0056b3; }
        .message { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; font-weight: bold; color: #333; }
        tr:hover { background: #f8f9fa; }
        .balance { font-weight: bold; color: #28a745; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        @media (max-width: 768px) { .grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="container">
        <h1>CELEC Simple Bank Transfer System</h1>
        
        <?php if ($message) { ?>
            <div class="message success"><?php echo htmlspecialchars($message); ?></div>
        <?php } ?>
        
        <?php if ($error) { ?>
            <div class="message error"><?php echo htmlspecialchars($error); ?></div>
        <?php } ?>
        
        <div class="grid">
            <div class="card">
                <h2>Transfer Money</h2>
                <form method="POST">
                    <div class="form-group">
                        <label for="from_account">From Account:</label>
                        <select name="from_account" id="from_account" required>
                            <option value="">Select Account</option>
                            <?php foreach ($accounts as $acc) { ?>
                                <?php $acc = $acc->toArray(); ?>
                                <option value="<?php echo htmlspecialchars($acc['account_number']); ?>">
                                    <?php echo htmlspecialchars($acc['account_number']); ?> - 
                                    <?php echo htmlspecialchars($acc['account_holder']); ?> 
                                    ($<?php echo number_format($acc['balance'], 2); ?>)
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="to_account">To Account:</label>
                        <select name="to_account" id="to_account" required>
                            <option value="">Select Account</option>
                            <?php foreach ($accounts as $acc) { ?>
                                <?php $acc = $acc->toArray(); ?>
                                <option value="<?php echo htmlspecialchars($acc['account_number']); ?>">
                                    <?php echo htmlspecialchars($acc['account_number']); ?> - 
                                    <?php echo  htmlspecialchars($acc['account_holder']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="amount">Amount ($):</label>
                        <input type="number" name="amount" id="amount" step="0.01" min="0.01" required>
                    </div>
                    
                    <button type="submit">Transfer</button>
                </form>
            </div>
            
            <div class="card">
                <h2>All Accounts</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Account</th>
                            <th>Holder</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($accounts as $acc) { ?>
                            <?php $acc = $acc->toArray(); ?>
                            <tr>
                                <td><?php echo htmlspecialchars($acc['account_number']); ?></td>
                                <td><?php echo htmlspecialchars($acc['account_holder']); ?></td>
                                <td class="balance">$<?php echo number_format($acc['balance'], 2); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card">
            <h2>Recent Transactions</h2>
            <table>
                <thead>
                    <tr>
                        <th>From</th>
                        <th>To</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($transactions)) { ?>
                        <tr><td colspan="4" style="text-align: center;">No transactions yet</td></tr>
                    <?php } else { ?>
                        <?php foreach ($transactions as $trans) { ?>
                            <?php $trans = $trans->toArray(); ?>
                            <tr>
                                <td><?php echo htmlspecialchars($trans['from_account']); ?></td>
                                <td><?php echo htmlspecialchars($trans['to_account']); ?></td>
                                <td class="balance">$<?php echo number_format($trans['amount'], 2); ?></td>
                                <td><?php echo htmlspecialchars($trans['transaction_date']); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
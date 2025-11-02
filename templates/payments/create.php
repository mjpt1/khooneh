<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ثبت دستی پرداخت</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>ثبت دستی پرداخت برای شارژ آیتم #<?php echo $chargeItem->id; ?></h1>
        <p><strong>واحد:</strong> <?php echo $chargeItem->unit_number; ?></p>
        <p><strong>مبلغ شارژ:</strong> <?php echo number_format($chargeItem->amount); ?> تومان</p>

        <?php if (isset($_SESSION['errors'])): ?>
            <div class="errors">
                <?php foreach ($_SESSION['errors'] as $fieldErrors) echo implode('<br>', $fieldErrors); ?>
                <?php unset($_SESSION['errors']); ?>
            </div>
        <?php endif; ?>

        <form action="/admin/payments/store/<?php echo $chargeItem->id; ?>" method="POST">
            <?php echo \App\Helpers\Security::csrfField(); ?>
            <div class="form-group">
                <label for="amount">مبلغ پرداخت شده (تومان):</label>
                <input type="number" id="amount" name="amount" value="<?php echo $chargeItem->amount; ?>" required>
            </div>
            <div class="form-group">
                <label for="paid_at">تاریخ پرداخت:</label>
                <input type="date" id="paid_at" name="paid_at" required>
            </div>
            <div class="form-group">
                <label for="transaction_ref">کد رهگیری / مرجع:</label>
                <input type="text" id="transaction_ref" name="transaction_ref">
            </div>
            <button type="submit">ثبت پرداخت</button>
        </form>
    </div>
</body>
</html>

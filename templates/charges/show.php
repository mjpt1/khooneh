<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>جزئیات شارژ</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>جزئیات شارژ: <?php echo htmlspecialchars($charge->title); ?></h1>
        <p><strong>ماه شارژ:</strong> <?php echo htmlspecialchars($charge->charge_month); ?></p>
        <p><strong>مبلغ کل:</strong> <?php echo number_format($charge->total_amount); ?> تومان</p>

        <a href="/admin/buildings/<?php echo $charge->building_id; ?>/charges" class="button">بازگشت</a>

        <h2>ریز حساب هر واحد</h2>
        <table>
            <thead>
                <tr>
                    <th>شماره واحد</th>
                    <th>نام مالک</th>
                    <th>مبلغ شارژ (تومان)</th>
                    <th>وضعیت</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($chargeItems as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item->unit_number); ?></td>
                    <td><?php echo htmlspecialchars($item->owner_name); ?></td>
                    <td><?php echo number_format($item->amount); ?></td>
                    <td>
                        <?php if ($item->status == 'paid'): ?>
                            <span class="status-paid">پرداخت شده</span>
                        <?php else: ?>
                            <span class="status-unpaid">پرداخت نشده</span>
                            <a href="/admin/payments/create/<?php echo $item->id; ?>" class="button-small">ثبت پرداخت</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>گزارش پرداخت‌های معوق</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>گزارش پرداخت‌های معوق</h1>
        <table>
            <thead>
                <tr>
                    <th>عنوان شارژ</th>
                    <th>شماره واحد</th>
                    <th>نام مالک</th>
                    <th>مبلغ (تومان)</th>
                    <th>تاریخ سررسید</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($unpaidItems as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['charge_title']); ?></td>
                    <td><?php echo htmlspecialchars($item['unit_number']); ?></td>
                    <td><?php echo htmlspecialchars($item['owner_name']); ?></td>
                    <td><?php echo number_format($item['amount']); ?></td>
                    <td><?php echo htmlspecialchars($item['due_date']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>گزارش تراز صندوق</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>گزارش تراز صندوق</h1>
        <div class="balance-summary">
            <p><strong>کل درآمد ثبت شده:</strong> <?php echo number_format($totalIncome ?? 0); ?> تومان</p>
            <p><strong>کل هزینه‌ها (شارژهای ایجاد شده):</strong> <?php echo number_format($totalCharges ?? 0); ?> تومان</p>
            <hr>
            <p><strong>تراز نهایی:</strong> <?php echo number_format($balance ?? 0); ?> تومان</p>
        </div>
    </div>
</body>
</html>

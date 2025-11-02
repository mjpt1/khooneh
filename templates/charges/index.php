<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مدیریت شارژ ساختمان <?php echo htmlspecialchars($building->title); ?></title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>مدیریت شارژ ساختمان "<?php echo htmlspecialchars($building->title); ?>"</h1>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <a href="/admin/buildings/<?php echo $building->id; ?>/charges/create" class="button">ایجاد شارژ جدید</a>
        <a href="/admin/buildings" class="button">بازگشت به لیست ساختمان‌ها</a>

        <table>
            <thead>
                <tr>
                    <th>عنوان شارژ</th>
                    <th>ماه شارژ</th>
                    <th>تاریخ سررسید</th>
                    <th>مبلغ کل</th>
                    <th>روش محاسبه</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($charges as $charge): ?>
                <tr>
                    <td><?php echo htmlspecialchars($charge->title); ?></td>
                    <td><?php echo htmlspecialchars($charge->charge_month); ?></td>
                    <td><?php echo htmlspecialchars($charge->due_date); ?></td>
                    <td><?php echo number_format($charge->total_amount); ?></td>
                    <td><?php echo htmlspecialchars($charge->generation_method); ?></td>
                    <td>
                        <a href="/admin/buildings/<?php echo $building->id; ?>/charges/<?php echo $charge->id; ?>">مشاهده جزئیات</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

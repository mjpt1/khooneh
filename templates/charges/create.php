<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ایجاد شارژ جدید</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>ایجاد شارژ جدید برای ساختمان "<?php echo htmlspecialchars($building->title); ?>"</h1>

        <?php if (isset($_SESSION['errors'])): ?>
            <div class="errors">
                <?php foreach ($_SESSION['errors'] as $fieldErrors) echo implode('<br>', $fieldErrors); ?>
                <?php unset($_SESSION['errors']); ?>
            </div>
        <?php endif; ?>

        <form action="/admin/buildings/<?php echo $building->id; ?>/charges/store" method="POST">
            <?php echo \App\Helpers\Security::csrfField(); ?>
            <div class="form-group">
                <label for="title">عنوان شارژ:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="charge_month">ماه شارژ:</label>
                <input type="month" id="charge_month" name="charge_month" required>
            </div>
            <div class="form-group">
                <label for="due_date">تاریخ سررسید:</label>
                <input type="date" id="due_date" name="due_date" required>
            </div>
            <div class="form-group">
                <label for="total_amount">مبلغ کل (تومان):</label>
                <input type="number" id="total_amount" name="total_amount" required>
            </div>
            <div class="form-group">
                <label for="generation_method">روش محاسبه:</label>
                <select id="generation_method" name="generation_method" required>
                    <option value="fixed">ثابت برای هر واحد</option>
                    <option value="by_area">بر اساس متراژ</option>
                    <option value="by_people">بر اساس تعداد ساکنین</option>
                </select>
            </div>
            <button type="submit">ایجاد و محاسبه شارژ</button>
        </form>
    </div>
</body>
</html>

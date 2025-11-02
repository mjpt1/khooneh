<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>افزودن واحد جدید</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>افزودن واحد به ساختمان "<?php echo htmlspecialchars($building->title); ?>"</h1>

        <?php if (isset($_SESSION['errors'])): ?>
            <div class="errors">
                <?php foreach ($_SESSION['errors'] as $fieldErrors) echo implode('<br>', $fieldErrors); ?>
                <?php unset($_SESSION['errors']); ?>
            </div>
        <?php endif; ?>

        <form action="/admin/buildings/<?php echo $building->id; ?>/units/store" method="POST">
            <?php echo \App\Helpers\Security::csrfField(); ?>
            <div class="form-group">
                <label for="number">شماره واحد:</label>
                <input type="text" id="number" name="number" required>
            </div>
            <div class="form-group">
                <label for="floor">طبقه:</label>
                <input type="number" id="floor" name="floor" required>
            </div>
            <div class="form-group">
                <label for="block">بلوک:</label>
                <input type="text" id="block" name="block">
            </div>
            <div class="form-group">
                <label for="area">متراژ (متر مربع):</label>
                <input type="number" step="0.01" id="area" name="area" required>
            </div>
            <div class="form-group">
                <label for="people_count">تعداد ساکنین:</label>
                <input type="number" id="people_count" name="people_count">
            </div>
            <div class="form-group">
                <label for="owner_name">نام مالک:</label>
                <input type="text" id="owner_name" name="owner_name">
            </div>
            <button type="submit">ایجاد واحد</button>
        </form>
    </div>
</body>
</html>

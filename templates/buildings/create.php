<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>افزودن ساختمان جدید</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>افزودن ساختمان جدید</h1>

        <?php if (isset($_SESSION['errors'])): ?>
            <div class="errors">
                <?php foreach ($_SESSION['errors'] as $fieldErrors) echo implode('<br>', $fieldErrors); ?>
                <?php unset($_SESSION['errors']); ?>
            </div>
        <?php endif; ?>

        <form action="/admin/buildings/store" method="POST">
            <?php echo \App\Helpers\Security::csrfField(); ?>
            <div class="form-group">
                <label for="title">عنوان ساختمان:</label>
                <input type="text" id="title" name="title" value="<?php echo $_SESSION['old']['title'] ?? ''; unset($_SESSION['old']['title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="address">آدرس:</label>
                <textarea id="address" name="address" required><?php echo $_SESSION['old']['address'] ?? ''; unset($_SESSION['old']['address']); ?></textarea>
            </div>
            <button type="submit">ایجاد ساختمان</button>
        </form>
    </div>
</body>
</html>

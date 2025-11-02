<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ایجاد تیکت جدید</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>ایجاد تیکت جدید</h1>

        <?php if (isset($_SESSION['errors'])): ?>
            <div class="errors">
                <?php foreach ($_SESSION['errors'] as $fieldErrors) echo implode('<br>', $fieldErrors); ?>
                <?php unset($_SESSION['errors']); ?>
            </div>
        <?php endif; ?>

        <form action="/tickets/store" method="POST" enctype="multipart/form-data">
            <?php echo \App\Helpers\Security::csrfField(); ?>
            <div class="form-group">
                <label for="title">عنوان تیکت:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="content">متن درخواست:</label>
                <textarea id="content" name="content" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="attachment">پیوست (اختیاری):</label>
                <input type="file" id="attachment" name="attachment">
            </div>
            <button type="submit">ارسال تیکت</button>
        </form>
    </div>
</body>
</html>

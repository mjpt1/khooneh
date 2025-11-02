<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>افزودن خبر جدید</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>افزودن خبر جدید</h1>
        <form action="/news/store" method="POST">
            <?php echo \App\Helpers\Security::csrfField(); ?>
            <div class="form-group">
                <label for="title">عنوان خبر:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="content">متن خبر:</label>
                <textarea id="content" name="content" rows="10" required></textarea>
            </div>
            <button type="submit">افزودن</button>
        </form>
    </div>
</body>
</html>

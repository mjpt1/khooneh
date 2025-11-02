<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>افزودن قانون جدید</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>افزودن قانون جدید</h1>
        <form action="/rules/store" method="POST">
            <?php echo \App\Helpers\Security::csrfField(); ?>
            <div class="form-group">
                <label for="title">عنوان قانون:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="content">متن قانون:</label>
                <textarea id="content" name="content" rows="10" required></textarea>
            </div>
            <button type="submit">افزودن</button>
        </form>
    </div>
</body>
</html>

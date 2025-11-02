<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود به سیستم مدیریت ساختمان</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="auth-container">
        <h1>ورود به حساب کاربری</h1>

        <?php if (isset($_SESSION['errors'])): ?>
            <div class="errors">
                <?php foreach ($_SESSION['errors'] as $fieldErrors): ?>
                    <?php foreach ($fieldErrors as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>

        <form action="/login" method="POST">
            <?php echo \App\Helpers\Security::csrfField(); ?>
            <div class="form-group">
                <label for="username">نام کاربری یا ایمیل:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">رمز عبور:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">ورود</button>
        </form>
        <p>حساب کاربری ندارید؟ <a href="/register">ثبت‌نام کنید</a></p>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ثبت‌نام در سیستم مدیریت ساختمان</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="auth-container">
        <h1>ایجاد حساب کاربری جدید</h1>

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

        <?php $old = $_SESSION['old'] ?? []; unset($_SESSION['old']); ?>

        <form action="/register" method="POST">
            <?php echo \App\Helpers\Security::csrfField(); ?>
            <div class="form-group">
                <label for="full_name">نام کامل:</label>
                <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($old['full_name'] ?? '', ENT_QUOTES); ?>" required>
            </div>
            <div class="form-group">
                <label for="username">نام کاربری:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($old['username'] ?? '', ENT_QUOTES); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">ایمیل:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($old['email'] ?? '', ENT_QUOTES); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">رمز عبور:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">تکرار رمز عبور:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>
            <button type="submit">ثبت‌نام</button>
        </form>
        <p>قبلاً ثبت‌نام کرده‌اید؟ <a href="/login">وارد شوید</a></p>
    </div>
</body>
</html>

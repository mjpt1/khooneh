<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>داشبورد کاربری</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>داشبورد کاربری</h1>
        <p>خوش آمدید، <?php echo htmlspecialchars(\App\Helpers\Auth::user()->full_name); ?>!</p>

        <div class="dashboard-grid">
            <div class="dashboard-module">
                <h2>آخرین شارژها</h2>
                <ul>
                    <?php foreach (array_slice($latestCharges, 0, 5) as $charge): ?>
                        <li>
                            <?php echo htmlspecialchars($charge->charge_title); ?> -
                            <strong><?php echo number_format($charge->amount); ?> تومان</strong> -
                            وضعیت: <?php echo $charge->status == 'paid' ? 'پرداخت شده' : 'پرداخت نشده'; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="dashboard-module">
                <h2>اخبار و اطلاعیه‌ها</h2>
                <ul>
                    <?php foreach (array_slice($latestNews, 0, 3) as $newsItem): ?>
                        <li><a href="/news"><?php echo htmlspecialchars($newsItem->title); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="dashboard-module">
                <h2>نظرسنجی‌های فعال</h2>
                <ul>
                    <?php foreach ($activePolls as $poll): ?>
                        <li><a href="/polls"><?php echo htmlspecialchars($poll->question); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="dashboard-module">
                <h2>دسترسی سریع</h2>
                <ul>
                    <li><a href="/tickets">مشاهده تیکت‌ها</a></li>
                    <li><a href="/rules">قوانین ساختمان</a></li>
                    <li><a href="/chat">گفتگو با مدیر</a></li>
                    <li><a href="/logout">خروج از حساب</a></li>
                </ul>
            </div>
        </div>

        <?php if (\App\Helpers\Auth::hasRole('admin')): ?>
        <div class="admin-panel-link">
            <h2>پنل مدیریت</h2>
            <a href="/admin/buildings" class="button">ورود به پنل مدیریت</a>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>

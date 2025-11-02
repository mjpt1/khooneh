<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>اخبار و اطلاعیه‌ها</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>اخبار و اطلاعیه‌ها</h1>

        <?php if (\App\Helpers\Auth::hasRole('admin')): ?>
            <a href="/news/create" class="button">افزودن خبر جدید</a>
        <?php endif; ?>

        <div class="news-list">
            <?php foreach ($news as $newsItem): ?>
                <div class="news-item">
                    <h2><?php echo htmlspecialchars($newsItem->title); ?></h2>
                    <p><?php echo nl2br(htmlspecialchars($newsItem->content)); ?></p>
                    <small>ارسال شده توسط: <?php echo htmlspecialchars($newsItem->author_name); ?> در تاریخ <?php echo $newsItem->created_at; ?></small>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>

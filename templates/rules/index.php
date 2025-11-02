<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>قوانین ساختمان</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>قوانین ساختمان</h1>

        <form action="/rules" method="GET">
            <input type="text" name="q" placeholder="جستجو در قوانین..." value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>">
            <button type="submit">جستجو</button>
        </form>

        <?php if (\App\Helpers\Auth::hasRole('admin')): ?>
            <a href="/rules/create" class="button">افزودن قانون جدید</a>
        <?php endif; ?>

        <div class="rules-list">
            <?php foreach ($rules as $rule): ?>
                <div class="rule-item">
                    <h2><?php echo htmlspecialchars($rule->title); ?></h2>
                    <p><?php echo nl2br(htmlspecialchars($rule->content)); ?></p>
                    <?php if (\App\Helpers\Auth::hasRole('admin')): ?>
                        <div class="admin-actions">
                            <a href="/rules/<?php echo $rule->id; ?>/edit">ویرایش</a>
                            <a href="/rules/<?php echo $rule->id; ?>/delete" onclick="return confirm('آیا مطمئن هستید؟')">حذف</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>

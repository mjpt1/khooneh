<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>نظرسنجی‌ها</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>نظرسنجی‌های فعال</h1>
        <?php foreach ($polls as $poll): ?>
            <div class="poll-item">
                <h2><?php echo htmlspecialchars($poll->question); ?></h2>
                <form action="/polls/<?php echo $poll->id; ?>/vote" method="POST">
                    <?php foreach (json_decode($poll->options) as $index => $option): ?>
                        <div class="option">
                            <input type="radio" name="option" value="<?php echo $index; ?>" id="poll<?php echo $poll->id; ?>opt<?php echo $index; ?>">
                            <label for="poll<?php echo $poll->id; ?>opt<?php echo $index; ?>"><?php echo htmlspecialchars($option); ?></label>
                        </div>
                    <?php endforeach; ?>
                    <button type="submit">ثبت رأی</button>
                </form>
                <a href="/polls/<?php echo $poll->id; ?>/results">مشاهده نتایج</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>

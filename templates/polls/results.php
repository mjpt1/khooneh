<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>نتایج نظرسنجی</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>نتایج نظرسنجی</h1>
        <h2><?php echo htmlspecialchars($poll->question); ?></h2>

        <ul class="results-list">
            <?php
            $options = json_decode($poll->options);
            $totalVotes = array_sum($results);
            foreach ($options as $index => $option):
                $voteCount = $results[$index] ?? 0;
                $percentage = ($totalVotes > 0) ? ($voteCount / $totalVotes) * 100 : 0;
            ?>
                <li>
                    <strong><?php echo htmlspecialchars($option); ?>:</strong>
                    <span><?php echo $voteCount; ?> رأی (<?php echo round($percentage, 2); ?>%)</span>
                    <div class="progress-bar">
                        <div class="progress" style="width: <?php echo $percentage; ?>%;"></div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <a href="/polls">بازگشت به لیست نظرسنجی‌ها</a>
    </div>
</body>
</html>

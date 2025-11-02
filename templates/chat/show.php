<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>گفتگو با <?php echo htmlspecialchars($chatWithUser->full_name); ?></title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>گفتگو با <?php echo htmlspecialchars($chatWithUser->full_name); ?></h1>

        <div class="chat-box">
            <?php foreach ($messages as $message): ?>
                <div class="message <?php echo ($message->sender_id == \App\Helpers\Auth::id()) ? 'sent' : 'received'; ?>">
                    <p><strong><?php echo htmlspecialchars($message->sender_name); ?>:</strong></p>
                    <p><?php echo nl2br(htmlspecialchars($message->content)); ?></p>
                    <span class="timestamp"><?php echo $message->created_at; ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <form action="/chat/store/<?php echo $chatWithUser->id; ?>" method="POST" class="chat-form">
            <textarea name="content" placeholder="پیام خود را بنویسید..." required></textarea>
            <button type="submit">ارسال</button>
        </form>
    </div>
</body>
</html>

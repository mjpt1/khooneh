<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>سیستم تیکتینگ</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>سیستم تیکتینگ</h1>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <a href="/tickets/create" class="button">ایجاد تیکت جدید</a>

        <table>
            <thead>
                <tr>
                    <th>عنوان</th>
                    <?php if (\App\Helpers\Auth::hasRole('admin') || \App\Helpers\Auth::hasRole('manager')): ?>
                        <th>ارسال کننده</th>
                    <?php endif; ?>
                    <th>وضعیت</th>
                    <th>تاریخ ایجاد</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tickets as $ticket): ?>
                <tr>
                    <td><?php echo htmlspecialchars($ticket->title); ?></td>
                    <?php if (\App\Helpers\Auth::hasRole('admin') || \App\Helpers\Auth::hasRole('manager')): ?>
                        <td><?php echo htmlspecialchars($ticket->user_name); ?></td>
                    <?php endif; ?>
                    <td>
                        <?php if (\App\Helpers\Auth::hasRole('admin') || \App\Helpers\Auth::hasRole('manager')): ?>
                            <form action="/tickets/<?php echo $ticket->id; ?>/status" method="POST" style="display:inline;">
                                <select name="status" onchange="this.form.submit()">
                                    <option value="open" <?php if ($ticket->status == 'open') echo 'selected'; ?>>باز</option>
                                    <option value="in_progress" <?php if ($ticket->status == 'in_progress') echo 'selected'; ?>>در حال بررسی</option>
                                    <option value="closed" <?php if ($ticket->status == 'closed') echo 'selected'; ?>>بسته شده</option>
                                </select>
                            </form>
                        <?php else: ?>
                            <?php echo htmlspecialchars($ticket->status); ?>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($ticket->created_at); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

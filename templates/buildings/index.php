<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مدیریت ساختمان‌ها</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>مدیریت ساختمان‌ها</h1>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <a href="/admin/buildings/create" class="button">افزودن ساختمان جدید</a>

        <table>
            <thead>
                <tr>
                    <th>عنوان</th>
                    <th>آدرس</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($buildings as $building): ?>
                <tr>
                    <td><?php echo htmlspecialchars($building->title); ?></td>
                    <td><?php echo htmlspecialchars($building->address); ?></td>
                    <td>
                        <a href="/admin/buildings/<?php echo $building->id; ?>/units">مدیریت واحدها</a>
                        <a href="/admin/buildings/<?php echo $building->id; ?>/edit">ویرایش</a>
                        <a href="/admin/buildings/<?php echo $building->id; ?>/delete" onclick="return confirm('آیا مطمئن هستید؟')">حذف</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

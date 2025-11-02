<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مدیریت واحدهای ساختمان <?php echo htmlspecialchars($building->title); ?></title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>مدیریت واحدهای ساختمان "<?php echo htmlspecialchars($building->title); ?>"</h1>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <a href="/admin/buildings/<?php echo $building->id; ?>/units/create" class="button">افزودن واحد جدید</a>
        <a href="/admin/buildings" class="button">بازگشت به لیست ساختمان‌ها</a>

        <table>
            <thead>
                <tr>
                    <th>بلوک</th>
                    <th>طبقه</th>
                    <th>شماره واحد</th>
                    <th>متراژ</th>
                    <th>تعداد ساکنین</th>
                    <th>نام مالک</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($units as $unit): ?>
                <tr>
                    <td><?php echo htmlspecialchars($unit->block); ?></td>
                    <td><?php echo htmlspecialchars($unit->floor); ?></td>
                    <td><?php echo htmlspecialchars($unit->number); ?></td>
                    <td><?php echo htmlspecialchars($unit->area); ?></td>
                    <td><?php echo htmlspecialchars($unit->people_count); ?></td>
                    <td><?php echo htmlspecialchars($unit->owner_name); ?></td>
                    <td>
                        <a href="/admin/buildings/<?php echo $building->id; ?>/units/<?php echo $unit->id; ?>/edit">ویرایش</a>
                        <a href="/admin/buildings/<?php echo $building->id; ?>/units/<?php echo $unit->id; ?>/delete" onclick="return confirm('آیا مطمئن هستید؟')">حذف</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

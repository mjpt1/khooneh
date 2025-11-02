<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ویرایش ساختمان</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>ویرایش ساختمان</h1>

        <?php if (isset($_SESSION['errors'])): ?>
            <div class="errors">
                <?php foreach ($_SESSION['errors'] as $fieldErrors) echo implode('<br>', $fieldErrors); ?>
                <?php unset($_SESSION['errors']); ?>
            </div>
        <?php endif; ?>

        <form action="/admin/buildings/<?php echo $building->id; ?>/update" method="POST">
            <?php echo \App\Helpers\Security::csrfField(); ?>
            <div class="form-group">
                <label for="title">عنوان ساختمان:</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($building->title); ?>" required>
            </div>
            <div class="form-group">
                <label for="address">آدرس:</label>
                <textarea id="address" name="address" required><?php echo htmlspecialchars($building->address); ?></textarea>
            </div>
            <button type="submit">ویرایش</button>
        </form>
    </div>
</body>
</html>

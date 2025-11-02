<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ویرایش قانون</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>ویرایش قانون</h1>
        <form action="/rules/<?php echo $rule->id; ?>/update" method="POST">
            <?php echo \App\Helpers\Security::csrfField(); ?>
            <div class="form-group">
                <label for="title">عنوان قانون:</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($rule->title); ?>" required>
            </div>
            <div class="form-group">
                <label for="content">متن قانون:</label>
                <textarea id="content" name="content" rows="10" required><?php echo htmlspecialchars($rule->content); ?></textarea>
            </div>
            <button type="submit">ویرایش</button>
        </form>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Spell Builder</title>
    <meta name="author" content="Jake Bassett">
    <meta name="description" content="Spell Builder Index">
    <link href="../css/spellbuilder.css" rel="stylesheet" type="text/css" media="screen">
</head>


<body>
    <header>
    <?php include '../common/header.php'; ?>
    </header>
    <main>
        <?php
        if (isset($view)) {
            echo $view;
        } ?>

    </main>
    <footer>
    <?php include '../common/footer.php'; ?>
    </footer>

</body>

</html>
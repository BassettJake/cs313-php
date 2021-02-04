<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Spell</title>
    <meta name="author" content="Jake Bassett">
    <meta name="description" content="Spell Builder Create">
    <link href="../Spellbuilder/css/spellbuilder.css" rel="stylesheet" type="text/css" media="screen">
</head>


<body>
    <header>
        <?php include '../Spellbuilder/common/header.php'; ?>
    </header>
    <main>
        <?php
        if (isset($create)) {
            echo $create;
        }
        if (isset($message)) {
            echo $message;
        }
        ?>

    </main>
    <footer>
        <?php include '../Spellbuilder/common/footer.php'; ?>
    </footer>

</body>

</html>
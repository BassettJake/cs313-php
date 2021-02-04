<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Character Spells</title>
    <meta name="author" content="Jake Bassett">
    <meta name="description" content="Spell Builder List">
    <link href="../Spellbuilder/css/spellbuilder.css" rel="stylesheet" type="text/css" media="screen">
</head>


<body>
    <header>
        <?php include '../Spellbuilder/common/header.php'; ?>
    </header>
    <main>
        <?php
        if (isset($searchForm)) {
            echo $searchForm;
        }
        if (isset($missingSpells)) {
            echo $missingSpells;
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
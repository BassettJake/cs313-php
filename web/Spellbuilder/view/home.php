<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <meta name="author" content="Jake Bassett">
    <meta name="description" content="Spell Builder Home">
    <link href="../Spellbuilder/css/spellbuilder.css" rel="stylesheet" type="text/css" media="screen">
</head>

<body>
    <header>
        <?php include '../Spellbuilder/common/header.php'; ?>
    </header>
    <main>
    <section id="homeNav">
        <button class="button goldButton" onclick="window.location.href='/Spellbuilder/index.php?action=characters';">Characters</button>
        <button class="button goldButton" onclick="window.location.href='/Spellbuilder/index.php?action=create';">Create Spell</button>
        <button class="button goldButton" onclick="window.location.href='/Spellbuilder/index.php?action=view';">View Spells</button>
    </section>
    </main>
    <footer>
        <?php include '../Spellbuilder/common/footer.php'; ?>
    </footer>
   
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../03Prove/03_Prove.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../03Prove/03_Prove.js"></script>
    <title>Checkout</title>
</head>

<body>
    <?php include '../03Prove/03_Prove_Header.php'; ?>
    <main>
        <h1 id="total">Total - $
            <?php
            if (isset($totalPrice)) {
                echo $totalPrice;
            }
            ?>
        </h1>
        <hr>
        <?php
        if (isset($addressForm)) {
            echo $addressForm;
        }
        ?>
    </main>

</body>

</html>
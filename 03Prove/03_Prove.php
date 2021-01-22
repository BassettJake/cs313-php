<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../03Prove/03_Prove.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../03Prove/03_Prove.js"></script>
    <title>Home</title>
</head>

<body>
    <?php include '../03Prove/03_Prove_Header.php'; ?>
    <main>

        <?php if (isset($alert)) {
            echo $alert;
        }

        ?>
        <section id="items">

            <?php

$i = 0;
            foreach ($items as $item) {
                $titleName = explode("-",$item->name);
                echo '<form class="itemForm" action="../03Prove/index.php" method="post">' .
                    '<h1 class="itemTitle">' . 'Ball (' . ucfirst($titleName[1]) . ')' . '</h1>' .
                    '<span class="price"> $' . $item->price . '</span>' .
                    '<img src="../03Prove/images/' . strtolower($item->name) . '.png" alt="Image of "' . $item->name . ' class="itemImage">' .
                    '<section class="formInput">' .
                    '<label class="quantityLabel" for="quantity_' . $i . '">Quantity</label>' .
                    '<input type="number" id="quantity_' . $i . '" min="1" max="50" name="quantity" class="quantity" value="1">' .
                    '<input type="hidden" id="itemIdName" name="itemIdName" value="' . $item->name . '_' . $item->id . '">' .
                    '<input type="submit" class="addToCartButton" name="submit" value="Add to Cart">' .
                    '<input type="hidden" name="action" value="addToCart">' .
                    '</section>' .
                    '</form>';
                $i++;
            }

            ?>

        </section>
        </form>
    </main>
</body>

</html>
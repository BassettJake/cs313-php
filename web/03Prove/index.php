<?php

session_start();

class Product
{
    public $name;
    public $id;
    public $price;
}

$itemOne = new Product();
$itemOne->name = 'ball-red';
$itemOne->id = 0;
$itemOne->price = 4;

$itemTwo = new Product();
$itemTwo->name = 'ball-blue';
$itemTwo->id = 1;
$itemTwo->price = 2;

$itemThree = new Product();
$itemThree->name = 'ball-green';
$itemThree->id = 2;
$itemThree->price = 5;

$itemFour = new Product();
$itemFour->name = 'ball-yellow';
$itemFour->id = 3;
$itemFour->price = 10;

$items = array($itemOne, $itemTwo, $itemThree, $itemFour);

//display the number in cart in real time
$cartNum = 0;

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

//the name of the var for storing total items in cart
$numCartItems = "numCartItems";

$pageTitle = "Shop";

switch ($action) {
    case 'addToCart':

        $quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);
        $itemIdName = filter_input(INPUT_POST, 'itemIdName', FILTER_SANITIZE_STRING);

        //check if this item type has a var
        //if it does, set the value to its current value + the quantity
        if (isset($_SESSION[$itemIdName])) {
            $numItems = $_SESSION[$itemIdName];
            $_SESSION[$itemIdName] = $numItems + $quantity;
        }
        //set the value to the quantity
        else {
            $_SESSION[$itemIdName] = $quantity;
        }
        //add quantity to the numCartItems
        $_SESSION[$numCartItems] = (int)$_SESSION[$numCartItems] + $quantity;
        //display the number in real time
        $cartNum = $_SESSION[$numCartItems];

        $pageTitle = "Browse Items";
        include '../03Prove/03_Prove.php';
        break;

    case 'viewCart':

        $cartNum = (int)$_SESSION[$numCartItems];

        $empty = true;
        $html = "<section id='itemsInCart'>";
        foreach ($items as $item) {
            if (isset($_SESSION[$item->name . '_' . $item->id])) {
                $numItem = (int)$_SESSION[$item->name . '_' . $item->id];
                for ($i = 0; $i < $numItem; $i++) {
                    $empty = false;
                    $titleName = explode("-",$item->name);
                    $html .= '<form class="itemForm" action="../03Prove/index.php" method="post">' .
                        '<section class="titleArea">' .
                        '<h1 class="itemTitle">' .
                        'Ball (' . ucfirst($titleName[1]) . ')' .
                        '</h1>' .
                        '</section>' .
                        '<span class="price"> $'
                        . $item->price .
                        '</span>' .
                        '<img src="../03Prove/images/' . strtolower($item->name) . '.png" alt="Image of "' . $item->name . ' class="itemImage">' .
                        '<section class="formInput">' .
                        '<input type="hidden" id="itemIdName" name="itemIdName" value="' . $item->name . '_' . $item->id . '">' .
                        '<input type="submit" class="updateCartButton" name="submit" value="Remove From Cart">' .
                        '<input type="hidden" name="action" value="removeItem">' .
                        '</section>' .
                        '</form>';
                }
            }
        }

        if ($empty == true) {
            $html .= "Your Cart is Empty";
        } else {
            $checkout = "<a href='../03Prove/index.php?action=proceedCheckout' class='checkoutButton'>Proceed to Checkout</a>";
        }

        $html .= "</section>";
        $pageTitle = "Your Cart";
        include '../03Prove/03_Prove_Cart.php';
        break;

    case 'removeItem':

        $_SESSION[$numCartItems]  = (int)$_SESSION[$numCartItems] - 1;
        $cartNum = (int)$_SESSION[$numCartItems];

        //remove the selected item
        $itemIdName = filter_input(INPUT_POST, 'itemIdName', FILTER_SANITIZE_STRING);

        if (isset($_SESSION[$itemIdName])) {
            $_SESSION[$itemIdName] = $_SESSION[$itemIdName] - 1;
        }

        $empty = true;
        $html = "<section id='itemsInCart'>";

        foreach ($items as $item) {
            if (isset($_SESSION[$item->name . '_' . $item->id])) {
                $numItem = (int)$_SESSION[$item->name . '_' . $item->id];
                for ($i = 0; $i < $numItem; $i++) {
                    $empty = false;
                    $titleName = explode("-",$item->name);
                    $html .= '<form class="itemForm" action="../03Prove/index.php" method="post">' .
                        '<section class="titleArea">' .
                        '<h1 class="itemTitle">' . 'Ball (' . ucfirst($titleName[1]) . ')' . '</h1>' . "</section>" . '<span class="price"> $' . $item->price . '</span>' .
                        '<img src="../03Prove/images/' . strtolower($item->name) . '.png" alt="Image of "' . $item->name . ' class="itemImage">' .
                        '<section class="formInput">' .
                        '<input type="hidden" id="itemIdName" name="itemIdName" value="' . $item->name . '_' . $item->id . '">' .
                        '<input type="submit" class="updateCartButton" name="submit" value="Remove From Cart">' .
                        '<input type="hidden" name="action" value="removeItem">' .
                        '</section>' .
                        '</form>';
                }
            }
        }

        if ($empty == true) {
            $html .= "Your Cart is Empty";
        } else {
            $checkout = "<a href='../03Prove/index.php?action=proceedCheckout' class='checkoutButton'>Proceed to Checkout</a>";
        }

        $html .= "</section>";
        $pageTitle = "Your Cart";
        include '../03Prove/03_Prove_Cart.php';
        break;

    case "proceedCheckout":

        $cartNum = (int)$_SESSION[$numCartItems];

        $totalPrice = 0;

        foreach ($items as $item) {
            if (isset($_SESSION[$item->name . '_' . $item->id])) {
                $numItem = (int)$_SESSION[$item->name . '_' . $item->id];
                for ($i = 0; $i < $numItem; $i++) {
                    $totalPrice = (int)((int)$totalPrice + (int)$item->price);
                }
            }
        }

        $addressForm = '<form class="addressForm" action="../03Prove/index.php" method="post">' .
            '<label class="addressLabel" for="firstName">First Name</label>' .
            '<input class="addressInput" type="text" id="firstName" name="firstName" value="" required>' .
            '<label class="addressLabel" for="lastName">Last Name</label>' .
            '<input class="addressInput" type="text" id="lastName" name="lastName" value="" required>' .
            '<label class="addressLabel" for="email">Email</label>' .
            '<input class="addressInput" type="email" id="email" name="email" value="" required>' .
            '<label class="addressLabel" for="street">Street</label>' .
            '<input class="addressInput" type="text" id="street" name="street" value="" required>' .
            '<label class="addressLabel" for="city">City</label>' .
            '<input class="addressInput" type="text" id="city" name="city" value="" required>' .
            '<label class="addressLabel" for="state">State</label>' .
            '<input class="addressInput" type="text" id="state" name="state" value="" required>' .
            '<label class="addressLabel" for="zip">Zip</label>' .
            '<input class="addressInput" maxlength="10" type="text" id="zip" name="zip" value="" required>' .
            '<input type="submit" class="confirmPayment" name="submit" value="Confirm Payment">' .
            '<input type="hidden" name="action" value="confirmPayment">';
        $pageTitle = "Complete Your Checkout";
        include '../03Prove/03_Prove_Checkout.php';
        break;

    case "confirmPayment":

        $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
        $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        $street = filter_input(INPUT_POST, 'street', FILTER_SANITIZE_STRING);
        $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
        $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
        $zip = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_NUMBER_INT);


        //reset num items in cart to 0
        $_SESSION[$numCartItems] = 0;
        //display the number in real time
        $cartNum = 0;



        $html = '<section id="confirmationInfo">';
        $html .= '<section id="confirmationItemsWrapper">';
        foreach ($items as $item) {
            if (isset($_SESSION[$item->name . '_' . $item->id])) {
                $numItem = (int)$_SESSION[$item->name . '_' . $item->id];
                for ($i = 0; $i < $numItem; $i++) {
                    $titleName = explode("-",$item->name);
                    $html .= '<section class="confirmationItems">' .
                        '<section class="titleArea">' .
                        '<h1 class="itemTitle">' . 'Ball (' . ucfirst($titleName[1]) . ')' . '</h1>' . "</section>" . '<span class="price"> $' . $item->price . '</span>' .
                        '<img src="../03Prove/images/' . strtolower($item->name) . '.png" alt="Image of "' . $item->name . ' class="itemImage">' .
                        '</section>';
                }
            }
        }

        $html .= "</section>";
        $addressInfo = '<section id="billing"><h1 id="billingTo">Billing To:</h1><address id="confirmationAddress">' .
            '<h2 id="fullName">' . $firstName . ' ' . $lastName . '</h2>' .
            $email . '<br><span id="physicalAddress">' . $street . '<br>' . $city . ', ' . $state . ' ' . $zip .
            '</span></address></section>';

        $html .= $addressInfo;
        $html .= "</section>";

        //reset the item also to 0;
        foreach ($items as $item) {
            if (isset($_SESSION[$item->name . '_' . $item->id])) {
                $_SESSION[$item->name . '_' . $item->id] =  0;
            }
        }

        $pageTitle = "Thank You!";
        include '../03Prove/03_Prove_Confirmed.php';
        break;


    default:

        if (!isset($_SESSION[$numCartItems])) {
            $_SESSION[$numCartItems] = 0;
        } else {
            $cartNum = $_SESSION[$numCartItems];
        }


        $pageTitle = "Browse Items";
        include '../03Prove/03_Prove.php';
        break;
}

<header>
    <section id="cart">
        <a href="../03Prove/index.php?action=viewCart" class="cartLink">
        <img src="../03Prove/images/cart.png" alt="Shopping Cart Icon" class="cartImg">
        <span id="cartItems"><?php if (isset($_SESSION[$numCartItems])) {

                                            echo $cartNum;
                                        } else {
                                            echo "0";
                                        } ?></span></a>
    </section>
    <a href="../03Prove/index.php" id="logo"><img src="../03Prove/images/siteLogo.png" alt="Site Logo" class="headImg"></a>
    <h1 id="pageHeader"><?php echo $pageTitle; ?></h1>
</header>
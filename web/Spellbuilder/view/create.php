<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Spell</title>
    <meta name="author" content="Jake Bassett">
    <meta name="description" content="Spell Builder Create">
    <link href="../Spellbuilder/css/spellbuilder.css" rel="stylesheet" type="text/css" media="screen">
    <script type="text/javascript" src="../Spellbuilder/scripts/scripts.js"></script>
</head>


<body>
    <header>
        <?php include '../Spellbuilder/common/header.php'; ?>
    </header>
    <main>
        <?php
        if (isset($message)) {
            echo $message;
        } ?>

        <section class="createWrapper">

            <section class="spellNameInput">
                <input type="text" class="inputField" id="placeholderName" name="placeholderName" placeholder="Spell Name" value="<?php if (isset($name)) {
                                                                                                                                        echo $name;
                                                                                                                                    } ?>">
            </section>

            <section class="top">
                <section class="dropButton">
                    <section class="button goldButton selectCaster">Caster Type
                        <section class="dropDown">
                            <button type="button" class="button greyButton typeButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="full">Full Caster</button>
                            <button type="button" class="button greyButton typeButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="half">Half Caster</button>
                            <button type="button" class="button greyButton typeButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="melee">Melee Caster</button>
                        </section>
                    </section>
                    <section class="attrTextWrapper">
                        <span class="attrText" id="typeButtonSelectedText">
                            <?php
                            if (isset($casterType)) {
                                echo $casterType;
                            } ?>
                        </span>
                    </section>
                </section>

                <section class="selectCreate">
                    <form class="createForm" action="../Spellbuilder/index.php" method="post">
                        <input type="hidden" id="name" name="name" value="<?php if (isset($name)) {
                                                                                echo $name;
                                                                            } ?>">
                        <input type="hidden" id="desc" name="desc" value="<?php if (isset($desc)) {
                                                                                echo $desc;
                                                                            } ?>">
                        <input type="hidden" id="casterType" name="casterType" value="
    <?php
    if (isset($casterType)) {
        echo $casterType;
    } ?>
    ">
                        <input type="hidden" id="cost" name="cost" value="
    <?php if (isset($cost)) {
        echo $cost;
    } ?>">
                        <input type="hidden" id="casttime" name="casttime" value="<?php if (isset($castTime)) {
                                                                                        echo $castTime;
                                                                                    } ?>">
                        <input type="hidden" id="effects" name="effects" value="<?php if (isset($effects)) {
                                                                                    echo $effects;
                                                                                } ?>">
                        <input type="hidden" id="durations" name="durations" value="<?php if (isset($durations)) {
                                                                                        echo $durations;
                                                                                    } ?>">
                        <input type="hidden" id="targets" name="targets" value="<?php if (isset($targets)) {
                                                                                    echo $targets;
                                                                                } ?>">
                        <input type="hidden" id="range" name="range" value="<?php if (isset($range)) {
                                                                                echo $range;
                                                                            } ?>">
                        <input type="hidden" id="multi" name="multi" value="<?php if (isset($multi)) {
                                                                                echo $multi;
                                                                            } ?>">
                                <?php if(!(isset($edit))){
                                echo '<input id="spellCreateButton" class="button goldButton" type="submit" value="Create Spell">';
                                echo '<input type="hidden" name="action" value="createSpell">';
                                }
                                else{
                                    echo '<input id="spellCreateButton" class="button goldButton" type="submit" value="Edit Spell">';
                                    echo '<input type="hidden" name="action" value="editCreateSpell">';
                                    echo $edit;
                                }
                                                                                ?>

                </section>

                <section class="dropButton">
                    <section class="prelimCost">
                        <button type="button" id="costButton" class="button goldButton" value="cost">Cost</button>
                    </section>
                    <section class="attrTextWrapper">
                        <span class="attrText" id="costButtonSelectedText"><?php if (isset($cost)) {
                                                                                echo $cost;
                                                                            } ?></span>
                    </section>
                </section>
            </section>

            <section class="spellDescInput">
                <textarea class="inputField" id="placeholderDesc" name="placeholderDesc" placeholder="Spell Description"><?php if (isset($desc)) {
                                                                                                                                echo $desc;
                                                                                                                            } ?></textarea>
            </section>

            <section class="mid">
                <section class="dropButton">
                    <section class="button blueButton selectCast">Cast Time
                        <section class="dropDown">
                            <button type="button" class="button greyButton castButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="instantCast">Instant</button>
                            <button type="button" class="button greyButton castButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="3SecCast">3 Seconds</button>
                            <button type="button" class="button greyButton castButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="6SecCast">6 Seconds</button>
                            <button type="button" class="button greyButton castButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="12SecCast">12 Seconds</button>
                            <button type="button" class="button greyButton castButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="1MinCast">1 Minute</button>
                            <button type="button" class="button greyButton castButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="10MinCast">10 Minutes</button>
                            <button type="button" class="button greyButton castButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="1HrCast">1 Hour</button>
                        </section>
                    </section>
                    <section class="attrTextWrapper">
                        <span class="attrText" id="castButtonSelectedText"><?php if (isset($castTime)) {
                                                                                echo $castTime;
                                                                            } ?></span>
                    </section>
                </section>

                <section class="dropButton">
                    <section class="button redButton selectEffect">Effect(s)
                        <section class="dropDown">
                            <button type="button" class="button greyButton effectButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="damage">Damage</button>
                            <button type="button" class="button greyButton effectButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="healing">Healing</button>
                            <button type="button" class="button greyButton effectButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="mundane">Mundane</button>
                            <button type="button" class="button greyButton effectButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="lesser">Lesser</button>
                            <button type="button" class="button greyButton effectButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="greater">Greater</button>
                            <button type="button" class="button greyButton effectButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="supreme">Supreme</button>
                            <button type="button" class="button greyButton effectButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="wondrous">Wondrous</button>
                            <button type="button" class="button greyButton effectButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="legendary">Legendary</button>
                        </section>
                    </section>
                    <section class="attrTextWrapper">
                        <span class="attrText" id="effectButtonSelectedText"><?php if (isset($effects)) {
                                                                                    echo $effects;
                                                                                } ?></span>
                    </section>
                </section>

                <section class="dropButton">
                    <section class="button tealButton selectDuration">Durations(s)
                        <section class="dropDown">
                            <button type="button" class="button greyButton durationButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="instantDur">Instant</button>
                            <button type="button" class="button greyButton durationButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="30SecDur">30 Seconds</button>
                            <button type="button" class="button greyButton durationButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="1MinDur">1 Minute</button>
                            <button type="button" class="button greyButton durationButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="10MinDur">10 Minutes</button>
                            <button type="button" class="button greyButton durationButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="1HrDur">1 Hour</button>
                        </section>
                    </section>
                    <section class="attrTextWrapper">
                        <span class="attrText" id="durationButtonSelectedText"><?php if (isset($durations)) {
                                                                                    echo $durations;
                                                                                } ?></span>
                    </section>
                </section>

                <section class="dropButton">
                    <section class="button greenButton selectTarget">Target(s)
                        <section class="dropDown">
                            <button type="button" class="button greyButton targetButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="single">Single</button>
                            <button type="button" class="button greyButton targetButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="13">1-3</button>
                            <button type="button" class="button greyButton targetButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="17">1-7</button>
                            <button type="button" class="button greyButton targetButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="5">5ft Area</button>
                            <button type="button" class="button greyButton targetButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="10">10ft Area</button>
                            <button type="button" class="button greyButton targetButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="20">20ft Area</button>
                            <button type="button" class="button greyButton targetButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="50">50ft Area</button>
                        </section>
                    </section>
                    <section class="attrTextWrapper">
                        <span class="attrText" id="targetButtonSelectedText"><?php if (isset($targets)) {
                                                                                    echo $targets;
                                                                                } ?></span>
                    </section>
                </section>

                <section class="dropButton">
                    <section class="button orangeButton selectRange">Range
                        <section class="dropDown">
                            <button type="button" class="button greyButton rangeButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="self">Self</button>
                            <button type="button" class="button greyButton rangeButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="melee">Melee</button>
                            <button type="button" class="button greyButton rangeButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="short">Short</button>
                            <button type="button" class="button greyButton rangeButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="medium">Medium</button>
                            <button type="button" class="button greyButton rangeButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="long">Long</button>
                        </section>
                    </section>
                    <section class="attrTextWrapper">
                        <span class="attrText" id="rangeButtonSelectedText"><?php if (isset($range)) {
                                                                                echo $range;
                                                                            } ?></span>
                    </section>
                </section>

            </section>

            <section class="bottom">
                <section class="space"></section>
                <section class="dropButton">
                    <section class="button redButton selectCaster">Multiplier
                        <section class="dropDown">
                            <button type="button" class="button greyButton multiButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="1">*1</button>
                            <button type="button" class="button greyButton multiButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="2">*2</button>
                            <button type="button" class="button greyButton multiButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="3">*3</button>
                            <button type="button" class="button greyButton multiButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="4">*4</button>
                            <button type="button" class="button greyButton multiButton" onclick="selectSpellAttr(this.classList, this.textContent)" value="5">*5</button>

                        </section>
                    </section>
                    <section class="attrTextWrapper">
                        <span class="attrText" id="multiButtonSelectedText"><?php if (isset($multi)) {
                                                                                echo $multi;
                                                                            } ?></span>
                    </section>
                </section>
                <section class="space"></section>
                <section class="space"></section>
                <section class="space"></section>
                <section class="space"></section>

            </section>

        </section>

    </main>
    <script>

    if((document.getElementById("effectButtonSelectedText").textContent == "Damage" || document.getElementById("effectButtonSelectedText").textContent == "Healing")){
        document.getElementsByClassName("bottom")[0].style.display = "grid";
    }


    </script>
    <footer>
        <?php include '../Spellbuilder/common/footer.php'; ?>
    </footer>

</body>

</html>
<?php
function buildViewSpells($db, $spells, $page){
    $view = '';
    foreach ($spells as $spell) {
        $view .= '<section class="fullViewSpellsWrapper">';
        $view .= '<section class="viewSpellsWrapper">';
        $view .= '<section class="heading">';
        $view .= '<h1 class="name">' . $spell['name'] . '</h1>';
        $view .= '<section class="subheading">';
        $view .= '<h2 class="cost">Cost: ' . $spell['cost'] . '</h2>';
        $view .= '<h3 class="castertype">' . $spell['castertype'] . ' Caster</h3>';
        $view .= '</section>';
        $view .= '</section>';
        $view .= '<section class="meta">';
        $view .= '<ul class="metaList">';
        $view .= '<li>Cast: ' . $spell['casttime'] . '</li>';
        $view .= '<li>Range: ' . $spell['range'] . '</li>';

        $effects = getEffects($db, $spell['id']);
        $view .= '<li>Effect(s): ';
        foreach ($effects as $effect) {
            $view .= $effect['name'] . ' ';
        }
        $view .= '</li>';


        $durations = getDurations($db, $spell['id']);
        $view .= '<li>Duration(s): ';
        foreach ($durations as $duration) {
            $view .= $duration['name'] . ' ';
        }
        $view .= '</li>';

        $targets = getTargets($db, $spell['id']);
        $view .= '<li>Target(s): ';
        foreach ($targets as $target) {
            $view .= $target['name'] . ' ';
        }
        $view .= '</li>';

        $view .= '</ul>';
        $view .= '</section>';
        $view .= '<p class="description">' . $spell['description'] . '</p>';

        $view .= '<section class="spellButton">';
        $view .= '<form class="spellButtonForm" action="../Spellbuilder/index.php" method="post">';
        if($page == "view"){
            $view .= '<input type="submit" class="button goldButton" name="submit" value="Delete Spell">';
            $view .= '<input type="hidden" name="action" value="deleteSpell">';
            $view .= '<input type="hidden" name="id" value="' . $spell['id'] . '">';
        }
        else if($page == "spellList"){
            $view .= '<input type="submit" class="button goldButton" name="submit" value="Remove Spell">';
            $view .= '<input type="hidden" name="action" value="removeSpell">';
            $view .= '<input type="hidden" name="id" value="' . $spell['id'] . '">';
        }
        else if($page == "addToList"){
            $view .= '<input type="submit" class="button goldButton" name="submit" value="Add Spell">';
            $view .= '<input type="hidden" name="action" value="addSpell">';
            $view .= '<input type="hidden" name="id" value="' . $spell['id'] . '">';
        }

        $view .= '</form>';
        $view .= '</section>';
        $view .= '</section>';
        $view .= '</section>';

    }

    return $view;
}

function buildCharacterView($characters){
    $chars = '<section class="viewWrapperChar">';
    $chars .= '<section class="charTable">';
    $chars .= '<section class="tableRow">';
    $chars .= '<h1 class="tableHeader">Character Name</h1>';
    $chars .= '</section>';
    foreach ($characters as $character) {
        $chars .= '<section class="tableRow">';
        $chars .= '<h2 class="name">' . $character['name'] . '</h2>';
        $chars .= '<section class="viewList">';
        $chars .= '<div class="listLink"><a href="/Spellbuilder/index.php?action=spellList&charId=' . $character['id'] . '">View Spell List</a></div>';
        $chars .= '</section>';
        $chars .= '</section>';
    }
    $chars .= '</section>';
    $chars .= '</section>';
    $chars .= '<form class="charForm" action="../Spellbuilder/index.php" method="post">';
    $chars .= '<input type="text" class="inputField" name="inputField" value="" placeholder="Name">';
    $chars .= '<input type="submit" class="button goldButton" name="submit" value="Create Character">';
    $chars .= '<input type="hidden" name="action" value="createCharacter">';
    $chars .= '</form>';

    return $chars;
}

function buildSearchForm(){
    $searchForm = '<section id="searchWrapper">';
    $searchForm .= '<form class="searchForm" action="../Spellbuilder/index.php" method="post">';
    $searchForm .= '<input type="text" class="inputField" name="searchBox" value="" placeholder="Search">';
    $searchForm .= '<input type="submit" class="button goldButton" name="submit" value="Search">';
    $searchForm .= '<input type="hidden" name="action" value="search">';

    return $searchForm;
}

function buildCharacterSearchForm(){

    $searchForm = '<input type="hidden" name="type" value="characters">';
    $searchForm .= '<button class="button goldButton" onclick="window.location.href=';
    $searchForm .= "'/Spellbuilder/index.php?action=characters';";
    $searchForm .= '">Clear</button>';
    $searchForm .= '</form>';
    $searchForm .= '</section>';

    return $searchForm;
}

function buildSpellSearchForm(){
    $searchForm = '<input type="hidden" name="type" value="spells">';
    $searchForm .= '<button class="button goldButton" onclick="window.location.href=';
    $searchForm .= "'/Spellbuilder/index.php?action=view';";
    $searchForm .= '">Clear</button>';
    $searchForm .= '</form>';
    $searchForm .= '</section>';

    return $searchForm;
}

function buildCreateSpell(){
    $create = '<section class="createWrapper">' .

    '<section class="top">' .
    '<section class="dropButton">' .
    '<section class="button goldButton selectCaster">Caster Type' .
    '<section class="dropDown">' .
    '<button type="button" class="button greyButton typeButton" value="full">Full Caster</button>' . 
    '<button type="button" class="button greyButton typeButton" value="half">Half Caster</button>' . 
    '<button type="button" class="button greyButton typeButton" value="melee">Melee Caster</button>' . 
    '</section>' . 
    '</section>' . 
    '</section>' . 

    '<section class="selectCreate">' .
    '<form class="createForm" action="../Spellbuilder/index.php?createSpell" method="post">' .
    '<input type="hidden" id="name" name="name" value="">' .
    '<input type="hidden" id="desc" name="desc" value="">' .
    '<input type="hidden" id="casterType" name="casterType" value="">' .
    '<input type="hidden" id="cost" name="cost" value="">' .
    '<input type="hidden" id="casttime" name="casttime" value="">' .
    '<input type="hidden" id="effects" name="effects" value="">' .
    '<input type="hidden" id="durations" name="durations" value="">' .
    '<input type="hidden" id="targets" name="targets" value="">' .
    '<input type="hidden" id="range" name="range" value="">' .
    '<input class="button goldButton" type="submit" value="Create Spell">' . 
    '</section>' . 

    '<section class="prelimCost">' .
    '<button type="button" class="button goldButton" value="cost">Cost</button>' . 
    '</section>' . 
    '</section>' . 

    '<section class="mid">' .
    '<section class="dropButton">' .
    '<section class="button blueButton selectCast">Cast Time' .
    '<section class="dropDown">' .
    '<button type="button" class="button greyButton castButton" value="instantCast">Instant</button>' . 
    '<button type="button" class="button greyButton castButton" value="3SecCast">3 Seconds</button>' . 
    '<button type="button" class="button greyButton castButton" value="6SecCast">6 Seconds</button>' . 
    '<button type="button" class="button greyButton castButton" value="12SecCast">12 Seconds</button>' . 
    '<button type="button" class="button greyButton castButton" value="1MinCast">1 Minute</button>' . 
    '<button type="button" class="button greyButton castButton" value="10MinCast">10 Minutes</button>' . 
    '<button type="button" class="button greyButton castButton" value="1HrCast">1 Hour</button>' . 
    '</section>' . 
    '</section>' . 
    '</section>' . 

    '<section class="dropButton">' .
    '<section class="button redButton selectCast">Effect(s)' .
    '<section class="dropDown">' .
    '<button type="button" class="button greyButton effectButton" value="damage">Damage</button>' . 
    '<button type="button" class="button greyButton effectButton" value="healing">Healing</button>' . 
    '<button type="button" class="button greyButton effectButton" value="mundane">Mundane</button>' . 
    '<button type="button" class="button greyButton effectButton" value="lesser">Lesser</button>' . 
    '<button type="button" class="button greyButton effectButton" value="greater">Greater</button>' . 
    '<button type="button" class="button greyButton effectButton" value="supreme">Supreme</button>' . 
    '<button type="button" class="button greyButton effectButton" value="wondrous">Wondrous</button>' . 
    '<button type="button" class="button greyButton effectButton" value="legendary">Legendary</button>' . 
    '</section>' . 
    '</section>' . 
    '</section>' . 

    '<section class="dropButton">' .
    '<section class="button tealButton selectCast">Durations(s)' .
    '<section class="dropDown">' .
    '<button type="button" class="button greyButton durationButton" value="instantDur">Instant</button>' . 
    '<button type="button" class="button greyButton durationButton" value="30SecDur">30 Seconds</button>' . 
    '<button type="button" class="button greyButton durationButton" value="1MinDur">1 Minute</button>' . 
    '<button type="button" class="button greyButton durationButton" value="10MinDur">10 Minutes</button>' . 
    '<button type="button" class="button greyButton durationButton" value="1HrDur">1 Hour</button>' . 
    '</section>' . 
    '</section>' . 
    '</section>' . 

    '<section class="dropButton">' .
    '<section class="button greenButton selectCast">Target(s)' .
    '<section class="dropDown">' .
    '<button type="button" class="button greyButton targetButton" value="mundane">Single</button>' . 
    '<button type="button" class="button greyButton targetButton" value="lesser">1-3</button>' . 
    '<button type="button" class="button greyButton targetButton" value="greater">1-7</button>' . 
    '<button type="button" class="button greyButton targetButton" value="supreme">5ft Area</button>' . 
    '<button type="button" class="button greyButton targetButton" value="wondrous">10ft Area</button>' . 
    '<button type="button" class="button greyButton targetButton" value="legendary">20ft Area</button>' . 
    '<button type="button" class="button greyButton targetButton" value="legendary">50ft Area</button>' . 
    '</section>' .
    '</section>' . 
    '</section>' . 

    '<section class="dropButton">' .
    '<section class="button orangeButton selectCast">Range' .
    '<section class="dropDown">' .
    '<button type="button" class="button greyButton rangeButton" value="self">Self</button>' . 
    '<button type="button" class="button greyButton rangeButton" value="melee">Melee</button>' . 
    '<button type="button" class="button greyButton rangeButton" value="short">Short</button>' . 
    '<button type="button" class="button greyButton rangeButton" value="medium">Medium</button>' . 
    '<button type="button" class="button greyButton rangeButton" value="long">Long</button>' . 
    '</section>' . 
    '</section>' . 
    '</section>' . 

    '</section>' . 

    '</section>';

    return $create;
}

?>


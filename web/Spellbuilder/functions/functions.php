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

        if($page == "view"){
            $view .= '<section class="spellButton">';
            $view .= '<form class="spellButtonForm" action="../Spellbuilder/index.php" method="post">';
            $view .= '<input type="submit" class="button goldButton" name="submit" value="Edit Spell">';
            $view .= '<input type="hidden" name="action" value="editSpell">';
            $view .= '<input type="hidden" name="id" value="' . $spell['id'] . '">';
            $view .= '</form>';
            $view .= '</section>';
        }

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
            $view .= '<input type="hidden" value="' . $spell['id'] . '" name="id">';
        }
        else if($page == "addToList"){
            $view .= '<input type="submit" class="button goldButton" name="submit" value="Add Spell">';
            $view .= '<input type="hidden" name="action" value="addSpell">';
            $view .= '<input type="hidden" value="' . $spell['id'] . '" name="id">';
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
        $chars .= '<section class="delChar">';
        $chars .= '<div class="listLink"><a href="/Spellbuilder/index.php?action=deleteCharacter&charName=' . $character['name'] . '">Delete Character</a></div>';
        $chars .= '</section>';
        $chars .= '</section>';
    }
    $chars .= '</section>';
    $chars .= '</section>';
    $chars .= '<form class="charForm" action="../Spellbuilder/index.php" method="post">';
    $chars .= '<input type="text" class="inputField" name="inputField" value="" placeholder="Name">';
    $chars .= '<input type="submit" class="button goldButton buttonSmallText" name="submit" value="Create Character">';
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

function buildSpellMessage($name, $desc, $casterType, $cost, $castTime, $effects, $durations,$targets,$range,$multi){
    $m = '<p class="notify">Please complete the following attributes:<br>';
            if(empty($name)){
                $m .= 'Spell Name<br>';
            }
            if(empty($desc)){
                $m .= 'Description<br>';
            }
            if(empty($casterType)){
                $m .= 'Caster Type<br>';
            }
            if(empty($cost)){
                $m .= 'Cost<br>';
            }
            if(empty($castTime)){
                $m .= 'Cast Time<br>';
            }
            if(empty($effects)){
                $m .= 'Effect(s)<br>';
            }
            if(empty($durations)){
                $m .= 'Duration(s)<br>';
            }
            if(empty($targets)){
                $m .= 'Target(s)<br>';
            }
            if(empty($range)){
                $m .= 'Range<br>';
            }
            if($effects == "Damage" || $effects == "Healing"){
                if(empty($multi)){
                    $m .= 'Multiplier<br>';
                }
            }
            $m .= '</p>';
            return $m;
}
?>
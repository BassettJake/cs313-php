<?php

try {
    $dbUrl = getenv('DATABASE_URL');

    $dbOpts = parse_url($dbUrl);

    $dbHost = $dbOpts["host"];
    $dbPort = $dbOpts["port"];
    $dbUser = $dbOpts["user"];
    $dbPassword = $dbOpts["pass"];
    $dbName = ltrim($dbOpts["path"], '/');

    $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    session_start();
} catch (PDOException $ex) {
    echo 'Error!: ' . $ex->getMessage();
    die();
}

require_once 'model/spellbuilder_model.php';
require_once 'functions/functions.php';

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    case 'characters':

        $characters = getCharacters($db);
        if (count($characters) == 0) {
            $message = '<p class="notify">Sorry, no characters have been created.</p>';
        }
        $searchForm = buildSearchForm();
        $searchForm .= buildCharacterSearchForm();
        $chars = buildCharacterView($characters);

        $subHeading = "Characters";

        include 'view/characters.php';
        break;

    case 'search':
        $searchBox = filter_input(INPUT_POST, 'searchBox', FILTER_SANITIZE_STRING);
        $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);

        if ($type == 'characters') {
            $characters = getFilteredCharacters($db, $searchBox);
            if (count($characters) > 0) {
                $searchForm = buildSearchForm();
                $searchForm .= buildCharacterSearchForm();
                $chars = buildCharacterView($characters);
            } else {
                $searchForm = buildSearchForm();
                $searchForm .= buildCharacterSearchForm();
                $characters = getCharacters($db);
                $chars = buildCharacterView($characters);
                if(count($characters) > 0){
                    $message = '<p class="notify">Sorry, no characters match that search.</p>';
                }
                else{
                    $message = '<p class="notify">Sorry, no characters have been created.</p>';
                }
            }
            $subHeading = "Characters";
            include 'view/characters.php';
        } else if ($type == 'spells') {
            $spells = getFilteredSpells($db, $searchBox);
            if (count($spells) > 0) {
                $searchForm = buildSearchForm();
                $searchForm .= buildSpellSearchForm();
                $view = '<section class="viewWrapper">';
                $view .= buildViewSpells($db, $spells, 'view');
                $view .= '</section>';
            } else {
                $searchForm = buildSearchForm();
                $searchForm .= buildSpellSearchForm();
                $spells = getSpells($db);
                if(count($spells) > 0 ){
                    $message = '<p class="notify">Sorry, no spells match that search.</p>';
                }
                else{
                    $message = '<p class="notify">Sorry, no spells have been created.</p>';
                }

            }
            $subHeading = "All Spells";

            include 'view/viewSpells.php';
        }

        break;

    case 'view':

        $spells = getSpells($db);

        if (count($spells) > 0) {
            $searchForm = buildSearchForm();
            $searchForm .= buildSpellSearchForm();
            $view = '<section class="viewWrapper">';
            $view .= buildViewSpells($db, $spells, 'view');
            $view .= '</section>';
        } else {
            $message = '<p class="notify">Sorry, no spells have been created.</p>';
        }

        $subHeading = "All Spells";

        include 'view/viewSpells.php';
        break;

    case 'spellList':
        $charId = filter_input(INPUT_GET, 'charId', FILTER_VALIDATE_INT);

        //the list of spells for this character
        $listItems = getList($db, $charId);
        //for each spell, get that spells info
        $spells = array();

        $characters = getCharacter($db, $charId);
        $charName = "";
        foreach ($characters as $character) {
            $charName = $character['name'];
        }
        $spellList = '<section class="topSpellButton">';
        $spellList .= '<button class="button goldButton" onclick="window.location.href=';
        $spellList .= "'/Spellbuilder/index.php?action=addToList&charId=". $charId . "';";
        $spellList .= '">Add Spells</button>';
        $spellList .= '<button class="button goldButton" onclick="window.location.href=';
        $spellList .= "'/Spellbuilder/index.php?action=characters';";
        $spellList .= '">Back</button>';
        $spellList .= '</section>';
        $spellList .= '<section class="viewWrapper">';
        if (count($listItems) > 0) {
            foreach ($listItems as $listItem) {
                $spells = getListSpells($db, $listItem['spell_id']);
                if (count($spells) > 0) {
                    $spellList .= buildViewSpells($db, $spells, 'spellList');
                } else {
                    $message = '<p class="notify">Sorry, no spells have been added to ' . $charName . '\'s Spell List.</p>';
                }
            }
        } else {
            $message = '<p class="notify">Sorry, no spells have been added to ' . $charName . '\'s Spell List.</p>';
        }
        $spellList .= '</section>';

        $spellIdLoc = strpos($spellList, 'name="id">');

        $hiddenInput = '<input type="hidden" name="charId" value="' . $charId . '">';
        
        $spellList = str_replace('name="id">', 'name="id">' . $hiddenInput, $spellList);

        $subHeading = $charName . "'s Spells";
        include 'view/viewCharacterList.php';
        break;

    case 'create':

        $subHeading = "Create a Spell";
        include 'view/create.php';
        break;
    case 'editSpell':
        $spellId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $edit = '<input type="hidden" name="id" value="' . $spellId . '">';
        $spellInfo = getListSpells($db, $spellId);
        $spellInfo = array_slice($spellInfo, 0, 1);

        $spellEffectInfo = getEffects($db, $spellId);
        $spellEffectInfo = array_slice($spellEffectInfo, 0, 1);

        $spellDurationInfo = getDurations($db, $spellId);
        $spellDurationInfo = array_slice($spellDurationInfo, 0, 1);

        $spellTargetInfo = getTargets($db, $spellId);
        $spellTargetInfo = array_slice($spellTargetInfo, 0, 1);

        $spellEffectInfo = explode(' * ', $spellEffectInfo[0]['name']);
        $spellEffectInfo = array_slice($spellEffectInfo, 0, 2);
        $spellEffect = $spellEffectInfo[0];
        $spellMulti = $spellEffectInfo[1];

        $name = $spellInfo[0]['name'];
        $desc = $spellInfo[0]['description'];
        $casterType = $spellInfo[0]['castertype'];
        $castTime = $spellInfo[0]['casttime'];
        $cost = $spellInfo[0]['cost'];
        $effects = $spellEffect;
        $durations = $spellDurationInfo[0]['name'];
        $targets = $spellTargetInfo[0]['name'];
        $range = $spellInfo[0]['range'];
        $multi = $spellMulti;        

        $subHeading = "Edit a Spell";
        include 'view/create.php';
        break;
    case 'addToList':
        $charId = filter_input(INPUT_GET, 'charId', FILTER_VALIDATE_INT);

        //the list of spells for this character
        $listItems = getList($db, $charId);
        //for each spell, get that spells info
        $spells = array();

        $characters = getCharacter($db, $charId);
        $charName = "";
        foreach ($characters as $character) {
            $charName = $character['name'];
        }
        $missingSpells = '<section class="topSpellButton">';
        $missingSpells .= '<button class="button goldButton" onclick="window.location.href=';
        $missingSpells .= "'/Spellbuilder/index.php?action=spellList&charId=". $charId . "';";
        $missingSpells .= '">Back to ' . $charName . '\'s Spells</button>';
        $missingSpells .= '</section>';
        $missingSpells .= '<section class="viewWrapper">';
        $spells = "";
        if (count($listItems) > 0) {
            $spells = getMissingListSpells($db, $listItems);
        }
        else{
            $spells = getSpells($db);
        }

        if (count($spells) > 0) {
            $missingSpells .= buildViewSpells($db, $spells, 'addToList');
        } else {
            $message = '<p class="notify">Sorry, no spells remain to be added to ' . $charName . '\'s Spell List.</p>';
        }
        $missingSpells .= '</section>';

        $spellIdLoc = strpos($missingSpells, 'name="id">');

        $hiddenInput = '<input type="hidden" name="charId" value="' . $charId . '">';
        
        $missingSpells = str_replace('name="id">', 'name="id">' . $hiddenInput, $missingSpells);

        $subHeading = "Add to " . $charName . "'s Spells";
        include 'view/addSpellList.php';
        break;

    case 'createCharacter':
        $charName = filter_input(INPUT_POST, 'inputField', FILTER_SANITIZE_STRING);

        if(empty($charName)){
            $message = '<p class="notify">Character name cannot be blank.</p>';
        }
        else{

            $checkExisting = checkCharactersByName($db, $charName);
            if(!($checkExisting === 0)){
                $message = '<p class="notify">Error, a character with this name already exists.</p>';
            }
            else{
                $success = createCharacter($db, $charName);
                if(!($success === 1)){
                    $message = '<p class="notify">Error, ' . $charName . ' was not added.</p>';
                }
                else{
                    $message = '<p class="notify">' . $charName . ' was added!</p>';
                    unset($charName);
                }
            }
        }

        $characters = getCharacters($db);
        if (count($characters) == 0) {
            $message = '<p class="notify">Sorry, no characters have been created.</p>';
        }
        $searchForm = buildSearchForm();
        $searchForm .= buildCharacterSearchForm();
        $chars = buildCharacterView($characters);

        $subHeading = "Characters";
        include 'view/characters.php';
        break;  

    case 'createSpell':
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $desc = filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_STRING);
        $casterType = filter_input(INPUT_POST, 'casterType', FILTER_SANITIZE_STRING);
        $castTime = filter_input(INPUT_POST, 'casttime', FILTER_SANITIZE_STRING);
        $cost = filter_input(INPUT_POST, 'cost', FILTER_VALIDATE_INT);
        $effects = filter_input(INPUT_POST, 'effects', FILTER_SANITIZE_STRING);
        $durations = filter_input(INPUT_POST, 'durations', FILTER_SANITIZE_STRING);
        $targets = filter_input(INPUT_POST, 'targets', FILTER_SANITIZE_STRING);
        $range = filter_input(INPUT_POST, 'range', FILTER_SANITIZE_STRING);
        $multi = filter_input(INPUT_POST, 'multi', FILTER_SANITIZE_STRING);

        if((empty($name) || empty($desc) || empty($casterType) || empty($castTime) || (empty($cost) && $cost != 0) || 
        empty($effects) || empty($durations) || empty($targets) || empty($range)) 
            || 
            (($effects == "Damage" || $effects == "Healing")) 
                && 
                (empty($multi))){

            $message = buildSpellMessage($name, $desc, $casterType, $cost, $castTime, $effects, $durations,$targets,$range,$multi);
        }
        else{

            $checkExisting = checkSpellsByName($db, $name);
            if(!($checkExisting === 0)){
                $message = '<p class="notify">Error, a spell with this name already exists.</p>';
            }
            else{

            $success = createSpell($db, $name, $desc, $castTime, $casterType, $cost, $range);

            if(!($success === 1)){
                $message = '<p class="notify">Error, ' . $name . ' was not added.</p>';
            }
            else{
                    $spellId = getLastSpellId($db);
                    if(count($spellId) == 1){
                        $spellId = array_slice($spellId, 0, 1);
                        $spellId = $spellId[0]['id'];
                        $success = "";
                        if(empty($multi)){
                            $success = createEffects($db, $spellId, $effects);
                        }
                        else{
                            $success = createEffects($db, $spellId, ($effects . ' * ' . $multi));
                        }
                        if(!($success === 1)){
                            $message = '<p class="notify">Error, ' . $name . ' effect was not added.</p>';
                        }
                        else{
                            $success = createDurations($db, $spellId, $durations);
                            if(!($success === 1)){
                                $message = '<p class="notify">Error, ' . $name . ' duration was not added.</p>';
                            }
                            else{
                                $success = createTargets($db, $spellId, $targets);
                                if(!($success === 1)){
                                    $message = '<p class="notify">Error, ' . $name . ' target was not added.</p>';
                                }
                                else{
                                    $message = '<p class="notify">Spell created!</p>';
                                    unset($name, $desc, $casterType, $cost, $castTime, $effects, $durations,$targets,$range,$multi);
                                }
                            }
                        }
                    }
                }
            }
        }
        $subHeading = "Create a Spell";
        include 'view/create.php';
        break;

    case 'deleteSpell':
        $spellId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);


        $success = deleteEffects($db, $spellId);
        if(!($success === 1)){
            $message = '<p class="notify">Error, could not delete that spell effect.</p>';
        }
        else{
            $success = deleteDurations($db, $spellId);
            if(!($success === 1)){
                $message = '<p class="notify">Error, could not delete that spell duration.</p>';
            }
            else{
                $success = deleteTargets($db, $spellId);
                if(!($success === 1)){
                    $message = '<p class="notify">Error, could not delete that spell target.</p>';
                }
                else{
                    $success = deleteSpell($db, $spellId);
                    if(!($success === 1)){
                        $message = '<p class="notify">Error, could not delete that spell.</p>';
                    }
                    else{
                        $message = '<p class="notify">Spell deleted successfully.</p>';
                    }
                }
            }
        }



        $spells = getSpells($db);

        if (count($spells) > 0) {
            $searchForm = buildSearchForm();
            $searchForm .= buildSpellSearchForm();
            $view = '<section class="viewWrapper">';
            $view .= buildViewSpells($db, $spells, 'view');
            $view .= '</section>';
        } else {
            $message = '<p class="notify">Sorry, no spells have been created.</p>';
        }
        $subHeading = "All Spells";

        include 'view/viewSpells.php';
        break;
    
    case 'removeSpell':
        $charId = filter_input(INPUT_POST, 'charId', FILTER_VALIDATE_INT);
        $spellId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        $success = removeSpell($db, $charId, $spellId);
        if(!($success === 1)){
            $message = '<p class="notify">Error, could not remove that spell.</p>';
        }
        else{
            $message = '<p class="notify">Spell removed from spell list.</p>';
        }

        $listItems = getList($db, $charId);
        //for each spell, get that spells info
        $spells = array();

        $characters = getCharacter($db, $charId);
        $charName = "";
        foreach ($characters as $character) {
            $charName = $character['name'];
        }
        $spellList = '<section class="topSpellButton">';
        $spellList .= '<button class="button goldButton" onclick="window.location.href=';
        $spellList .= "'/Spellbuilder/index.php?action=addToList&charId=". $charId . "';";
        $spellList .= '">Add Spells</button>';
        $spellList .= '<button class="button goldButton" onclick="window.location.href=';
        $spellList .= "'/Spellbuilder/index.php?action=characters';";
        $spellList .= '">Back</button>';
        $spellList .= '</section>';
        $spellList .= '<section class="viewWrapper">';
        if (count($listItems) > 0) {
            foreach ($listItems as $listItem) {
                $spells = getListSpells($db, $listItem['spell_id']);
                if (count($spells) > 0) {
                    $spellList .= buildViewSpells($db, $spells, 'spellList');
                } else {
                    $message = '<p class="notify">Sorry, no spells have been added to ' . $charName . '\'s Spell List.</p>';
                }
            }
        } else {
            $message = '<p class="notify">Sorry, no spells have been added to ' . $charName . '\'s Spell List.</p>';
        }
        $spellList .= '</section>';

        $spellIdLoc = strpos($spellList, 'name="id">');

        $hiddenInput = '<input type="hidden" name="charId" value="' . $charId . '">';
        
        $spellList = str_replace('name="id">', 'name="id">' . $hiddenInput, $spellList);

        $subHeading = $charName . "'s Spells";
        include 'view/viewCharacterList.php';
        break;
    case 'addSpell':
        $charId = filter_input(INPUT_POST, 'charId', FILTER_VALIDATE_INT);
        $spellId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        $success = addToSpellList($db, $charId, $spellId);
        if(!($success === 1)){
            $message = '<p class="notify">Error, could not add that spell.</p>';
        }
        else{
            $message = '<p class="notify">Spell added to spell list.</p>';
        }

        //the list of spells for this character
        $listItems = getList($db, $charId);
        //for each spell, get that spells info
        $spells = array();

        $characters = getCharacter($db, $charId);
        $charName = "";
        foreach ($characters as $character) {
            $charName = $character['name'];
        }
        $missingSpells = '<section class="topSpellButton">';
        $missingSpells .= '<button class="button goldButton" onclick="window.location.href=';
        $missingSpells .= "'/Spellbuilder/index.php?action=spellList&charId=". $charId . "';";
        $missingSpells .= '">Back to ' . $charName . '\'s Spells</button>';
        $missingSpells .= '</section>';
        $missingSpells .= '<section class="viewWrapper">';
        if (count($listItems) > 0) {
            $spells = getMissingListSpells($db, $listItems);
            if (count($spells) > 0) {
                $missingSpells .= buildViewSpells($db, $spells, 'addToList');
            } else {
                $message = '<p class="notify">Sorry, no spells remain to be added to ' . $charName . '\'s Spell List.</p>';
            }
        } else {
            $message = '<p class="notify">Sorry, no spells remain to be added to ' . $charName . '\'s Spell List.</p>';
        }
        $missingSpells .= '</section>';

        $spellIdLoc = strpos($missingSpells, 'name="id">');

        $hiddenInput = '<input type="hidden" name="charId" value="' . $charId . '">';
        
        $missingSpells = str_replace('name="id">', 'name="id">' . $hiddenInput, $missingSpells);

        $subHeading = "Add to " . $charName . "'s Spells";
        include 'view/addSpellList.php';
        break;
    
    case 'deleteCharacter':
        $charName = filter_input(INPUT_GET, 'charName', FILTER_SANITIZE_STRING);

        $success = checkSpellList($db, $charName);

        if($success == 0){
            $success = deleteCharacter($db, $charName);
            if(!($success === 1)){
                $message = '<p class="notify">Error, ' . $charName . ' was not deleted.</p>';
            }
            else{
                $message = '<p class="notify">'. $charName . ' was deleted.</p>';
            }
        }
        else{
            $success = deleteSpellList($db, $charName);
            if(!($success === 1)){
                $message = '<p class="notify">Error, ' . $charName . '\'s spell list was not deleted.</p>';
            }
            else{
                $success = deleteCharacter($db, $charName);
                if(!($success === 1)){
                    $message = '<p class="notify">Error, ' . $charName . ' was not deleted.</p>';
                }
                else{
                    $message = '<p class="notify">'. $charName . ' was deleted.</p>';
                }
            }
        }

        $characters = getCharacters($db);
        if (count($characters) == 0) {
            if(!(isset($message))){
                $message = '<p class="notify">Sorry, no characters have been created.</p>';
            }

        }
        $searchForm = buildSearchForm();
        $searchForm .= buildCharacterSearchForm();
        $chars = buildCharacterView($characters);

        $subHeading = "Characters";
        include 'view/characters.php';
        break;  
    case 'editCreateSpell':
        $spellId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $desc = filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_STRING);
        $casterType = filter_input(INPUT_POST, 'casterType', FILTER_SANITIZE_STRING);
        $castTime = filter_input(INPUT_POST, 'casttime', FILTER_SANITIZE_STRING);
        $cost = filter_input(INPUT_POST, 'cost', FILTER_VALIDATE_INT);
        $effects = filter_input(INPUT_POST, 'effects', FILTER_SANITIZE_STRING);
        $durations = filter_input(INPUT_POST, 'durations', FILTER_SANITIZE_STRING);
        $targets = filter_input(INPUT_POST, 'targets', FILTER_SANITIZE_STRING);
        $range = filter_input(INPUT_POST, 'range', FILTER_SANITIZE_STRING);
        $multi = filter_input(INPUT_POST, 'multi', FILTER_SANITIZE_STRING);
        $edit = '<input type="hidden" name="id" value="' . $spellId . '">';
        if((empty($name) || empty($desc) || empty($casterType) || empty($castTime) || (empty($cost) && $cost != 0) || 
        empty($effects) || empty($durations) || empty($targets) || empty($range)) 
            || 
            (($effects == "Damage" || $effects == "Healing")) 
                && 
                (empty($multi))){

            $message = buildSpellMessage($name, $desc, $casterType, $cost, $castTime, $effects, $durations,$targets,$range,$multi);
        }
        else{
            $checkExisting = checkSpellsByNameAndId($db, $name, $spellId);
            if(!($checkExisting === 0)){
                $message = '<p class="notify">Error, a different spell with this name already exists.</p>';
            }
            else{

                $success = editSpell($db, $spellId, $name, $desc, $castTime, $casterType, $cost, $range);

                if(!($success === 1)){
                    $message = '<p class="notify">Error, ' . $name . ' was not edited.</p>';
                }
                else{
                    $success = "";
                    if(empty($multi)){
                        $success = editEffects($db, $spellId, $effects);
                    }
                    else{
                        $success = editEffects($db, $spellId, ($effects . ' * ' . $multi));
                    }
                    
                    if(!($success === 1)){
                        $message = '<p class="notify">Error, ' . $name . ' was not edited.</p>';
                    }
                    else{
                        $success = editDurations($db, $spellId, $durations);
                        if(!($success === 1)){
                            $message = '<p class="notify">Error, ' . $name . ' was not edited.</p>';
                        }
                        else{
                            $success = editTargets($db, $spellId, $targets);
                            if(!($success === 1)){
                                $message = '<p class="notify">Error, ' . $name . ' was not edited.</p>';
                            }
                            else{
                                $message = '<p class="notify">Spell edited!</p>';
                                unset($name, $desc, $casterType, $cost, $castTime, $effects, $durations,$targets,$range,$multi, $edit);
                            }
                        }
                    }
                }
            }
        }
        $subHeading = "Create a Spell";
        include 'view/create.php';
        break;
        default:
    $subHeading = "Home";
    include 'view/home.php';

}
?>
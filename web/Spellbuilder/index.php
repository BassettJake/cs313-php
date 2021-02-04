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
        if (count($characters) > 0) {

            $searchForm = buildSearchForm();
            $searchForm .= buildCharacterSearchForm();
            $chars = buildCharacterView($characters);
        } else {
            $message = '<p class="notify">Sorry, no characters have been created.</p>';
        }

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
                $message = '<p class="notify">Sorry, no characters match that search.</p>';
            }
            $subHeading = "Characters";
            include 'view/characters.php';
        } else if ($type == 'spells') {
            $spells = getFilteredSpells($db, $searchBox);
            if (count($spells) > 0) {
                $searchForm = buildSearchForm();
                $searchForm .= buildSpellSearchForm();
                $view = '<section class="viewWrapper">';
                $view .= buildViewSpells($db, $spells);
                $view .= '</section>';
            } else {
                $searchForm = buildSearchForm();
                $searchForm .= buildSpellSearchForm();
                $message = '<p class="notify">Sorry, no spells match that search.</p>';
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

        $subHeading = $charName . "'s Spells";
        include 'view/viewCharacterList.php';
        break;

    case 'create':
        $create = buildCreateSpell();
        $subHeading = "Create a Spell";
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

        $subHeading = "Add to " . $charName . "'s Spells";
        include 'view/addSpellList.php';
        break;

        default:
        $subHeading = "Home";
        include 'view/home.php';
}
?>
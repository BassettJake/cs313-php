<?php

try
{
  $dbUrl = getenv('DATABASE_URL');

  $dbOpts = parse_url($dbUrl);

  $dbHost = $dbOpts["host"];
  $dbPort = $dbOpts["port"];
  $dbUser = $dbOpts["user"];
  $dbPassword = $dbOpts["pass"];
  $dbName = ltrim($dbOpts["path"],'/');

  $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);

  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $ex)
{
  echo 'Error!: ' . $ex->getMessage();
  die();
}

function getSpells($db){
    $sql = 'SELECT * FROM spells ORDER BY name ASC';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $spells = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $spells;
}

function getEffects($db, $spellId){
    $sql = 'SELECT * FROM effects_lists AS e WHERE e.spell_id = :spellId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':spellId', $spellId, PDO::PARAM_INT);
    $stmt->execute();
    $effects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $effects;
}

function getDurations($db, $spellId){
    $sql = 'SELECT * FROM durations_lists AS e WHERE e.spell_id = :spellId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':spellId', $spellId, PDO::PARAM_INT);
    $stmt->execute();
    $durations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $durations;
}

function getTargets($db, $spellId){
    $sql = 'SELECT * FROM targets_lists AS e WHERE e.spell_id = :spellId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':spellId', $spellId, PDO::PARAM_INT);
    $stmt->execute();
    $targets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $targets;
}

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    default:
        $spells = getSpells($db);

        if (count($spells) > 0) {
            $view = '<section id="viewSpellsWrapper">';
            foreach ($spells as $spell) {

                $view .= '<section id="heading">';
                $view .= '<h1 id="name">' . $spell['name'] . '</h1>';
                $view .= '<section id="subheading">';
                $view .= '<h2 id="cost">' . $spell['cost'] . '</h2>';
                $view .= '<h3 id="castertype">' . $spell['castertype'] . '</h3>';
                $view .= '</section>';
                $view .= '</section>';
                $view .= '<section id="meta">';
                $view .= '<ul id="metaList">';
                $view .= '<li>' . $spell['casttime'] . '</li>';
                $view .= '<li>' . $spell['range'] . '</li>';

                $effects = getEffects($db, $spell['id']);
                foreach($effects as $effect){
                    $view .= '<li>' . $effect['name'] . '</li>';
                }

                $durations = getDurations($db, $spell['id']);
                foreach($durations as $duration){
                    $view .= '<li>' . $duration['name'] . '</li>';
                }
                $targets = getTargets($db, $spell['id']);
                foreach($targets as $target){
                    $view .= '<li>' . $target['name'] . '</li>';
                }
                $view .= '</ul>';
                $view .= '</section>';
                $view .= '<p id="description">' . $spell['description'] . '</p>';
            }
            $view .= '</section>';
        } else {
            $message = '<p class="notify">Sorry, no spells have been created.</p>';
        }


        include 'view/spells.php';
}


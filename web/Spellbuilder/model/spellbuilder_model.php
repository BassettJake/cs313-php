<?php 

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
    $sql = 'SELECT * FROM durations_lists AS d WHERE d.spell_id = :spellId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':spellId', $spellId, PDO::PARAM_INT);
    $stmt->execute();
    $durations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $durations;
}

function getTargets($db, $spellId){
    $sql = 'SELECT * FROM targets_lists AS t WHERE t.spell_id = :spellId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':spellId', $spellId, PDO::PARAM_INT);
    $stmt->execute();
    $targets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $targets;
}

function getList($db, $charId){
    $sql = 'SELECT * FROM spell_lists AS l WHERE l.character_id = :charId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':charId', $charId, PDO::PARAM_INT);
    $stmt->execute();
    $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $list;
}

function getCharacters($db){
    $sql = 'SELECT * FROM characters AS c';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $chars = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $chars;
}

function getCharacter($db, $charId){
    $sql = 'SELECT *  FROM characters AS c WHERE c.id = :charId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':charId', $charId, PDO::PARAM_INT);
    $stmt->execute();
    $char = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $char;
}

function getListSpells($db, $spellId){
    $sql = 'SELECT * FROM spells AS s WHERE s.id = :spellId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':spellId', $spellId, PDO::PARAM_INT);
    $stmt->execute();
    $spell = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $spell;
}

function getMissingListSpells($db, $listItems){

    $sql = 'SELECT * FROM spells AS s WHERE s.id NOT IN (';
    $i = 0;
    foreach ($listItems as $l){
        if($i == 0){
            $sql .= $l['id'];
            $i++;
        }
        else{
            $sql .= ',' . $l['id'];
        }
    
    }
    $sql .= ')';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $spell = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $spell;
}

function getFilteredCharacters($db, $searchBox){
    $sql = "SELECT *  FROM characters AS c WHERE c.name LIKE '%" . $searchBox . "%'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $chars = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $chars;
}

function getFilteredSpells($db, $searchBox){
    $sql = "SELECT *  FROM spells AS s WHERE s.name LIKE '%" . $searchBox . "%'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $spells = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $spells;
}

?>
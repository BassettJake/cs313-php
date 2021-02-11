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
    $sql = 'SELECT * FROM characters ORDER BY name ASC';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $chars = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $chars;
}

function getCharacter($db, $charId){
    $sql = 'SELECT *  FROM characters AS c WHERE c.id = :charId  ORDER BY name ASC';
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
            $sql .= $l['spell_id'];
            $i++;
        }
        else{
            $sql .= ',' . $l['spell_id'];
        }
    
    }
    $sql .= ') ORDER BY name ASC';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $spell = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $spell;
}

function getFilteredCharacters($db, $searchBox){
    $sql = "SELECT *  FROM characters AS c WHERE c.name LIKE '%" . $searchBox . "%'  ORDER BY name ASC";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $chars = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $chars;
}

function getFilteredSpells($db, $searchBox){
    $sql = "SELECT *  FROM spells AS s WHERE s.name LIKE '%" . $searchBox . "%'  ORDER BY name ASC";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $spells = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $spells;
}

function createCharacter($db, $charName){
   $sql = 'INSERT INTO characters (name) VALUES (:charName)';
   $stmt = $db->prepare($sql);
   $stmt->bindValue(':charName', $charName, PDO::PARAM_STR);
   $stmt->execute();
   $rows = $stmt->rowCount();
   $stmt->closeCursor();
   return $rows;
}

function createSpell($db, $name, $desc, $castTime, $casterType, $cost, $range){
    $sql = 'INSERT INTO spells (name, description, casttime, range, castertype, cost) VALUES (:name, :desc, :castTime, :range, :casterType, :cost)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':desc', $desc, PDO::PARAM_STR);
    $stmt->bindValue(':castTime', $castTime, PDO::PARAM_STR);
    $stmt->bindValue(':casterType', $casterType, PDO::PARAM_STR);
    $stmt->bindValue(':cost', $cost, PDO::PARAM_INT);
    $stmt->bindValue(':range', $range, PDO::PARAM_STR);
    $stmt->execute();
    $rows = $stmt->rowCount();
    $stmt->closeCursor();
    return $rows;
}

function getLastSpellId($db){
    $sql = 'SELECT id FROM spells ORDER BY id DESC LIMIT 1';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $spellId = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $spellId;
}

function createEffects($db, $spellId, $val){
    $sql = 'INSERT INTO effects_lists (spell_id, name) VALUES (:spellId, :val)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':spellId', $spellId, PDO::PARAM_INT);
    $stmt->bindValue(':val', $val, PDO::PARAM_STR);
    $stmt->execute();
    $rows = $stmt->rowCount();
    $stmt->closeCursor();
    return $rows;
}

function createDurations($db, $spellId, $val){
    $sql = 'INSERT INTO durations_lists (spell_id, name) VALUES (:spellId, :val)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':spellId', $spellId, PDO::PARAM_INT);
    $stmt->bindValue(':val', $val, PDO::PARAM_STR);
    $stmt->execute();
    $rows = $stmt->rowCount();
    $stmt->closeCursor();
    return $rows;
}

function createTargets($db, $spellId, $val){
    $sql = 'INSERT INTO targets_lists (spell_id, name) VALUES (:spellId, :val)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':spellId', $spellId, PDO::PARAM_INT);
    $stmt->bindValue(':val', $val, PDO::PARAM_STR);
    $stmt->execute();
    $rows = $stmt->rowCount();
    $stmt->closeCursor();
    return $rows;
}

function deleteEffects($db, $spellId){
    $sql = 'DELETE FROM effects_lists WHERE spell_id = :spellId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':spellId', $spellId, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->rowCount();
    $stmt->closeCursor();
    return $rows;
}

function deleteDurations($db, $spellId){
    $sql = 'DELETE FROM durations_lists WHERE spell_id = :spellId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':spellId', $spellId, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->rowCount();
    $stmt->closeCursor();
    return $rows;
}

function deleteTargets($db, $spellId){
    $sql = 'DELETE FROM targets_lists WHERE spell_id = :spellId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':spellId', $spellId, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->rowCount();
    $stmt->closeCursor();
    return $rows;
}

function deleteSpell($db, $spellId){
    $sql = 'DELETE FROM spells WHERE id = :spellId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':spellId', $spellId, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->rowCount();
    $stmt->closeCursor();
    return $rows;
}

function removeSpell($db, $charId, $spellId){
    $sql = 'DELETE FROM spell_lists as l WHERE l.spell_id = :spellId AND l.character_id = :charId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':spellId', $spellId, PDO::PARAM_INT);
    $stmt->bindValue(':charId', $charId, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->rowCount();
    $stmt->closeCursor();
    return $rows;
}

function addToSpellList($db, $charId, $spellId){
    $sql = 'INSERT INTO spell_lists (spell_id, character_id) VALUES (:spellId, :charId)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':spellId', $spellId, PDO::PARAM_INT);
    $stmt->bindValue(':charId', $charId, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->rowCount();
    $stmt->closeCursor();
    return $rows;
}

function deleteCharacter($db, $charName){
    $sql = 'DELETE FROM characters WHERE name = :charName';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':charName', $charName, PDO::PARAM_STR);
    $stmt->execute();
    $rows = $stmt->rowCount();
    $stmt->closeCursor();
    return $rows;
}

function deleteSpellList($db, $charName){
    $sql = 'DELETE FROM spell_lists as l WHERE l.character_id = (SELECT id FROM characters AS c WHERE c.name = :charName)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':charName', $charName, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->rowCount();
    $stmt->closeCursor();
    return $rows;
}

function checkSpellList($db, $charName){
    $sql = 'SELECT * FROM spell_lists as l WHERE l.character_id = (SELECT id FROM characters AS c WHERE c.name = :charName)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':charName', $charName, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->rowCount();
    $stmt->closeCursor();
    return $rows;
}

function editSpell($db, $spellId, $name, $desc, $castTime, $casterType, $cost, $range){
    $sql = 'UPDATE spells SET name = :name, description = :desc, casttime = :castTime, castertype = :casterType, cost = :cost, range = :range WHERE id = :spellId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':spellId', $spellId, PDO::PARAM_INT);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':desc', $desc, PDO::PARAM_STR);
    $stmt->bindValue(':castTime', $castTime, PDO::PARAM_STR);
    $stmt->bindValue(':casterType', $casterType, PDO::PARAM_STR);
    $stmt->bindValue(':cost', $cost, PDO::PARAM_INT);
    $stmt->bindValue(':range', $range, PDO::PARAM_STR);
    $stmt->execute();
    $rows = $stmt->rowCount();
    $stmt->closeCursor();
    return $rows;
}
function editEffects($db, $spellId, $val){
    $sql = 'UPDATE effects_lists SET name = :val WHERE spell_id = :spellId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':spellId', $spellId, PDO::PARAM_INT);
    $stmt->bindValue(':val', $val, PDO::PARAM_STR);
    $stmt->execute();
    $rows = $stmt->rowCount();
    $stmt->closeCursor();
    return $rows;
}

function editDurations($db, $spellId, $val){
    $sql = 'UPDATE durations_lists SET name = :val WHERE spell_id = :spellId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':spellId', $spellId, PDO::PARAM_INT);
    $stmt->bindValue(':val', $val, PDO::PARAM_STR);
    $stmt->execute();
    $rows = $stmt->rowCount();
    $stmt->closeCursor();
    return $rows;
}

function editTargets($db, $spellId, $val){
    $sql = 'UPDATE targets_lists SET name = :val WHERE spell_id = :spellId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':spellId', $spellId, PDO::PARAM_INT);
    $stmt->bindValue(':val', $val, PDO::PARAM_STR);
    $stmt->execute();
    $rows = $stmt->rowCount();
    $stmt->closeCursor();
    return $rows;
}
?>
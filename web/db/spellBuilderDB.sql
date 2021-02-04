CREATE TABLE spells(
id int primary key,
name varchar,
description varchar,
castTime varchar,
range varchar,
casterType varchar,
cost int);

CREATE TABLE characters(
id int primary key,
name varchar);

CREATE TABLE effects_lists(
id int primary key,
spell_id int references spells(id),
name varchar);

CREATE TABLE durations_lists(
id int primary key,
spell_id int references spells(id),
name varchar);

CREATE TABLE targets_lists(
id int primary key,
spell_id int references spells(id),
name varchar);

ALTER TABLE spells ADD COLUMN effectsList_id int references effects_lists(id);
ALTER TABLE spells ADD COLUMN durationsList_id int references durations_lists(id);
ALTER TABLE spells ADD COLUMN targetsList_id int references targets_lists(id);

CREATE TABLE spell_lists(
id int primary key,
spell_id int references spells(id),
character_id int references characters(id));

INSERT INTO effects_lists (id, spell_id, name) VALUES
(3, 'Supreme');

INSERT INTO durations_lists(spell_id, name) VALUES
(3, 'Instant');

INSERT INTO targets_lists(spell_id, name) VALUES
(3, 'Single');

INSERT INTO effects_lists (spell_id, name) VALUES
(4, 'Greater');

INSERT INTO durations_lists(spell_id, name) VALUES
(4, 'Instant');

INSERT INTO targets_lists(spell_id, name) VALUES
(4, 'Single');

SELECT * FROM spells AS s WHERE s.id NOT IN (1,2)

SELECT spell_id FROM spell_lists WHERE character_id = 1;
SELECT * FROM spells AS s WHERE s.id !~~ (SELECT spell_id FROM spell_lists WHERE character_id = 1);
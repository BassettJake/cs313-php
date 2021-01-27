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
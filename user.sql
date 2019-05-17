CREATE TABLE pentathanerd.user
(
    id int(11) PRIMARY KEY NOT NULL,
    first_name text NOT NULL,
    last_name text NOT NULL,
    email text NOT NULL,
    image text
);
CREATE UNIQUE INDEX user_id_uindex ON pentathanerd.user (id);
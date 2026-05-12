-- 002_add_parent_id_to_roles.sql

ALTER TABLE roles ADD COLUMN parent_id INT NULL DEFAULT NULL AFTER id;
ALTER TABLE roles ADD CONSTRAINT fk_roles_parent FOREIGN KEY (parent_id) REFERENCES roles(id) ON DELETE SET NULL;

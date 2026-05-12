-- 003_add_responsable_id_to_services.sql

ALTER TABLE services ADD COLUMN responsable_id INT NULL DEFAULT NULL AFTER description;
ALTER TABLE services ADD CONSTRAINT fk_services_responsable FOREIGN KEY (responsable_id) REFERENCES users(id) ON DELETE SET NULL;

-- This UPDATE statement is for data manipulation, not schema.
-- It's generally better to handle data seeding/updates separately or
-- ensure your application handles default values.
-- For now, I'll include it, but be aware of its nature.
-- UPDATE services SET responsable_id = (SELECT id FROM users WHERE categorie = 'responsable_directeur' LIMIT 1) WHERE responsable_id IS NULL;

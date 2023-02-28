/* В базе данных shop и sample присутствуют одни и те же таблицы.
 * Переместите запись id = 1 из таблицы shop.users в таблицу sample.users. Используйте транзакции. */
START TRANSACTION;
SELECT @maxID := MAX(id) FROM sample.users;
INSERT INTO sample.users
SELECT @maxID + 1, name, birthday_at, created_at, updated_at FROM shop.users WHERE shop.users.id = 1;
DELETE FROM shop.users WHERE shop.users.id = 1;
COMMIT;
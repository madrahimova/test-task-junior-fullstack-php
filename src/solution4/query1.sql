/* Составьте список пользователей users,
   которые осуществили хотя бы один заказ orders в интернет магазине. */
SELECT name FROM users
INNER JOIN orders ON users.id = orders.user_id
GROUP BY user_id;
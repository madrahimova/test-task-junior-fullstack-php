/* Выведите одного случайного пользователя из таблицы shop.users, старше 30 лет,
   сделавшего минимум 3 заказа за последние полгода */
SELECT name from users INNER JOIN orders ON users.id = orders.user_id
WHERE YEAR(NOW()) - YEAR(birthday_at) > 30 AND orders.updated_at >= NOW() - INTERVAL 6 MONTH
GROUP BY name
HAVING COUNT(orders.id) >= 3
ORDER BY RAND()
LIMIT 1;
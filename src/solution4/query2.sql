/* Выведите список товаров products и разделов catalogs, который соответствует товару. */
SELECT products.name, catalogs.name FROM products
INNER JOIN catalogs ON products.catalog_id = catalogs.id;
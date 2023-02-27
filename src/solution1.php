<?php

namespace src;

use InvalidArgumentException;
use SplQueue;

// Список районов
$areas = array(
    1 => '5-й поселок',
    2 => 'Голиковка',
    3 => 'Древлянка',
    4 => 'Заводская',
    5 => 'Зарека',
    6 => 'Ключевая',
    7 => 'Кукковка',
    8 => 'Новый сайнаволок',
    9 => 'Октябрьский',
    10 => 'Первомайский',
    11 => 'Перевалка',
    12 => 'Сулажгора',
    13 => 'Университетский городок',
    14 => 'Центр',
);

// Близкие районы, связь осуществляется по индентификатору района из массива $areas
$nearby = array(
    1 => array(2, 11),
    2 => array(12, 3, 6, 8),
    3 => array(11, 13),
    4 => array(10, 9, 13),
    5 => array(2, 6, 7, 8),
    6 => array(10, 2, 7, 8),
    7 => array(2, 6, 8),
    8 => array(6, 2, 7, 12),
    9 => array(10, 14),
    10 => array(9, 14, 12),
    11 => array(13, 1, 9),
    12 => array(1, 10),
    13 => array(11, 1, 8),
    14 => array(9, 10),
);

// список сотрудников
$workers = array(
    0 => array(
        'login' => 'login1',
        'area_name' => 'Октябрьский', //9
    ),
    1 => array(
        'login' => 'login2',
        'area_name' => 'Зарека', //5
    ),
    2 => array(
        'login' => 'login3',
        'area_name' => 'Сулажгора', //12
    ),
    3 => array(
        'login' => 'login4',
        'area_name' => 'Древлянка', //3
    ),
    4 => array(
        'login' => 'login5',
        'area_name' => 'Центр', //14
    ),
);

// Посещенные районы
$visited = array();

// Ближайшие районы к заданному
$nearby_workers = array();

/**
 * Поиск в ширину
 * Допустим, что $nearby[$index] отсортирован по близости к району $index
 * Тогда 1-й элемент $nearby_workers - ближайший сотрудник
 * @param $index int индекс района, из которого начинаем поиск
 */
function bfs(int $index): void
{
    global $areas, $nearby, $workers, $visited, $nearby_workers;
    $queue = new SplQueue();
    $queue->enqueue($index);
    $visited[] = $index;
    while (!$queue->isEmpty()) {
        $area_index = $queue->dequeue();
        foreach ($workers as $worker) {
            if ($worker["area_name"] == $areas[$area_index])
                $nearby_workers[] = $worker["login"];
        }
        foreach ($nearby[$area_index] as $nearby_index) {
            if (!in_array($nearby_index, $visited)) {
                $visited[] = $nearby_index;
                $queue->enqueue($nearby_index);
            }
        }
    }
}

/**
 * Усложнение: поиск близких сотрудников
 * @param string $area название района, для которого нужно найти близких сотрудников
 */
function find_nearby_workers(string $area): ?array
{
    global $areas, $nearby_workers;
    if (!in_array($area, $areas)) {
        return null;
    }
    bfs(array_search($area, $areas));
    return $nearby_workers;
}
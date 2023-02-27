<?php
$list = array(
    '09:00-11:00',
    '11:00-13:00',
    '15:00-16:00',
    '17:00-20:00',
    '20:30-21:30',
    '21:30-22:30',
);

/**
 * Разбиение интервала на начало и конец
 * @param string $interval интервал для разбиения
 * @return array начало и конец интервала
 */
function get_parts(string $interval): array
{
    return explode("-", $interval);
}

/**
 * @param string $interval временной интервал в формате "чч:мм"
 * @return bool интервал валиден?
 */
function is_valid(string $interval): bool
{
    $parts = get_parts($interval);
    foreach ($parts as $part) {
        $time = DateTime::createFromFormat("H:i", $part);
        if (!($time instanceof DateTime) || $time->format("H:i") != $part)
            return false;
    }
    return true;
}

/**
 * Вспомогательная проверка в случае, если $list зациклен
 * @return bool есть пересечение?
 */
function intersect($new_start, $new_end, $start, $end): bool
{
    if ($new_start >= $new_end) {
        if ($start >= $end)
            return true;
        return intersect($start, $end, $new_start, $new_end);
    }
    if ($start > $end)
        return $start <= $new_end || $end >= $new_start;
    else
        return $start <= $new_end && $end >= $new_start;
}

/**
 * Проверка на пересечение временного интервала с интервалами из $list
 * @param string $new_interval временной интервал для проверки
 * @return bool есть пересечение?
 */
function is_intersect(string $new_interval): bool
{
    if (!is_valid($new_interval))
        throw new InvalidArgumentException("Invalid time range specified");
    $parts = get_parts($new_interval);
    $new_start = strtotime($parts[0]);
    $new_end = strtotime($parts[1]);
    global $list;
    foreach ($list as $interval) {
        $parts = get_parts($interval);
        $start = strtotime($parts[0]);
        $end = strtotime($parts[1]);
        if (intersect($new_start, $new_end, $start, $end))
            return true;
    }
    return false;
}
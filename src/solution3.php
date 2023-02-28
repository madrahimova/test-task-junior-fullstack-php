<?php

/**
 * @charset UTF-8
 *
 * Задание 3
 * В данный момент компания X работает с двумя перевозчиками
 * 1. Почта России
 * 2. DHL
 * У каждого перевозчика своя формула расчета стоимости доставки посылки
 * Почта России до 10 кг берет 100 руб, все что cвыше 10 кг берет 1000 руб
 * DHL за каждый 1 кг берет 100 руб
 * Задача:
 * Необходимо описать архитектуру на php из методов или классов для работы с
 * перевозчиками на предмет получения стоимости доставки по каждому из указанных
 * перевозчиков, согласно данным формулам.
 * При разработке нужно учесть, что количество перевозчиков со временем может
 * возрасти. И делать расчет для новых перевозчиков будут уже другие программисты.
 * Поэтому необходимо построить архитектуру так, чтобы максимально минимизировать
 * ошибки программиста, который будет в дальнейшем делать расчет для нового
 * перевозчика, а также того, кто будет пользоваться данным архитектурным решением.
 *
 */

class Parcel
{
    /**
     * @var float вес посылки в кг
     */
    private float $weight = 0;

    public function __construct(float $weight)
    {
        $this->set_weight($weight);
    }

    public function get_weight(): float
    {
        return $this->weight;
    }

    public function set_weight(float $weight): void
    {
        if ($weight <= 0)
            throw new InvalidArgumentException("Zero or negative weight specified");
        $this->weight = $weight;
    }
}

abstract class Carrier
{
    /**
     * Расчет стоимости доставки посылки
     * @param Parcel $parcel описывает посылку с весом $weight
     * @return float стоимость доставки в руб
     */
    abstract static function get_delivery_cost(Parcel $parcel): float;
}

class RussianPost extends Carrier
{
    static function get_delivery_cost(Parcel $parcel): float
    {
        return $parcel->get_weight() < 10 ? 100 : 1000;
    }
}

class DHL extends Carrier
{
    static function get_delivery_cost(Parcel $parcel): float
    {
        return $parcel->get_weight() * 100;
    }
}



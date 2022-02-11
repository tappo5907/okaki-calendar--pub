<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

class CareCategory extends Enum
{
    public const EXCHANGE_WATER = 1;
    public const EXCHANGE_FILTER = 2;
    public const HOSPITAL = 3;
    public const FOOD_SUPPLY = 4;
    public const OTHER = 5;
    
    /**
     * @param string $key
     * @return int|mixed
     */
    public static function getName(int $value)
    {
        switch ($value) {
            case self::EXCHANGE_WATER:
                return '水交換';
            case self::EXCHANGE_FILTER:
                return 'フィルター交換';
            case self::HOSPITAL:
                return '病院';
            case self::FOOD_SUPPLY:
                return 'ごはん補給';
            case self::OTHER:
                return 'その他';
            default:
                throw new \Exception('指定の値は定義されていません。');
        }
    }
    
    public static function getAll()
    {
        return [
            self::EXCHANGE_WATER => self::getName(self::EXCHANGE_WATER),
            self::EXCHANGE_FILTER => self::getName(self::EXCHANGE_FILTER),
            self::HOSPITAL => self::getName(self::HOSPITAL),
            self::FOOD_SUPPLY => self::getName(self::FOOD_SUPPLY),
            self::OTHER => self::getName(self::OTHER),
        ];
    }
}
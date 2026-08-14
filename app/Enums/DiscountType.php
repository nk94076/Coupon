<?php

namespace App\Enums;

enum DiscountType: string
{
    case Percentage = 'percentage';
    case Flat = 'flat';
    case FreeShipping = 'free_shipping';
    case Cashback = 'cashback';
    case BuyOneGetOne = 'buy_one_get_one';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Percentage => 'Percentage Off',
            self::Flat => 'Flat Amount Off',
            self::FreeShipping => 'Free Shipping',
            self::Cashback => 'Cashback',
            self::BuyOneGetOne => 'Buy One Get One',
            self::Other => 'Other',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return array_combine(
            array_map(fn (self $case) => $case->value, self::cases()),
            array_map(fn (self $case) => $case->label(), self::cases()),
        );
    }
}

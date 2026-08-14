<?php

namespace App\Enums;

/**
 * Primary classification of a coupon. Kept separate from the boolean
 * new_user/app_only/bank_offer/student tags so a coupon can carry one
 * primary classification while still being tagged for extra filters.
 */
enum CouponType: string
{
    case General = 'general';
    case NewUser = 'new_user';
    case AppOnly = 'app_only';
    case BankOffer = 'bank_offer';
    case Student = 'student';
    case Exclusive = 'exclusive';

    public function label(): string
    {
        return match ($this) {
            self::General => 'General',
            self::NewUser => 'New User',
            self::AppOnly => 'App Only',
            self::BankOffer => 'Bank Offer',
            self::Student => 'Student',
            self::Exclusive => 'Exclusive',
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

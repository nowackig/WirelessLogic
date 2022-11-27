<?php

namespace WirelessLogic\Application\Enums;

enum TimeMapEnum: string
{
    case MONTH = 'Month';
    case YEAR = 'Year';

    public function months(): int
    {
        return match ($this) {
            TimeMapEnum::MONTH => 1,
            TimeMapEnum::YEAR => 12,
        };
    }

    public static function byMonthsNumber(int $months): ?TimeMapEnum
    {
        return match ($months) {
            1 => TimeMapEnum::MONTH,
            12 => TimeMapEnum::YEAR,
            default => null,
        };
    }

    public static function values(): array
    {
        return array_column(TimeMapEnum::cases(), 'value');
    }
}

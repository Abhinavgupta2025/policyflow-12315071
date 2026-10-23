<?php

namespace App\Services;

use Carbon\Carbon;
use InvalidArgumentException;

class PremiumCalculator
{
    public const BASE_RATES = [
        'BASIC' => '12.00',
        'PLUS' => '20.00',
        'PREMIUM' => '30.00',
    ];

    public const DESTINATION_MULTIPLIERS = [
        'DOMESTIC' => '1.00',
        'INTERNATIONAL' => '1.80',
    ];

    public const COVERAGE_MULTIPLIERS = [
        100000 => '1.00',
        300000 => '1.25',
        500000 => '1.50',
    ];

    /**
     * Calculate premium and return breakdown.
     *
     * @throws InvalidArgumentException
     */
    public function calculate(
        string $planCode,
        string $destination,
        int|string $sumInsured,
        string $dob,
        string $tripStart,
        string $tripEnd
    ): array {
        $planCode = strtoupper(trim($planCode));
        $destination = strtoupper(trim($destination));
        $sumInsured = (int) $sumInsured;

        if (! isset(self::BASE_RATES[$planCode])) {
            throw new InvalidArgumentException("Unsupported plan code: {$planCode}. Supported plans: " . implode(', ', array_keys(self::BASE_RATES)));
        }

        if (! isset(self::DESTINATION_MULTIPLIERS[$destination])) {
            throw new InvalidArgumentException("Unsupported destination: {$destination}. Supported: DOMESTIC, INTERNATIONAL");
        }

        if (! isset(self::COVERAGE_MULTIPLIERS[$sumInsured])) {
            throw new InvalidArgumentException("Unsupported sum insured: {$sumInsured}. Supported amounts: 100000, 300000, 500000");
        }

        $startDate = Carbon::parse($tripStart)->startOfDay();
        $endDate = Carbon::parse($tripEnd)->startOfDay();

        if ($endDate->lt($startDate)) {
            throw new InvalidArgumentException("Trip end date ({$tripEnd}) must be greater than or equal to trip start date ({$tripStart}).");
        }

        // Inclusive travel days: trip_end - trip_start + 1; minimum 1
        $travelDays = max(1, $startDate->diffInDays($endDate) + 1);

        // Age on trip start date
        $birthDate = Carbon::parse($dob)->startOfDay();
        $ageAtTripStart = (int) $birthDate->diff($startDate)->y;

        $ageMultiplier = $this->getAgeMultiplier($ageAtTripStart);
        $baseDailyRate = self::BASE_RATES[$planCode];
        $destMultiplier = self::DESTINATION_MULTIPLIERS[$destination];
        $covMultiplier = self::COVERAGE_MULTIPLIERS[$sumInsured];

        // Decimal-safe formula:
        // premium = base_daily_rate * travel_days * age_multiplier * destination_multiplier * coverage_multiplier
        // Using bcmath with precision 6 and rounding to 2 decimal places
        $rateXdays = bcmul($baseDailyRate, (string) $travelDays, 6);
        $withAge = bcmul($rateXdays, $ageMultiplier, 6);
        $withDest = bcmul($withAge, $destMultiplier, 6);
        $totalRaw = bcmul($withDest, $covMultiplier, 6);

        // Standard decimal-safe round half up to 2 decimals
        $roundedPremium = number_format((float) $totalRaw, 2, '.', '');

        return [
            'premium' => $roundedPremium,
            'travel_days' => $travelDays,
            'age_at_trip_start' => $ageAtTripStart,
            'base_daily_rate' => (float) $baseDailyRate,
            'age_multiplier' => (float) $ageMultiplier,
            'destination_multiplier' => (float) $destMultiplier,
            'coverage_multiplier' => (float) $covMultiplier,
            'formula' => "{$baseDailyRate} x {$travelDays} days x {$ageMultiplier} x {$destMultiplier} x {$covMultiplier} = ₹{$roundedPremium}",
        ];
    }

    /**
     * Age multiplier (on trip start):
     * 0–17: 1.10; 18–60: 1.00; 61–70: 1.50; 71+: 2.00
     */
    public function getAgeMultiplier(int $age): string
    {
        if ($age < 0) {
            throw new InvalidArgumentException("Date of birth cannot be after trip start date.");
        }

        if ($age <= 17) {
            return '1.10';
        }

        if ($age <= 60) {
            return '1.00';
        }

        if ($age <= 70) {
            return '1.50';
        }

        return '2.00';
    }
}

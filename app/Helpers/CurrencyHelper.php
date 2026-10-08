<?php

namespace App\Helpers;

class CurrencyHelper
{
    private const EXCHANGE_RATE = 1500; // 1 USD = 1500 NGN (FIXED)
    
    private const SYMBOLS = [
        'USD' => '$',
        'NGN' => '₦',
    ];

    /**
     * get symbol
     */
    public static function symbol($currency)
    {
        
        // Get symbol
        $symbol = self::SYMBOLS[$currency] ?? $currency;
        
        return $symbol;
    }


    /**
     * Format currency with conversion
     */
    public static function format($amount, $from = 'NGN', $to = 'NGN',$decimals = 2)
    {
        // Convert amount
        $converted = self::convert($amount, $from, $to);
        
        // Get symbol
        $symbol = self::SYMBOLS[$to] ?? $to;
        
        // Format: USD has 2 decimals, NGN has 0
        $formatted = number_format($converted, $decimals);
        
        return $symbol . $formatted;
    }

    /**
     * Convert between USD and NGN
     */
    public static function convert($amount, $from, $to)
    {
        if ($from === $to) {
            return $amount;
        }

        // NGN → USD: divide by 1500
        if ($from === 'NGN' && $to === 'USD') {
            return $amount / self::EXCHANGE_RATE;
        }
        
        // USD → NGN: multiply by 1500
        if ($from === 'USD' && $to === 'NGN') {
            return $amount * self::EXCHANGE_RATE;
        }
        
        return $amount;
    }
}
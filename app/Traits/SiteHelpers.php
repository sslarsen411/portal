<?php

namespace App\Traits;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Collection;

trait SiteHelpers {
    function getStatus($inID): string
    {
        //ray(session('stripe.status'));
        return Subscription::where('user_id', $inID)->pluck('stripe_status');
    }

    function getCompany($inID): Collection
    {
        return User::where('id', $inID)->pluck('company');
    }

    /**
     * Convert a phone input to E164
     * @param  string  $inPh
     * @param  string|int  $inCC  DEFAULT 1
     * @return string
     */
    static function toE164(string $inPh, string|int $inCC = '1'): string
    {
        return "+$inCC".preg_replace('/\D+/', '', $inPh);
    }

    /**
     * Format an E164 phone number to (NNN) NNN-NNNN
     * @param  string|int  $inNumber
     * @return string
     */
    static function fromE164(string|int $inNumber): string
    {
        preg_match('/\d?(\d{3})(\d{3})(\d{4})/', $inNumber, $matches);
        return '('.$matches[1].') '.$matches[2].'-'.$matches[3];
    }
}

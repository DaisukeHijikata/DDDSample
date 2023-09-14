<?php
namespace App\Models\Amazon\Domain\Object\Entity;
use Carbon\Carbon;

class OrderRequestPeriod
{
    const ISO8601_FORMAT = 'Y-m-d\TH:i:s\Z';
    const TIME_ZONE = "UTC";


    private Carbon $start_at;
    private Carbon $end_at;

    public function __construct()
    {}

    public static function create(string $start_at ,string $end_at) :OrderRequestPeriod
    {
        $instance = new OrderRequestPeriod();
        $instance->start_at = Carbon::parse($instance->convertISO8601Format($start_at));
        $instance->end_at = Carbon::parse($instance->convertISO8601Format($end_at));
        return $instance;
    }

    public function convertISO8601Format(string $date) :string
    {
        return Carbon::parse($date)->setTimezone(self::TIME_ZONE)->toISOString();
    }


    /**
     * @return Carbon
     */
    public function startAt(): Carbon
    {
        return $this->start_at;
    }

    /**
     * @return Carbon
     */
    public function endAt(): Carbon
    {
        return $this->end_at;
    }

}
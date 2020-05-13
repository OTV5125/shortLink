<?php
/**
 * Created by PhpStorm.
 * User: mihailnilov
 * Date: 13.05.2020
 * Time: 14:27
 */

namespace App\Services\Redis;

use Illuminate\Support\Facades\Redis;

abstract class RedisWork
{
    public $redisConnection = true;

    public function __construct()
    {
        try {
            Redis::connection('default');
        } catch (\Exception $e) {
            $this->redisConnection = false;
        }
    }
}
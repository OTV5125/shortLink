<?php
/**
 * Created by PhpStorm.
 * User: mihailnilov
 * Date: 13.05.2020
 * Time: 15:32
 */

namespace App\Services\Redis;

use Illuminate\Support\Facades\Redis;

class RedisLink extends RedisWork
{
    public $ex = 86400;

    public function setLink($code, $meta)
    {
        if ($this->redisConnection === false) {
            return false;
        }
        if (Redis::set($code, 1, 'EX', $this->ex)) {
            foreach ($meta AS $i => $item) {
                if (!Redis::set($code . ':' . $i, $item, 'EX', $this->ex)) {
                    Redis::del($code);
                    return false;
                }
            }
        }
        return true;
    }

    protected function timeoutLink($code, $meta)
    {
        if (Redis::expire($code, $this->ex)) {
            foreach ($meta AS $i => $item) {
                Redis::expire($code . ':' . $i, $this->ex);
            }
        }
        return true;
    }

    public function getLink($code, $columnName)
    {
        if ($this->redisConnection === false) {
            return false;
        }
        if (!Redis::exists($code)) {
            return false;
        } else {
            $meta = [];
            foreach ($columnName as $item) {
                $meta[$item] = Redis::get($code . ':' . $item);
            }
            $this->timeoutLink($code, $meta);
            return $meta;
        }
    }
}
<?php

/**
 * Redis Helper class provides methods to interact with Redis cache, lists, sessions, queues, and Pub/Sub
 * author: krutik
 */

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Queue;

class RedisHelper
{
    /**
     * Store data in Redis cache.
     * @param string $key
     * @param mixed $value
     * @param int $expirySeconds
     */
    public static function cacheSet($key, $value, $expirySeconds = 3600)
    {
        Cache::put($key, $value, $expirySeconds);
    }

    /**
     * Retrieve data from Redis cache.
     * @param string $key
     * @return mixed
     */
    public static function cacheGet($key)
    {
        return Cache::get($key);
    }

    /**
     * Delete data from Redis cache.
     * @param string $key
     */
    public static function cacheForget($key)
    {
        Cache::forget($key);
    }

    /**
     * Check if a cache key exists.
     * @param string $key
     * @return bool
     */
    public static function cacheExists($key)
    {
        return Cache::has($key);
    }

    /**
     * Append data to a Redis list (LPUSH)
     * @param string $key
     * @param mixed $value
     */
    public static function listPushLeft($key, $value)
    {
        Redis::lpush($key, $value);
    }

    /**
     * Append data to a Redis list (RPUSH)
     * @param string $key
     * @param mixed $value
     */
    public static function listPushRight($key, $value)
    {
        Redis::rpush($key, $value);
    }

    /**
     * Retrieve a range of values from a Redis list
     * @param string $key
     * @param int $start
     * @param int $end
     * @return array
     */
    public static function listGetRange($key, $start = 0, $end = -1)
    {
        return Redis::lrange($key, $start, $end);
    }

    /**
     * Manage Redis sessions (Custom Session Handling if needed)
     * @param string $key
     * @param mixed $value
     * @param int $expirySeconds
     */
    public static function setSession($key, $value, $expirySeconds = 3600)
    {
        Redis::setex("session:$key", $expirySeconds, json_encode($value));
    }

    /**
     * Retrieve a session value from Redis
     * @param string $key
     * @return mixed
     */
    public static function getSession($key)
    {
        return json_decode(Redis::get("session:$key"), true);
    }

    /**
     * Delete a session from Redis
     * @param string $key
     */
    public static function deleteSession($key)
    {
        Redis::del("session:$key");
    }

    /**
     * Push a job to Redis queue
     * @param string $queue
     * @param mixed $jobData
     */
    public static function pushToQueue($queue, $jobData)
    {
        Queue::connection('redis')->push($queue, $jobData);
    }

    /**
     * Publish a message to Redis channel (Pub/Sub)
     * @param string $channel
     * @param mixed $message
     */
    public static function publish($channel, $message)
    {
        Redis::publish($channel, $message);
    }

    /**
     * Subscribe to a Redis channel (Used in event listeners)
     * @param string $channel
     * @param callable $callback
     */
    public static function subscribe($channel, $callback)
    {
        Redis::subscribe([$channel], function ($message) use ($callback) {
            $callback($message);
        });
    }

    /**
     * Set a value with an expiration time using Redis SETEX
     * @param string $key
     * @param mixed $value
     * @param int $expirySeconds
     */
    public static function setWithExpire($key, $value, $expirySeconds)
    {
        Redis::setex($key, $expirySeconds, $value);
    }

    /**
     * Increment a Redis key value (Atomic operation)
     * @param string $key
     * @param int $amount
     * @return int
     */
    public static function increment($key, $amount = 1)
    {
        return Redis::incrBy($key, $amount);
    }

    /**
     * Decrement a Redis key value (Atomic operation)
     * @param string $key
     * @param int $amount
     * @return int
     */
    public static function decrement($key, $amount = 1)
    {
        return Redis::decrBy($key, $amount);
    }
}

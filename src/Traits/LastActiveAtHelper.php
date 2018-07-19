<?php

namespace Cblink\ActiveUser\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

trait LastActiveAtHelper
{
    protected $hash_prefix = 'cblink_last_active_at_';

    protected $field_prefix = 'user_';

    public function recordLastActiveAt()
    {
        // Redis 哈希表的命名，如：cblink_last_active_at_2018-07-15
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());

        // 字段名称，如: user_1
        $field = $this->getHashField();

        // 当前时间，如 2018-07-15 03:56:51
        $now = Carbon::now()->toDateTimeString();

        // 数据写入 Redis，字段已存在的会被更新
        Redis::hSet($hash, $field, $now);
    }

    public function recordUserActiveLog()
    {
        $yesterday = Carbon::yesterday();

        $activeAtBetween = [
            $yesterday->startOfDay(), $yesterday->endOfDay(),
        ];

        $users = static::whereBetween($activeAtBetween)->get();

        foreach ($users as $user) {
            $user->recordUserActiveLogs()->create([
                'last_active_at' => $user->last_active_at,
                'active_log_at' => $yesterday->startOfDay(),
            ]);
        }
    }

    public function syncUserActiveAt()
    {
        $hash = $this->getHashFromDateString(Carbon::yesterday()->toDateString());

        // 从 Redis 中获取所有哈希表里的数据
        $dates = Redis::hGetAll($hash);

        // 遍历，并同步到数据库中
        foreach ($dates as $user_id => $active_at) {
            // 会将 `user_1` 转换为 1
            $user_id = str_replace($this->field_prefix, '', $user_id);

            // 只有当用户存在时才更新到数据库中
            if ($user = $this->find($user_id)) {
                $user->last_active_at = $active_at;
                $user->save();
            }
        }

        // 以数据库为中心的存储，既已同步，即可删除
        Redis::del($hash);
    }

    public function getLastActiveAtAttribute($value)
    {
        // Redis 哈希表的命名，如：cblink_last_active_at_2018-07-15
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());

        // 字段名称，如：user_1
        $field = $this->getHashField();

        // 三元运算符，优先选择 Redis 的数据，否则使用数据库中
        $datetime = Redis::hGet($hash, $field) ?: $value;

        // 如果存在的话，返回时间对应的 Carbon 实体
        if ($datetime) {
            return $datetime;
        }
        // 否则使用用户注册时间
        return $this->created_at->toDateTimeString();
    }

    public function getHashFromDateString($date)
    {
        // Redis 哈希表的命名，如：cblink_last_active_at_2018-07-15
        return $this->hash_prefix.$date;
    }

    public function getHashField()
    {
        // 字段名称，如：user_1
        return $this->field_prefix.$this->id;
    }
}

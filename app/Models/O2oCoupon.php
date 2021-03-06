<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class O2oCoupon extends Model
{
    protected $table = 'o2o_promotion_coupon';
    protected $primaryKey = 'pcid';
    public $timestamps = false;

    public function scopeWithOrder($query, $order)
    {
        // 不同的排序，使用不同的数据读取逻辑
        switch ($order) {
            case 'recent':
                $query->recent();
                break;

            default:
                $query->recentReplied();
                break;
        }
    }

    public function scopeRecentReplied($query)
    {
        return $query->orderBy('createtime', 'desc');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('last_modified', 'desc');
    }

    public function isDated()
    {
        if ($this->date_type == 'DATE_TYPE_FIX_TIME_RANGE') {
            $now = date('Y-m-d H:i:s', time());
            $is_dated = $this->end_timestamp < $now ? true : false;
        } else {
            $is_dated = strtotime($this->createtime) + ($this->fixed_begin_term + $this->fixed_term) * 24 * 3600 < time() ? true : false;
        }
        return $is_dated;
    }

    public function decreaseQuantity($amount)
    {
        if ($amount < 0) {
            throw new InternalException('减库存不可小于0');
        }

        return $this->newQuery()->where('pcid', $this->pcid)->where('quantity', '>=', $amount)->decrement('quantity', $amount);
    }

    public function addQuantity($amount)
    {
        if ($amount < 0) {
            throw new InternalException('加库存不可小于0');
        }
        $this->increment('quantity', $amount);
    }

    public function decreaseGrantQuantity($amount)
    {
        if ($amount < 0) {
            throw new InternalException('减库存不可小于0');
        }

        return $this->newQuery()->where('pcid', $this->pcid)->where('grant_quantity', '>=', $amount)->decrement('grant_quantity', $amount);
    }

    public function addGrantQuantity($amount)
    {
        if ($amount < 0) {
            throw new InternalException('加库存不可小于0');
        }
        $this->increment('grant_quantity', $amount);
    }

    public function getMerIdAttribute($value)
    {
        return $value == '' ? [] : explode(',', $value);
    }

    public function setMerIdAttribute($value)
    {
        $this->attributes['mer_id'] = implode(',', $value);
    }

    public function getDaysAttribute($value)
    {
        return $value == '' ? [] : explode(',', $value);
    }

    public function setDaysAttribute($value)
    {
        $this->attributes['days'] = implode(',', $value);
    }

    public function getWeeksAttribute($value)
    {
        return  $value == '' ? [] : explode(',', $value);
    }

    public function setWeeksAttribute($value)
    {
        $this->attributes['weeks'] = implode(',', $value);
    }

    public function limitDaysAndWeeks()
    {
        $days = '';
        $weeks = '';
        $type = $this->limit_time_type == '0' ? '可用' : '不可用';
        if ($this->days) {
            $days = '每月';
            $daysArr = $this->days;
            foreach ($daysArr as $day) {
                $days .= $day . '、';
            }
            $days = rtrim($days, '、') . '号' . $type;
        }
        if ($this->weeks) {
            $weekMaps = [0 => '日', 1 => '一', 2 => '二', 3 => '三', 4 => '四', 5 => '五', 6 => '六'];
            $weeks = '每周';
            $weeksArr = $this->weeks;
            foreach ($weeksArr as $week) {
                $weeks .= $weekMaps[$week] . '、';
            }
            $weeks = rtrim($weeks, '、') . $type;
        }
        return ['days' => $days, 'weeks' => $weeks];
    }

    public function getPcid()
    {
        return time() . str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
    }

    public function merchants()
    {
        return $this->hasMany(O2oCouponMerchant::class, 'pcid', 'pcid');
    }
}

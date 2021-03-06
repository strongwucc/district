<?php

namespace App\Transformers;

use App\Models\O2oCoupon;
use App\Models\O2oCouponBuy;
use App\Models\O2oMerchant;
use League\Fractal\TransformerAbstract;

class CouponTransformer extends TransformerAbstract
{
    protected $member_id = 0;

    public function __construct($member_id = 0)
    {
        // parent::__construct();
        $this->member_id = $member_id;
    }

    public function transform(O2oCoupon $coupon)
    {

        $user_count = 0;
        $qrcode = '';

        if ($this->member_id) {
            $user_coupons = O2oCouponBuy::where([['member_id', $this->member_id], ['pcid', $coupon->pcid], ['buy_status', '1'], ['pay_status', '1']])->orderBy('id', 'desc')->get()->toArray();
            $user_count = empty($user_coupons) ? 0 : count($user_coupons);
            $qrcode = empty($user_coupons) ? '' : $user_coupons[0]['qrcode'];
        }

        $merchants = [];

        if ($coupon->mer_id) {
            $merchants = O2oMerchant::whereIn('mer_id', $coupon->mer_id)->get()->toArray();
        }

        return [
            'id' => strval($coupon->pcid),
            'cid' => $coupon->cid,
            'mer_id' => $coupon->mer_id,
            'merchants' => $merchants,
            'brand_name' => $coupon->brand_name,
            'card_type' => $coupon->card_type,
            'logo' => $coupon->logo_url,
            'title' => $coupon->title,
            'sub_title' => $coupon->sub_title,
            'notice' => $coupon->notice,
            'description' => $coupon->description,
            'grant_quantity' => $coupon->grant_quantity,
            'quantity' => $coupon->quantity,
            'date_type' => $coupon->date_type,
            'begin_timestamp' => $coupon->begin_timestamp,
            'end_timestamp' => $coupon->end_timestamp,
            'fixed_term' => $coupon->fixed_term,
            'fixed_begin_term' => $coupon->fixed_begin_term,
            'service_phone' => $coupon->service_phone,
            'get_limit' => $coupon->get_limit,
            'day_get_limit' => $coupon->day_get_limit,
            'deal_detail' => $coupon->deal_detail,
            'least_cost' => $coupon->least_cost,
            'reduce_cost' => $coupon->reduce_cost,
            'discount' => $coupon->discount,
            'gift' => $coupon->gift,
            'default_detail' => $coupon->default_detail,
            'market_price' => $coupon->market_price,
            'sale_price' => $coupon->sale_price,
            'is_buy' => $coupon->is_buy,
            'user_count' => $user_count,
            'qrcode' => $qrcode,
            'expire_date' => date('Y.m.d', strtotime($coupon->begin_timestamp)) . '-' .date('Y.m.d', strtotime($coupon->end_timestamp)),
            'limit_time_type' => $coupon->limit_time_type,
            'limit_days_and_weeks' => $coupon->limitDaysAndWeeks()
        ];
    }
}

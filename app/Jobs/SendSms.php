<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Exception;
use App\Models\O2oOrder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $qrcode;

    public $tries = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(O2oOrder $order, $qrcode)
    {
        $this->order = $order;
        $this->qrcode = $qrcode;
    }

    /**
     * Execute the job.
     *
     * @param $query_data
     * @return void
     */
    public function handle()
    {

        $pay_info_json = $this->order->pay_info;
        $pay_info = json_decode($pay_info_json, true);
        if ($pay_info && $pay_info['certNo'] && $pay_info['buyMobile']) {
            $sms_content = '您已成功购买一张电子券！券码：'.$this->qrcode;
            hk_sms_send($pay_info['buyMobile'], $sms_content);
        }
    }

    /**
     * 执行失败的任务
     *
     * @param Exception $e
     * @return void
     */
    public function failed(Exception $e) {
        Log::channel('queue')->info('队列任务执行失败：'.print_r($e->getMessage(), true));
    }
}

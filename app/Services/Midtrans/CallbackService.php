<?php

namespace App\Services\Midtrans;

use App\Models\Order;
use Midtrans\Notification;

class CallbackService extends Midtrans
{
    protected $notification;
    protected $order;
    protected $serverKey;

    public function __construct()
    {
        parent::__construct();

        $this->serverKey = config('midtrans.server_key');
        $this->handleNotification();
    }

    public function isSignatureKeyVerified()
    {
        return $this->createLocalSignatureKey() === $this->notification->signature_key;
    }

    public function isSuccess()
    {
        $statusCode = $this->notification->status_code;
        $transactionStatus = $this->notification->transaction_status;
        $fraudStatus = empty($this->notification->fraud_status) || $this->notification->fraud_status === 'accept';

        return $statusCode == 200 && $fraudStatus && $transactionStatus == 'settlement';
    }

    public function isExpire()
    {
        return $this->notification->transaction_status == 'expire';
    }

    public function isCancelled()
    {
        return $this->notification->transaction_status == 'cancel';
    }

    public function isPending()
    {
        return $this->notification->transaction_status == 'pending';
    }

    public function getNotification()
    {
        return $this->notification;
    }

    public function getOrder()
    {
        return $this->order;
    }

    protected function createLocalSignatureKey()
    {
        return hash('sha512',
            $this->notification->order_id . $this->notification->status_code .
            $this->notification->gross_amount . $this->serverKey);
    }

    protected function handleNotification()
    {
        $notification = new Notification();

        $orderNumber = $notification->order_id;

        $order = Order::with('katalog.resepRoti','customer')->where('order_id', $orderNumber)->first();

        $this->notification = $notification;
        $this->order = $order;
    }
}

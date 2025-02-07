<?php

namespace App\Services\Payment;

interface PaymentMethodInterface
{
    public function pay(array $data);
    public function handleSuccess(array $data);
    public function handleCancel();
}
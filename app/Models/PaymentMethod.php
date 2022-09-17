<?php
namespace App\Models;

class PaymentMethod extends BaseModel
{
    const PAY_WALLET = 1;
    const PAY_IN_OFFICE = 2;
    const PAY_VN_PAY = 3;
    public function isPayWallet()
    {
        return $this->id == static::PAY_WALLET;
    }
    public function isInOffice()
    {
        return $this->id == static::PAY_IN_OFFICE;
    }
}
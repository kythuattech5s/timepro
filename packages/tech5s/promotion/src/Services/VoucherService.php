<?php

namespace Tech5s\Promotion\Services;

use Tech5s\Promotion\Conditions\VoucherCondition;
use Tech5s\Promotion\Helpers\VoucherHelper;
use Tech5s\Promotion\Models\Voucher;

class VoucherService extends VoucherCondition
{
    public $voucher;
    public $voucherOld;
    public $courses;
    public $course_categories;
    const PREFIX_SESSION_PRODUCT = 'PROMOTION_PRODUCT';
    const PREFIX_SESSION_PRODUCT_CATEGORY = 'PROMOTION_PRODUCT_CATEGORY';

    public function __construct(int $id = null)
    {
        $this->courses = session()->get(static::PREFIX_SESSION_PRODUCT, collect());
        $this->course_categories = session()->get(static::PREFIX_SESSION_PRODUCT_CATEGORY, collect());
        $this->voucher = is_null($id) ? new Voucher : Voucher::find($id);
        $this->voucherOld = clone $this->voucher;
    }

    public function setName(string $name)
    {
        $this->voucher->name = $name;
    }

    public function setImg(string $inputName, string $from)
    {
        $this->voucher->img = request()->input('img', '');
    }
    public function setCode(string $code)
    {
        $this->voucher->code = VoucherHelper::PREFIX_CODE . $code;
    }

    public function setTypeCode(int $type_code)
    {
        $this->voucher->code_type = $type_code;
    }

    public function setDiscount(int $discount)
    {
        $this->voucher->discount = $discount;
    }

    public function setTypeDiscount(int $type_discount)
    {
        $this->voucher->type_discount = $type_discount;
    }

    public function setVoucherType(int $voucher_type)
    {
        $this->voucher->voucher_type = $voucher_type;
    }

    public function setPublic(int $public)
    {
        $this->voucher->is_public = $public;
    }

    public function setStartAt(\DateTime $start_at)
    {
        $this->voucher->start_at = $start_at;
    }
    public function setExpiredAt(\DateTime $expired_at)
    {
        $this->voucher->expired_at = $expired_at;
    }
    public function setLimit(int $limit = null)
    {
        $this->voucher->limit = $limit;
    }
    public function setMaxDiscount(int $maxDiscount = null)
    {
        $this->voucher->max_discount = $maxDiscount;
    }
    public function setMinimumApplyVoucher(int $minimumApplyVoucher = null)
    {
        $this->voucher->minimum_apply_voucher = $minimumApplyVoucher;
    }

    public function setAct(int $act = 1)
    {
        return $this->voucher->act = $act;
    }

    public function setOrd(int $ord = null)
    {
        return $this->voucher->ord = $ord;
    }

    public function setTypeUsed(int $type_used)
    {
        return $this->voucher->type_used = $type_used;
    }

    public function setNumberSantify(int $number_satisfy = 0)
    {
        return $this->voucher->number_satisfy = $number_satisfy;
    }

    public function setCoditionRevice(int $condition_receive = 0)
    {
        return $this->voucher->condition_receive = $condition_receive;
    }

    public function setDataVoucher()
    {
        $request = request();
        $this->setName($request->input('name'));
        $this->setCode($request->input('code'));
        $this->setStartAt(new \DateTime($request->input('start_at')));
        $this->setExpiredAt(new \DateTime($request->input('expired_at')));
        $this->setMinimumApplyVoucher($request->input('minimum_apply_voucher'));
        $this->setMaxDiscount($request->input('max_discount'));
        $this->setDiscount($request->input('discount'));
        $this->setPublic($request->input('is_public'));
        $this->setTypeDiscount((int) $request->input('type_discount'));
        $this->setTypeCode((int) $request->input('code_type'));
        $this->setVoucherType((int) $request->input('voucher_type'));
        $this->setOrd((int) $request->input('ord', 0));
        $this->setAct();
        $this->setLimit($request->input('limit'));
        if (VoucherHelper::CONDITION_APPLY) {
            $this->setTypeUsed($request->input('type_used'));
            $this->setNumberSantify((int) $request->input('number_satisfy'));
        }
        if (VoucherHelper::CONDITION_APPLY) {
            $this->setCoditionRevice($request->input('condition_receive', 0));
        }
        $this->setCourseCategory($request->input('list_category', []));
    }
    public function setCourseCategory($list)
    {
        if (is_string($list) && strlen($list) > 0) {
            $this->course_categories = collect(json_decode($list, true));
        }
    }
    public function saveVoucher()
    {
        $this->voucher->save();
    }

    public function flush()
    {
        session()->forget(static::PREFIX_SESSION_PRODUCT);
        session()->forget(static::PREFIX_SESSION_PRODUCT_CATEGORY);
    }

}

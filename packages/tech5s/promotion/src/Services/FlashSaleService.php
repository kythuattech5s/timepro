<?php
namespace Tech5s\Promotion\Services;

use DateTime;
use Tech5s\Promotion\Conditions\FlashSaleCondition;
use Tech5s\Promotion\Helpers\FlashSaleHelper;
use Tech5s\Promotion\Models\FlashSale;
use Tech5s\Promotion\Models\PromotionSlotTime;
use Tech5s\Promotion\Old\FlashSaleOld;

class FlashSaleService extends FlashSaleCondition
{
    use FlashSaleOld;

    const PREFIX_SESSION_FLASH_SALE = 'SESSION_FLASH_SALE_ADMIN';
    public $flash_sale;

    public function __construct($id = null)
    {
        if (session()->has(static::PREFIX_SESSION_FLASH_SALE) && is_null($id)) {
            $this->flash_sale = session()->get(static::PREFIX_SESSION_FLASH_SALE);
        } else {
            $this->flash_sale = is_null($id) ? new FlashSale : FlashSale::with('courses')->find($id);
        }
    }

    public function setPromotionTypeComparison(int $type)
    {
        $this->flash_sale->promotion_type_comparison_id = $type;
    }

    public function setPromotionType(int $type)
    {
        $this->flash_sale->promotion_type_id = $type;
    }

    public function setDiscount(int $discount)
    {
        $this->flash_sale->discount = $discount;
    }

    public function setStartAt(DateTime $start_at)
    {
        $this->flash_sale->start_at = $start_at;
    }

    public function setExpiredAt(DateTime $expired_at)
    {
        $this->flash_sale->expired_at = $expired_at;
    }

    public function setAct(int $act = 1)
    {
        $this->flash_sale->act = $act;
    }

    public function setOrd(int $ord = 0)
    {
        $this->flash_sale->ord = $ord;
    }

    public function setImage(string $img){
        $this->flash_sale->img = $img;
    }
    
    public function setData()
    {
        $request = request();
        if (FlashSaleHelper::CHOOSE_SLOT) {
            $time = PromotionSlotTime::where('id', $request->time_slot)->first();
            $this->setStartAt(new DateTime($request->input('date') . ' ' . $time->from));
            $this->setExpiredAt(new DateTime($request->input('date') . ' ' . $time->to));
            $this->setPromotionSlotTime((int) $request->input('time_slot'));
        } else {
            $this->setStartAt(new DateTime($request->input('start_at')));
            $this->setExpiredAt(new DateTime($request->input('expired_at')));
        }
        $this->setAct();
        $this->setOrd();
    }

    public function saveFlashSale()
    {
        $this->flash_sale->save();
        $this->saveDataProductCategory();
        $this->flush();
    }

    public function saveDataProductCategory()
    {
        $data = json_decode(request()->input('data', []), true);
        $data = (is_null($data) || $data == '') ? [] : $data;
        $ids = [];
        foreach($data as $item){
            $ids[] = $item['id'];
        }
        $this->flash_sale->course_categories()->sync([]);
        $this->flash_sale->course_categories()->sync($ids);
    }

    public function setPromotionSlotTime(int $timeSlot)
    {
        $this->flash_sale->promotion_slot_time_id = $timeSlot;
    }

    public function setName(string $name)
    {
        $this->flash_sale->name = $name;
    }

    public function saveSessionFlashSale()
    {
        session()->put(static::PREFIX_SESSION_FLASH_SALE, $this->flash_sale);
    }

    public function getSessionFlashSale()
    {
        $this->flash_sale = session()->get(static::PREFIX_SESSION_FLASH_SALE);
    }

    public function flush()
    {
        session()->forget(static::PREFIX_SESSION_FLASH_SALE);
    }
}

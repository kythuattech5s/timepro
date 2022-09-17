<?php

namespace Tech5s\Promotion\Controllers\Marketing\Abstracts;

use Tech5s\Promotion\Models\Deal;
use Tech5s\Promotion\Models\DealProductMain;
use Tech5s\Promotion\Models\DealProductSub;
use DateTime;
use Tech5s\Promotion\Controllers\Marketing\Condition\DealCondition;
use Tech5s\Promotion\Controllers\Marketing\Traits\OldDataDeal;
use DealHelper;

class DealContruct extends DealCondition
{
    use OldDataDeal;
    public $deal;
    public $product_mains;
    public $product_main_real;
    public $product_main_no_active;
    public $product_subs;
    public $product_sub_real;
    public $product_sub_no_active;

    const SESSION_DEAL = 'PROMOTION_DEAL';
    const PREFIX_SESSION_PRODUCT_MAIN = 'PROMOTION_PRODUCT_MAIN';
    const PREFIX_SESSION_PRODUCT_SUB = 'PROMOTION_PRODUCT_SUB';
    const PREFIX_SESSION_PRODUCT_SUB_REAL = 'PROMOTION_PRODUCT_SUB_REAL';
    const PREFIX_SESSION_PRODUCT_SUB_NO_ACTIVE = 'PROMOTION_PRODUCT_SUB_NO_ACTIVE';
    const PREFIX_SESSION_PRODUCT_MAIN_REAL = 'PROMOTION_PRODUCT_MAIN_REAL';
    const PREFIX_SESSION_PRODUCT_MAIN_NO_ATIVE = 'PROMOTION_PRODUCT_MAIN_NO_ACTIVE';

    public function __construct($id = null)
    {
        if ($id !== null) {
            $this->deal = Deal::find($id);
            $this->product_mains = $this->setProductMainOld();
            $this->product_main_real = $this->setProductMainRealOld();
            $this->product_main_no_active = $this->setProductMainNoActiveOld();
            $this->product_subs = $this->setProductSubOld();
            $this->product_sub_real = $this->setProductSubRealOld();
            $this->product_sub_no_active = $this->setProductSubNoActiveOld();
        } else {
            $this->deal = session()->get(static::SESSION_DEAL, new Deal);
            $this->product_mains = session()->get(static::PREFIX_SESSION_PRODUCT_MAIN, collect());
            $this->product_main_real = session()->get(static::PREFIX_SESSION_PRODUCT_MAIN_REAL, collect());
            $this->product_main_no_active = session()->get(static::PREFIX_SESSION_PRODUCT_MAIN_NO_ATIVE, collect());
            $this->product_subs = session()->get(static::PREFIX_SESSION_PRODUCT_SUB, collect());
            $this->product_sub_real = session()->get(static::PREFIX_SESSION_PRODUCT_SUB_REAL, collect());
            $this->product_sub_no_active = session()->get(static::PREFIX_SESSION_PRODUCT_SUB_NO_ACTIVE, collect());
        }
    }

    public function setAct()
    {
        $this->deal->act = 1;
    }
    public function setName(string $name)
    {
        $this->deal->name = $name;
    }
    public function setStartAt(DateTime $start_at)
    {
        $this->deal->start_at = $start_at;
    }
    public function setExpiredAt(DateTime $expired_at)
    {
        $this->deal->expired_at = $expired_at;
    }
    public function setLimit(int $limit)
    {
        $this->deal->limit = $limit;
    }
    public function setPrice(int $price)
    {
        $this->deal->price = $price;
    }
    public function setQty(int $qty)
    {
        $this->deal->qty = $qty;
    }
    public function setType(int $type)
    {
        $this->deal->type = $type;
    }

    public function setDataCreate()
    {
        $request = request();
        $this->setAct(1);
        $this->setType((int) $request->input('type'));
        $this->setName($request->input('name'));
        $this->setStartAt(new DateTime($request->input('start_at')));
        $this->setExpiredAt(new DateTime($request->input('expired_at')));
        if ($this->deal->type == DealHelper::TYPE_DEAL) {
            $this->setLimit($request->input('limit'));
        } else {
            $this->setPrice($request->input('price'));
            $this->setQty($request->input('qty'));
        }
    }

    public function saveDeal()
    {
        $this->deal->save();
        $this->saveSessionDeal();
    }

    public function saveSessionDeal()
    {
        session()->put(static::SESSION_DEAL, $this->deal);
    }

    public function saveSessionProductMain()
    {
        session()->put(static::PREFIX_SESSION_PRODUCT_MAIN, $this->product_mains);
    }

    public function saveSessionProductMainReal()
    {
        session()->put(static::PREFIX_SESSION_PRODUCT_MAIN_REAL, $this->product_main_real);
    }

    public function saveSessionProductMainNoActive()
    {
        session()->put(static::PREFIX_SESSION_PRODUCT_MAIN_NO_ATIVE, $this->product_main_no_active);
    }

    public function saveSessionProductSub()
    {
        session()->put(static::PREFIX_SESSION_PRODUCT_SUB, $this->product_subs);
    }

    public function saveSessionProductSubReal()
    {
        session()->put(static::PREFIX_SESSION_PRODUCT_SUB_REAL, $this->product_sub_real);
    }

    public function saveSessionProductSubNoActive()
    {
        session()->put(static::PREFIX_SESSION_PRODUCT_SUB_NO_ACTIVE, $this->product_sub_no_active);
    }

    public function removeItemProductMain($id)
    {
        $this->product_mains = $this->product_mains->filter(function ($product_id) use ($id) {
            return (int) $product_id !== (int) $id;
        });
    }

    public function removeItemProductMainReal($id)
    {
        $this->product_main_real = $this->product_main_real->filter(function ($data) use ($id) {
            return (int) $data['id'] !== (int) $id;
        });
    }

    public function removeItemProductMainNoActive($id)
    {
        $this->product_main_no_active = $this->product_main_no_active->filter(function ($data) use ($id) {
            return (int) $data['id'] !== (int) $id;
        });
    }

    public function removeItemProductMainDB($id)
    {
        $deal_product_main = DealProductMain::where('deal_id', $this->deal->id)->where('product_id', $id)->first();
        if ($deal_product_main !== null) {
            $deal_product_main->delete();
        }
    }

    public function removeItemProductSubDB($id)
    {
        $deal_product_sub = DealProductSub::where('deal_id', $this->deal->id)->where('product_id', $id)->first();
        if ($deal_product_sub !== null) {
            $deal_product_sub->delete();
        }
    }

    public function removeItemProductSub($id)
    {
        $this->product_subs = $this->product_subs->filter(function ($product_id) use ($id) {
            return (int) $product_id !== (int) $id;
        });
    }

    public function removeItemProductSubReal($id)
    {
        $this->product_sub_real = $this->product_sub_real->filter(function ($data) use ($id) {
            return (int) $data['id'] !== (int) $id;
        });
    }

    public function removeItemProductSubNoActive($id)
    {
        $this->product_sub_no_active = $this->product_sub_no_active->filter(function ($data) use ($id) {
            return (int) $data['id'] !== (int) $id;
        });
    }


    public function setProductMain($id)
    {
        $this->removeItemProductMain($id);
        $this->product_mains[] = $id;
    }

    public function setProductMainReal($dataItem)
    {
        $this->removeItemProductMainReal($dataItem['id']);
        $this->product_main_real[] = $dataItem;
    }

    public function setProductMainNoActive($dataItem)
    {
        $this->removeItemProductMainNoActive($dataItem['id']);
        $this->product_main_no_active[] = $dataItem;
    }

    public function setProductSub($id)
    {
        $this->removeItemProductSub($id);
        $this->product_subs[] = $id;
    }

    public function setProductSubReal($dataItem)
    {
        $this->removeItemProductSubReal($dataItem['id']);
        $this->product_sub_real[] = $dataItem;
    }

    public function setProductSubNoActive($dataItem)
    {
        $this->removeItemProductSubNoActive($dataItem['id']);
        $this->product_sub_no_active[] = $dataItem;
    }

    public function flush()
    {
        session()->forget(static::SESSION_DEAL);
        session()->forget(static::PREFIX_SESSION_PRODUCT_MAIN);
        session()->forget(static::PREFIX_SESSION_PRODUCT_MAIN_REAL);
        session()->forget(static::PREFIX_SESSION_PRODUCT_MAIN_NO_ATIVE);
        session()->forget(static::PREFIX_SESSION_PRODUCT_SUB);
        session()->forget(static::PREFIX_SESSION_PRODUCT_SUB_REAL);
        session()->forget(static::PREFIX_SESSION_PRODUCT_SUB_NO_ACTIVE);
    }

    public function saveProductMain()
    {
        foreach ($this->product_main_real->merge($this->product_main_no_active) as $item) {
            $product_deal_main = DealProductMain::where('deal_id', $this->deal->id)->where('product_id', $item['id'])->first();
            if ($product_deal_main == null) {
                $product_deal_main = new DealProductMain;
            }
            $product_deal_main->product_id = $item['id'];
            $product_deal_main->deal_id = $this->deal->id;
            $product_deal_main->act = $item['act'] ?? 0;
            $product_deal_main->save();
        }
    }

    public function saveProductSub()
    {
        foreach ($this->product_sub_real->merge($this->product_sub_no_active) as $item) {
            $product_deal_sub = DealProductSub::where('deal_id', $this->deal->id)->where('product_id', $item['id'])->first();
            if ($product_deal_sub == null) {
                $product_deal_sub = new DealProductSub;
            }
            $product_deal_sub->product_id = $item['id'];
            $product_deal_sub->deal_id = $this->deal->id;
            $product_deal_sub->act = $item['act'] ?? 0;
            $product_deal_sub->limit = $item['limit'] ?? null;
            $product_deal_sub->price = $item['price'];
            $product_deal_sub->percent = $item['percent'] ?? null;
            $product_deal_sub->ord = $item['ord'] ?? null;
            $product_deal_sub->save();
        }
    }

    public function saveAll()
    {
        $this->saveSessionDeal();
        $this->saveSessionProductMain();
        $this->saveSessionProductMainReal();
        $this->saveSessionProductMainNoActive();
        $this->saveSessionProductSub();
        $this->saveSessionProductSubReal();
        $this->saveSessionProductSubNoActive();
    }
}

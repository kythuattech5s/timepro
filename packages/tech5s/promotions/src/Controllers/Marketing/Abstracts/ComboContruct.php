<?php

namespace Tech5s\Promotion\Controllers\Marketing\Abstracts;

use Tech5s\Promotion\Models\Combo;
use Tech5s\Promotion\Models\ComboProduct;
use DateTime;
use Support;
use Tech5s\Promotion\Controllers\Marketing\Condition\ComboCondition;
use Tech5s\Promotion\Controllers\Marketing\Traits\OldDataCombo;

class ComboContruct extends ComboCondition{
    use OldDataCombo;
    public $combo;
    public $products;
    public $product_real;
    public $product_no_active;
    public $product_current;
    public $combo_old;

    const PREFIX_SESSION_COMBO = 'PREFIX_SESSION_COMBO';
    const PREFIX_SESSION_PRODUCT = 'PROMOTION_PRODUCT';
    const PREFIX_SESSION_PRODUCT_REAL = 'COMBO_PRODUCT_REAL';
    const PREFIX_SESSION_PRODUCT_NO_ACTIVE = 'COMBO_PRODUCT_NO_ACTIVE';
    const PREFIX_SESSION_PRODUCT_CURRENT = 'COMBO_PRODUCT_CURRENT';

    public function __construct($id = null, $isEdit = false){
        if(is_null($id) || $isEdit){
            if($isEdit){
                $this->combo_old = Combo::find($id);
                $this->combo = clone $this->combo_old;
            }else{
                $this->combo = session()->get(static::PREFIX_SESSION_COMBO, new Combo());
            }
            $this->products = session()->get(static::PREFIX_SESSION_PRODUCT,collect());
            $this->product_real = session()->get(static::PREFIX_SESSION_PRODUCT_REAL,collect());
            $this->product_no_active = session()->get(static::PREFIX_SESSION_PRODUCT_NO_ACTIVE,collect());
        }else{
            $this->combo = is_null($id) ? new Combo : Combo::with('products')->find($id);
            $this->product_current = $this->setProductCurrent();
            $this->products = $this->setProduct();
            $this->product_real = $this->setProductRealCurrent();
            $this->product_no_active = $this->setProductNoActiveCurrent();
        }
    }
    public function saveSessionCombo(){
        session()->put(static::PREFIX_SESSION_COMBO,$this->combo);
    }

    public function setAct(int $act){
        $this->combo->act = $act;
    }

    public function setName(string $name){
        $this->combo->name = $name;
    }

    public function setStartAt(DateTime $start_at){
        $this->combo->start_at = $start_at;
    }

    public function setExpiredAt(DateTime $expired_at){
        $this->combo->expired_at = $expired_at;
    }

    public function setDiscount(int $discount){
        $this->combo->discount = $discount;
    }

    public function setLimit(int $limit){
        $this->combo->limit = $limit;
    }

    public function setQty(int $qty){
        $this->combo->qty = $qty;
    }

    public function setType(int $type){
        $this->combo->type = $type;
    }
    public function setProductReal($dataProduct){
        $this->removeProductReal($dataProduct['id']);
        $this->product_real[] = $dataProduct;
    }

    public function setDataProductNoActive($dataProduct){
        $this->removeProductNoActive($dataProduct['id']);
        $this->product_no_active[] = $dataProduct;
    }

    public function removeProductReal($id){
        $this->product_real = $this->product_real->filter(function($product) use($id){
            return (int) $product['id'] !== (int) $id;
        });
    }

    public function removeProductNoActive($id){
        $this->product_no_active = $this->product_no_active->filter(function($product) use($id){
            return (int) $product['id'] !== (int) $id;
        });
    }
    public function removeProduct($id){
        $this->products = $this->products->filter(function($product_id) use($id){
            return (int) $product_id !== (int) $id;
        });
    }

    public function saveProduct(){
        session()->put(static::PREFIX_SESSION_PRODUCT, $this->products);
    }

    public function saveProductReal(){
        session()->put(static::PREFIX_SESSION_PRODUCT_REAL,$this->product_real);

    }

    public function saveProductNoActive(){
        session()->put(static::PREFIX_SESSION_PRODUCT_NO_ACTIVE,$this->product_no_active);
    }

    public function saveCombo(){
        $this->setProductNoActive();
        $this->combo->save();
        $this->setDataProduct();
        $this->flush();
    }

    public function setProductNoActive()
    {
        $product_no_active = $this->products->filter(function($product_id){
            return !$this->product_real->first(function($product) use($product_id){
                return $product['id'] == $product_id;
            });
        });
        foreach($product_no_active as $id){
            $this->setDataProductNoActive([
                'id' => $id,
                'act' => 0
            ]);
        }
    }

    public function setDataProduct(){
        foreach($this->product_no_active->merge($this->product_real) as $itemProduct){
            $item = ComboProduct::where('combo_id',$this->combo->id)->where('product_id',$itemProduct['id'])->first();
            if($item == null){
                $item = new ComboProduct;
                $item->created_at = new DateTime();
            }
            $item->combo_id = $this->combo->id;
            $item->product_id = $itemProduct['id'];
            $item->act = $itemProduct['act'];
            $item->updated_at = new DateTime();
            $item->save();
        }
    }

    public function setDataCombo(){
        $request = request();
        $this->setAct(1);
        $this->setStartAt(new DateTime($request->start_at));
        $this->setExpiredAt(new DateTime($request->expired_at));
        $this->setLimit((int) $request->input('limit'));
        $this->setName($request->input('name'));
        $this->setType((int) $request->input('type'));
        $this->setQty((int) $request->input('qty'));
        $this->setDiscount($request->input('discount'));
    }

    public function setDataUpdate(){
        $request = request();
        $this->setStartAt(new DateTime($request->start_at));
        $this->setExpiredAt(new DateTime($request->expired_at));
        $this->setLimit((int) $request->input('limit'));
        $this->setName($request->input('name'));
        $this->setType((int) $request->input('type'));
        $this->setQty((int) $request->input('qty'));
        $this->setDiscount($request->input('discount'));
    }

    public function flush(){
        session()->forget(static::PREFIX_SESSION_PRODUCT_CURRENT);
        session()->forget(static::PREFIX_SESSION_COMBO);
        session()->forget(static::PREFIX_SESSION_PRODUCT);
        session()->forget(static::PREFIX_SESSION_PRODUCT_REAL);
        session()->forget(static::PREFIX_SESSION_PRODUCT_NO_ACTIVE);
    }

    public function checkRemoveItemDB($id){
        if(isset($this->combo->id)){
            $product = ComboProduct::where('product_id',$id)->where('combo_id',$this->combo->id)->first();
            if($product !== null){
                $product->delete();
            }
        }
    }
}

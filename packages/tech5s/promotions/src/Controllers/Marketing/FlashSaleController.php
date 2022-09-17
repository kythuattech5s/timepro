<?php

namespace Tech5s\Promotion\Controllers\Marketing;

use App\Models\Product;
use DateTime;
use Illuminate\Http\Request;
use Tech5s\Promotion\Controllers\Marketing\Abstracts\FlashSaleContruct;
use Tech5s\Promotion\Models\FlashSale;

class FlashSaleController extends MarketingController
{

    public function showFormAdd()
    {
        $promotion = 'flash_sales';
        $action = 'create';
        $item = new FlashSaleContruct();
        $item->flush();
        return view('tech5spromotion::marketing.flashsales.add', compact('action', 'promotion'));
    }

    public function createTimeSlot(Request $request)
    {
        $item = new FlashSaleContruct();
        $item->setData();
        $messageCheckTime = $item->checkTimeCreate();
        if ($messageCheckTime) {
            return response([
                'code' => 100,
                'message' => $messageCheckTime,
            ]);
        }
        if (($checkTimeSatisfy = $item->checkTimeActiveOrCreateSatisfy())) {
            return response([
                'code' => 100,
                'message' => $checkTimeSatisfy,
            ]);
        }

        $flash_sale = $item->flash_sale;
        $item->saveSessionFlashSale();
        return response([
            'html' => view('tech5spromotion::marketing.flashsales.timeslot', compact('flash_sale'))->render(),
        ]);
    }

    public function editTimeSlot(Request $request)
    {
        $item = new FlashSaleContruct();
        $item->getSessionFlashSale();
        $flash_sale = $item->flash_sale;
        return response([
            'html' => view('tech5spromotion::marketing.flashsales.editTimeSlot', compact('flash_sale'))->render(),
        ]);
    }

    public function changeAct(Request $request)
    {
        $item = new FlashSaleContruct();
        if (isset($request->act) && $request->act[0] == 1) {
            $data = [
                'id' => $request->input('id')[0],
                'price' => $request->input('price'),
                'percent' => $request->input('percent'),
                'act' => $request->input('act')[0],
            ];
            if ($request->input('qty') !== null) {
                $data['qty'] = $request->input('qty');
            }
            if ($request->input('limit') !== null) {
                $data['limit'] = $request->input('limit');
            }
            $item->setItemProduct($data);
        } else {
            $data = [
                'id' => $request->input('id')[0],
                'price' => $request->input('price'),
                'percent' => $request->input('percent'),
                'act' => 0,
            ];
            if (isset($item->flash_sale->id)) {
                $item->setDataItem($data);
            }
            $item->removeItemProduct($request->id);
            $item->removeItemProductNoActive($request->id);
        }

        $item->saveProductReal();
        $item->saveItemProductNoActive();
        return response([]);
    }

    public function changeActMultiple(Request $request)
    {

        $item = new FlashSaleContruct();
        $data = json_decode($request->input('data'), true);
        $data = array_filter($data);
        foreach ($data as $dataItem) {
            if ($request->input('type') === 'on') {
                $data = [
                    'id' => $dataItem['id'],
                    'price' => $dataItem['price'],
                    'percent' => $dataItem['percent'],
                    'act' => $dataItem['act'],
                ];

                if (isset($dataItem['qty'])) {
                    $data['qty'] = $dataItem['qty'];
                }

                if (isset($dataItem['limit'])) {
                    $data['limit'] = $dataItem['limit'];
                }
                $item->setItemProduct($data);
            } else {
                $item->removeItemProduct($dataItem['id'][0]);
                $item->removeItemProductNoActive($request->id);
            }
        }
        $item->saveProductReal();
        $item->saveItemProductNoActive();
        return response([]);
    }

    public function deleteItemProduct(Request $request)
    {
        $item = new FlashSaleContruct();
        foreach ($request->id as $id) {
            $item->setItemProductDelete($id);
            $item->removeItemProduct($id);
            $item->removeItemProductNoActive($id);
            $item->checkRemoveItemDB($id);
        }
        $item->saveItemProductNoActive();
        $item->saveProductReal();
        $item->saveItemProductDelete();
        return response([
            'code' => 200,
        ]);
    }

    public function deleteItemBig(Request $request)
    {
        $item = new FlashSaleContruct();
        $item->products = $item->products->filter(function ($product_id) use ($request) {
            return $product_id !== $request->input('id');
        });
        foreach ($request->id_child as $id) {
            $item->removeItemProduct($id);
            $item->setItemProductDelete($id);
            $item->removeItemProductNoActive($id);
            $item->checkRemoveItemDB($id);
        }
        $item->saveItemProductNoActive();
        $item->saveProduct();
        $item->saveProductReal();
        $item->saveItemProductDelete();
        return response([
            'code' => 200,
        ]);
    }

    public function create(Request $request)
    {
        $item = new FlashSaleContruct();
        $item->setName($request->input('name') ?? 'Chương trình Flash Sale');
        $item->saveFlashSale();
        return response([
            'code' => 200,
            'message' => 'Tạo chương trình Flashsale thành công',
            'redirect_url' => base64_decode($request->input('returnurl', base64_encode(url('esystem/view/flash_sales')))),
        ]);
    }

    public function createCopy(Request $request)
    {
        $item = new FlashSaleContruct();
        $messageCheckTimeCreate = $item->checkTimeCreate();
        if ($messageCheckTimeCreate) {
            return response([
                'code' => 100,
                'message' => $messageCheckTimeCreate,
            ]);
        }
        $item->setName($request->input('name') ?? 'Chương trình Flash Sale');
        $item->saveFlashSale();
        return response([
            'code' => 200,
            'message' => 'Lấy chương trình Flashsale thành công',
            'redirect_url' => base64_decode($request->input('returnurl', base64_encode(url('esystem/view/flash_sales')))),
        ]);
    }

    public function saveProductNoActive(Request $request)
    {
        try {
            $item = new FlashSaleContruct();
            $data = json_decode($request->input('data'), true);
            $data = array_filter($data);
            foreach ($data as $dataItem) {
                $data = [
                    'id' => $dataItem['id'][0],
                    'price' => $dataItem['price'],
                ];
                if (isset($dataItem['percent'])) {
                    $data['percent'] = $dataItem['percent'];
                }

                if (isset($dataItem['qty'])) {
                    $data['qty'] = $dataItem['qty'];
                }

                if (isset($dataItem['limit'])) {
                    $data['limit'] = $dataItem['limit'];
                }
                $item->setItemProductNoActive($data);
            }
            $item->saveItemProductNoActive();
            return response([
                'code' => 200,
            ]);
        } catch (\Exception $err) {
            return response([
                'code' => 100,
            ]);
        }
    }

    public function showFormEdit(Request $request, $id)
    {
        $promotion = 'flash_sales';
        $action = 'edit';
        $flash_sale = FlashSale::find($id);
        if ($flash_sale == null) {
            return back();
        }

        $item = new FlashSaleContruct($id);
        $currentItem = $item->flash_sale;
        $products = Product::with(['flash_sale', 'variants' => function ($q) use ($item) {
            $q->whereNotIn('id', $item->product_delete)->with('flash_sale', function ($q) use ($item) {
                return $q->where('flash_sales.id', $item->flash_sale->id);
            });
        }])->find($item->products);
        $lock = true;
        if (new DateTime($currentItem->start_at) > new DateTime()) {
            $lock = false;
        }
        $item->saveItemProductDelete();
        $item->saveItemProductNoActive();
        $item->saveProductReal();
        $item->saveProductCurrent();
        $item->saveSessionFlashSale();
        return view('tech5spromotion::marketing.flashsales.edit', compact('products', 'currentItem', 'action', 'promotion', 'lock'));
    }

    public function update(Request $request, $id)
    {
        $item = new FlashSaleContruct();
        $messageCheckEdit = $item->checkTimeEdit();
        if ($messageCheckEdit) {
            return response([
                'code' => 100,
                'message' => $messageCheckEdit,
            ]);
        }
        $item->setName($request->input('name') ?? 'Chương trình Flash Sale');
        $item->saveFlashSale();
        return response([
            'code' => 200,
            'message' => 'Cập nhật chương trình Flashsale thành công',
            'redirect_url' => base64_decode($request->input('returnurl', base64_encode(url('esystem/view/flash_sales')))),
        ]);
    }

    public function showFormCopy(Request $request, $id)
    {
        $promotion = 'flash_sales';
        $action = 'copy';
        $item = new FlashSaleContruct($id);
        $products = Product::with(['flash_sale', 'variants' => function ($q) use ($item) {
            $q->whereNotIn('id', $item->product_delete)->with('flash_sale', function ($q) use ($item) {
                return $q->where('flash_sales.id', $item->flash_sale->id);
            });
        }])->find($item->products);
        $currentItem = $item->flash_sale;
        $item->flash_sale = new FlashSale();
        $item->saveSessionFlashSale();
        return view('tech5spromotion::marketing.flashsales.copy', compact('products', 'currentItem', 'action', 'promotion'));
    }
}

<?php
Route::namespace ("Tech5s\Promotion\Controllers")->group(function () {
    Route::get('expired-promotion', 'ExpiredController@expiredPromotion');
    Route::get('esystem/xoa-chuong-trinh-khuyen-mai/{table}', 'MarketingController@softDeletePromotion');
    Route::get('esystem/flash-sales/list-shop-flash-sale', 'FlashSaleController@listShopRegister');
    Route::get('esystem/flash-sale/{id}/danh-sach-san-pham', 'FlashSaleController@listProductOfShopFlashsale');
    Route::post('esystem/flash-sale/active-product', 'FlashSaleController@activeProoduct');
});

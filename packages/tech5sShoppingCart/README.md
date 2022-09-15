<p align="center"><a href="https://tech5s.com.vn/" target="_blank"><img src="https://tech5s.com.vn/theme/frontend/images/logo3.png" width="400"></a></p>

## Tech5sShoppingCart

Module hỗ trợ tạo giỏ hàng cho core Laravel của [Tech5s](https://tech5s.com.vn).

## Cài đặt

Chỉ có cài bằng tay:

	[1]: Copy code vào thư mục packges
	[2]: Thêm autoload vào file composer.js: "Tech5sShoppingCart\\Tech5sCart\\": "packages/tech5sShoppingCart/tech5sCart/src"
	[3]: Thêm provider vào file config/app.php: Tech5sShoppingCart\Tech5sCart\Tech5sCartServiceProvider::class
	[4]: Thêm facade vào file config/app.php: 'Tech5sCart' => Tech5sShoppingCart\Tech5sCart\Facades\Tech5sCart::class
	[5]: Update composer

Chạy dòng sau để public `config`

	php artisan vendor:publish --provider="Tech5sShoppingCart\Tech5sCart\Tech5sCartServiceProvider" --tag=config

Chạy dòng sau để public `migrations`

	php artisan vendor:publish --provider="Tech5sShoppingCart\Tech5sCart\Tech5sCartServiceProvider" --tag=migrations
	
Hoặc cả 2
	
	php artisan vendor:publish --provider="Tech5sShoppingCart\Tech5sCart\Tech5sCartServiceProvider"
	
## Sử dụng

Các phương thức mà Tech5sShoppingCart cung cấp:
	
	Có thể tham khảo ở module cart mà Mờ rờ An hay dùng. Hỏi Mờ rờ An để biết thêm chi tiết.

Mọi hàm chuyển sang gọi bằng facade **`Tech5sCart`**

Bổ sung thêm chức năng lưu giỏ hàng vào database xịn sò hơn. Các hàm cần thiết để lưu được giỏ hàng vào database.

### Tech5sCart::identifier()

Tham số đầu vào là 1 kiểu `int`. Tạo id trong giỏ hàng. Lưu trong db đã fix cứng là `user_id` 🙈

Cụ thể khi user đăng nhập thì sẽ chạy kiểu

```php
Tech5sCart::identifier($user->id)
```

Sau khi chạy thế này thì sẽ tự động lưu dữ liệu sau mỗi hành động `add()` `và update()`.

Tuy nhiên nếu thick chủ động update vào db thì dùng **`Tech5sCart::store()`** (hàm này giờ không cần truyền vào **`instance`** nữa mà chạy không thôi). Tất nhiên chỉ hoạt động khi đã **`Tech5sCart::identifier()`** cho giỏ hàng.

### Tech5sCart::restore()

Tham số đầu vào là 1 kiểu `int`. Cụ thể là user_id để khôi phục lại giỏ hàng khi đăng nhập xong 🙈

Cụ thể khi user đăng nhập thì sẽ chạy kiểu

```php
Tech5sCart::restore($user->id)
```

Khôi phục lại toàn bộ sản phẩm. Được sửa so với gốc chỉ khôi phục **`instance`** hiện tại. Hàm này sẽ khôi phục toàn bộ sản phẩm và các **`instance`** đã lưu.

**Nếu có sản phẩm trong giỏ hàng khi chưa khôi phục giỏ hàng thì sao ?**

Đừng lo đã có thêm câu hình giúp bạn có thể `merge` sản phẩm có trong giỏ hàng và giỏ hàng khôi phục. Tất nhiên là chức năng này là đc dân chúng hỏi mới thêm nên đang để mặc định là không `merge`.

	'database' => [
		'connection' => null,
		'table' => 'tech5s_carts',
		'table_item' => 'tech5s_cart_items',
		'merge_current_on_restore' => false, // Chính nó đây
	]

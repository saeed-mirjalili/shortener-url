## ایجاد دیتابیس 

## postman link
https://web.postman.co/workspace/saeed~710fa0b1-7f56-44fc-a650-7e4048396d4d/collection/31396324-b13a1bb1-d85f-491b-a3e3-1b0f4d57e754?action=share&source=copy-link&creator=31396324

``` bash 
php artisan migrate
```

## اجرا 
```bash
php artisan serve# http://localhost:8000
```




##  🧱 ساختار دیتابیس (جدول urls) 
- original_url: لینک اصلی
- short_code: کد کوتاه یکتا
- clicks: تعداد کلیک
- expires_at: زمان انقضا (اختیاری)
- timestamps




## 📡 Endpoints- ایجاد لینک کوتاه 
POST /api/v1/shorten <br>
مقادیر ارسالی (JSON):
 ```json
{ "url": "https://www.example.com/some/very/long/path", "ttl_days":2 }
```

پاسخ:
``` json
{ "short_url": "http://localhost:8000/Abc1234" }
```
در این مرحله ریدایرکت بصورت وب انجام میشود<br>
ریسپانس بالا را کپی و در صفحه مرورگر اجرا کنید تا ریدایرکت انجام شود<br>
با انجام این کار روت <br>
GET /{short_code} <br>
اجرا شده ، ریدایرکت به روت اصلی انجام میشود و مقدار کلیک یک واحد افزایش پیدا میکند


## 📡 Endpoints-لیست لینک‌های ایجادشده (صفحه‌بندی‌شده)

GET /api/v1/urls

نمونه پاسخ:
```json
{
"data": [
{
"original_url": "https://example.com",
"short_code": "abc123",
"clicks":12,
"created_at": "2025-10-25T14:00:00Z"
}
],
"meta": { "current_page":1, "last_page":1, "per_page":5, "total":1 }
}
```

## Endpoint-حذف لینک (اختیاری)

DELETE /api/v1/urls/{id}

خروجی موفق این اندپوینت 1 میباشد


##  نمونه تست‌های موجود 

- Feature: ساخت لینک کوتاه (POST /api/v1/shorten)<br>
php artisan test --filter=UrlStoreTest

- Feature: لیست لینک‌ها (GET /api/v1/urls)<br>
php artisan test --filter=UrlIndexTest

- Feature: ریدایرکت و افزایش کلیک‌ها،404،410 (GET /{short_code})<br>
php artisan test --filter=RedirectShowTest





## منطق تولید کد کوتاه


 کلاس App\Support\ShortCode از Base62 (a-zA-Z0-9) و random_int برای تولید کد تصادفی امن استفاده می‌کند.<br>
طول پیش‌فرض7 کاراکتر (قابل تغییر).<br>
پس از تولید، یکتا بودن short_code در دیتابیس بررسی می‌شود.









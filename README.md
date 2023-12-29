<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Installation

1. Repository klonlayın
2. `composer install` komutunu çalıştırın
3. .env.example dosyasını kopyalayıp .env dosyasını oluşturun
4. .env dosyasında veritabanı bilgilerinizi girin
5. MySQL'de `CREATE DATABASE zzg_tect` komutunu çalıştırın
6. `php artisan migrate` komutunu çalıştırın
7. .env dosyasında `PRODUCT_UPDATE_XML_URL` değişkenine xml dosyasının url'ini girin
8. `php artisan xml:product-update` komutunu çalıştırın (xml dosyasındaki ürünler veritabanına kaydedilecektir)
9. Testleri çalıştırmak için `php artisan test` komutunu çalıştırın

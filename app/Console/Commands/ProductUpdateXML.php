<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;

class ProductUpdateXML extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xml:product-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Product Update XML';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Memory limit arttırıldı
        ini_set('memory_limit', '512M');

        // URL adresi .env dosyasından alındı
        $url = env('PRODUCT_UPDATE_XML_URL', 'example.com');

        // XML dosyası için HTTP isteği atıldı
        $response = Http::get($url);

        // İstek başarılı ise XML dosyası işlendi
        if ($response->successful()) {
            // XML dosyası SimpleXMLElement sınıfı ile okundu
            $xml = new SimpleXMLElement($response->body());

            // XML dosyasında ürün var ise işleme devam edildi
            if ($xml->count() > 0) {

                Log::info('XML dosyası indirildi.');

                $products = array();

                // XML dosyasındaki ürünler tek tek okundu
                foreach ($xml as $product) {
                    $productId = (int)$product->id ?? null;
                    $productPrice = (float)$product->price ?? 0;
                    $productQuantity = (int)$product->quantity ?? 0;

                    if (!is_null($productId) && $productPrice > 0 && $productQuantity > 0) {

                        $checkProduct = Product::find($productId);

                        if (!is_null($checkProduct)) {
                            if ($checkProduct->price != $productPrice || $checkProduct->quantity != $productQuantity) {

                                // Ürün kuyruğa ekleyerek güncellendi
                                dispatch(function () use ($checkProduct, $productPrice, $productQuantity) {

                                    // Ürün güncellendi
                                    $checkProduct->update(array(
                                        'price' => $productPrice,
                                        'quantity' => $productQuantity,
                                    ));

                                    // Log kaydı oluşturuldu
                                    Log::info('Ürün güncellendi: ' . implode(', ', array(
                                            'id' => $checkProduct->id,
                                            'quantity' => $checkProduct->quantity,
                                        ))
                                    );
                                });
                            }
                        } else {
                            $productName = (string)$product->name ?? null;
                            $productDescription = (string)$product->description ?? null;
                            $photoUrl = (string)$product->photo_url ?? null;

                            $products[] = array(
                                'id' => $productId,
                                'name' => $productName,
                                'description' => $productDescription,
                                'price' => $productPrice,
                                'quantity' => $productQuantity,
                                'photo_url' => $photoUrl,
                            );
                        }
                    } else {

                        // Ürün bilgileri eksik ise hata kaydı oluşturuldu
                        Log::error('Ürün bilgileri eksik: ' . implode(', ', array(
                                'id' => $productId,
                                'price' => $productPrice,
                                'quantity' => $productQuantity
                            ))
                        );
                    }

                    if(count($products) > 5000) {
                        // Toplu ekleme işlemi için kuyruğa al
                        dispatch(function () use ($products) {
                            Product::insert($products);
                            Log::info('Ürünler kuyruktan eklendi: ' . implode(', ', array_column($products, 'id')));
                        });

                        $products = array();
                    }
                }

                // Toplu ekleme işlemi için kuyruğa al
                if (count($products) > 0) {
                    Product::insert($products);
                    Log::info('Ürünler eklendi: ' . implode(', ', array_column($products, 'id')));
                }

                // Veritabanında olup XML'de olmayan ürünleri sil
                $productIds = Product::pluck('id')->toArray();
                $deletedProductIds = array_diff($productIds, $xml->xpath('//product/id'));

                if (count($deletedProductIds) > 0) {
                    Product::destroy($deletedProductIds);
                    Log::info('Ürünler silindi: ' . implode(', ', $deletedProductIds));
                }

                // XML dosyası başarıyla işlendi

                Log::info('XML dosyası başarıyla işlendi.');

                self::info('XML dosyası başarıyla işlendi.');

                return;
            } else {
                // XML dosyasında ürün yok ise hata döndürüldü

                Log::error('XML dosyasında ürün bulunamadı.');

                self::error('XML dosyasında ürün bulunamadı.');

                return;
            }
        } else {
            // İstek başarısız ise hata döndürüldü

            Log::error('XML dosyası indirilemedi.');

            self::error('XML dosyası indirilemedi.');

            return;
        }
    }
}

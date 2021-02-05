<?php

namespace App\Jobs;

use App\Models\Marketplace;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $marketplace;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Marketplace $marketplace)
    {
        $this->marketplace = $marketplace;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $responseArray = $this->httpGetArrayResponse($this->marketplace->url);

        if ($this->validate($responseArray)) {
            $products = $this->getFormattedData($responseArray);

            if(count($products)) {
                Product::query()->upsert($products, ['marketplace_id', 'external_id'], array_keys($products[0]));
            }
        }
    }

    public function stringToBoolean($value) {
        if($value === 'true') {
            $result = true;
        }
        elseif($value === 'false') {
            $result = false;
        }
        else {
            $result = (boolean)$value;
        }
        return $result;
    }

    public function httpGetArrayResponse($url) {
        $response = Http::get($url);
        $xmlResponse = simplexml_load_string($response->body());
        return json_decode(json_encode($xmlResponse), true);
    }

    public function validate($responseArray) {
        $validator = Validator::make($responseArray, [
            'shop' => 'required|array',
            'shop.offers' => 'required|array',
            'shop.offers.offer' => 'required|array',

            'shop.offers.offer.*.@attributes.id' => 'required|integer',
            'shop.offers.offer.*.@attributes.available' => 'required|in:true,false',
            'shop.offers.offer.*.name' => 'required|string|max:255',
            'shop.offers.offer.*.price' => 'required|integer',
            'shop.offers.offer.*.currencyId' => 'required|string|max:5',

            'shop.offers.offer.*.url' => 'sometimes|string|max:1024',
            'shop.offers.offer.*.categoryId' => 'sometimes|integer',
            'shop.offers.offer.*.picture' => 'sometimes|string|max:1024',
            'shop.offers.offer.*.store' => 'sometimes|in:true,false',
            'shop.offers.offer.*.pickup' => 'sometimes|in:true,false',
            'shop.offers.offer.*.delivery' => 'sometimes|in:true,false',
            'shop.offers.offer.*.local_delivery_cost' => 'sometimes|integer',
            'shop.offers.offer.*.vendor' => 'sometimes|string|max:255',
            'shop.offers.offer.*.description' => 'sometimes|string',
            'shop.offers.offer.*.sales_notes' => 'sometimes|string|max:255',
            'shop.offers.offer.*.manufacturer_warranty' => 'sometimes|in:true,false',
        ]);

        if ($validator->fails()) {
            Log::error("IMPORT -- [Marketplace id = {$this->marketplace->id}] Validation errors: " . PHP_EOL . implode(', ' . PHP_EOL, $validator->errors()->all()));
            return false;
        }
        return true;
    }

    public function getFormattedData($responseArray) {
        $productsData = $responseArray['shop']['offers']['offer'];
        $products = [];



        foreach ($productsData as $item) {
            $product = $this->getProductFromData($item);
            $product['marketplace_id'] = $this->marketplace->id;

            $products[] = $product;
        }

        return $products;
    }

    public function getProductFromData($item) {

        $product = [];
        foreach (Product::FIELDS_CONFIG as $key => $config) {

            $namesArray = explode('.', $config['original_name']);
            $value = $item;
            while ($namesArray) {
                $name = array_shift($namesArray);
                $value = isset($value[$name]) ? $value[$name] : null;
                if(!$value) {
                    break;
                }
            }
            if($config['is_boolean']) {
                $value = $this->stringToBoolean($value);
            }

            if(isset($value)) {
                $product[$key] = $value;
            }
        }

        return $product;
    }
}

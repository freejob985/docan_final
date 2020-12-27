<?php

namespace App;

use App\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ProductsExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return Product::all();
    }


 public function lang($un, $lang, $val = 0)
{

   $product_translation = DB::table('product_translation')->get()->where('Name', $un)->where('language', $lang)->first();
  
                return $product_translation->Producer;


}

    public function headings(): array
    {
        return [
            'name',
              'Name_Arabic',
            'added_by',
            'user_id',
            'category_id',
            'subcategory_id',
            'subsubcategory_id',
            'brand_id',
            'video_provider',
            'video_link',
            'unit_price',
            'purchase_price',
            'unit',
            'current_stock',
            'meta_title',
            'meta_description',
        ];
    }

    /**
    * @var Product $product
    */
    public function map($product): array
    {
      //  dd(lang($product->name,"ar"));
 //       dd($this->lang(,"ar"));

        return [
            $product->name,
            $this->lang($product->name,"ar")  ,
            $product->added_by,
            $product->user_id,
            $product->category_id,
            $product->subcategory_id,
            $product->subsubcategory_id,
            $product->brand_id,
            $product->video_provider,
            $product->video_link,
            $product->unit_price,
            $product->purchase_price,
            $product->unit,
            $product->current_stock,
        ];
    }
}

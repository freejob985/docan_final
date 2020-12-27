<?php

namespace App;

use App\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

use DB;

class avd implements FromCollection, WithMapping, WithHeadings
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
           ['First row', 'First row'],
           ['Second row', 'Second row'],
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
    
        public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }
}

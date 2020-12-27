<?php

namespace App;

use App\Subcategory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

use DB;

class avdsubsub implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return SubSubCategory::all();
              //  $sub_categories = 

    }


 public function lang($un, $lang, $val = 0)
{

   $product_translation = DB::table('product_translation')->get()->where('Name', $un)->where('language', $lang)->first();
  
                return $product_translation->Producer;


}


    
    

    public function headings(): array
    {
        return [
            'id',
              'sub_category_id',
                'name',
        ];

    }

    /**
    * @var Product $product
    */
    public function map($product): array
    {
        return [
            $product->id,
            $product->sub_category_id,
            $product->name,
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

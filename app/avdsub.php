<?php

namespace App;

use App\Subcategory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

use DB;

class avdsub implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return Subcategory::all();
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
              'name',
                'category_id',
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
            $product->id,
            $product->name,
            $product->category_id,
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

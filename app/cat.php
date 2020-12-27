<?php

namespace App;

use App\Product;
use App\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class cat implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return Category::all();
    }



    public function headings(): array
    {
        return [
            'id',
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
           $product->name,
        ];
    }
}

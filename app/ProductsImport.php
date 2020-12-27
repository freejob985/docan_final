<?php

namespace App;

use App\Product;
use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Auth;
use Illuminate\Support\Str;
use DB;


class ProductsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // $Product= new Product();
        
        
            $Product = DB::table('products')->insertGetId(
            [
           'name'     => $row['name'],
           'added_by'    => Auth::user()->user_type == 'seller' ? 'seller' : 'admin',
           'user_id'    => Auth::user()->user_type == 'seller' ? Auth::user()->id : User::where('user_type', 'admin')->first()->id,
           'category_id'    => $row['category_id'],
           'subcategory_id'    => $row['subcategory_id'],
           'subsubcategory_id'    => $row['subsubcategory_id'],
           'brand_id'    => $row['brand_id'],
           'video_provider'    => $row['video_provider'],
           'video_link'    => $row['video_link'],
           'unit_price'    => floatval(preg_replace("/[^-0-9\.]/","",$row['unit_price'])),
           'purchase_price'    => $row['purchase_price'],
           'unit'    => $row['unit'],
           'current_stock' => $row['current_stock'],
           'meta_title' => $row['meta_title'],
           'meta_description' => $row['meta_description'],
           'colors' => json_encode(array()),
           'choice_options' => json_encode(array()),
           'variations' => json_encode(array()),
           'slug' => preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $row['slug'])).'-'.Str::random(5),
           'description' => $row['description'],
            'thumbnail_img' => "uploads/products/thumbnail/".$row['thumbnail_img'],
             'photos' => "[\"uploads\\/products\\/photos\\/".$row['photos']."\"]",


        ]
    );
    
    
            DB::table('product_translation')->insert([
            'Name' =>  $row['name'],
            'Unique' => $Product,
           'Producer' => $row['name'],
            'explained' => $row['description'],
            'language' => "en",
        ]);
        DB::table('product_translation')->insert([
            'Name' =>  $row['name'],
            'Unique' => $Product,
            'Producer' => $row['name_ar'],
            'explained' => $row['description_ar'],
            'language' => "ar",
        ]);
    }

    public function rules(): array
    {
        return [
             // Can also use callback validation rules
           
        ];
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\SubCategory;
use App\SubSubCategory;
use App\Brand;
use App\User;
use App\cat;
use App\br;
use App\avdsub;
use App\avdsubsub;
use Auth;
use App\ProductsImport;
use App\ProductsExport;
use PDF;
use Excel;
use Illuminate\Support\Str;
use DB;

class ProductBulkUploadController extends Controller
{
    public function index()
    {
        if (Auth::user()->user_type == 'seller') {
            return view('frontend.seller.product_bulk_upload.index');
        }
        elseif (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
            return view('bulk_upload.index');
        }
    }

    public function export(){
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

    public function pdf_download_category()
    {
        $categories = Category::all();
    
            return Excel::download(new cat, 'products.xlsx');

    }

    public function pdf_download_sub_category()
    {
        $sub_categories = Subcategory::all();
        
                    return Excel::download(new avdsub, 'Subcategory.xlsx');


    }

    public function pdf_download_sub_sub_category()
    {
        $sub_sub_categories = SubSubCategory::all();
                    return Excel::download(new avdsubsub, 'SubSubCategory.xlsx');

    }

    public function pdf_download_brand()
    {
        $brands = Brand::all();
                    return Excel::download(new br, 'Brand.xlsx');

    }

    public function pdf_download_seller()
    {
        $users = User::where('user_type','seller')->get();
        $pdf = PDF::setOptions([
                        'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
                        'logOutputFile' => storage_path('logs/log.htm'),
                        'tempDir' => storage_path('logs/')
                    ])->loadView('downloads.user', compact('users'));

        return $pdf->download('user.pdf');

    }

    public function bulk_upload(Request $request)
    {
     //   dd($request->hasFile('bulk_file'));
     
          //  dd("Catch errors for script and full tracking ( 2 )"+$request->hasFile('bulk_file'));
            Excel::import(new ProductsImport, request()->file('bulk_file'));
        
       // dd("Catch errors for script and full tracking ( 3 )");
        flash(translate('Products exported successfully'))->success();
        return back();
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Policy;
use Session;

class PolicyController extends Controller
{

    public function index($type)
    {
        $policy = Policy::where('name', $type)->where('lang',Session::get('locale'))->first();
        return view('policies.index', compact('policy'));
    }

    //updates the policy pages
    public function store(Request $request){
        $policy = Policy::where('name', $request->name)->where('lang',Session::get('locale'))->first();
        $policy->name = $request->name;
        $policy->content = $request->content;
        $link->lang = Session::get('locale');
        $policy->save();
        flash(translate($request->name.' updated successfully'));
        return back();
    }
}

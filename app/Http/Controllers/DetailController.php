<?php

namespace App\Http\Controllers;

use App\Http\Resources\Rating as RatingResource;
use App\Product;
use App\Rating;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function index(){
    	return view('product');
    }

    public function detail($id){
    	return view('details');
    }

    public function setRating(Request $request){
    	return new RatingResource(Rating::create([
    		'product_id' => $request->get('product'),
    		'user_id' => $request->get('user'),
    		'rating' => $request->get('rating')
    	]));
    }

    public function getRating($id){
    	return RatingResource::collection(Rating::all()->where('product_id', $id));
    }

    public function search(Request $request){
    	$search = $request->get('q');
    	return Product::where('name', 'like', '%'.$search.'%')->get();
    	// return Product::search($search)->get();
    }
}

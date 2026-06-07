<?php

namespace App\Http\Controllers\FrontEnd;

use App\Enums\CategoryPosition;
use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Models\Admin\Slider;
use App\Models\OutletSlider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function getCatProduct($positionValue, $countProducts = 4)
    {
        $getCat = Category::where('home_page_position', $positionValue)->first();
        return   $getCat ? Product::where('active_status', \App\Enums\CommonStatus::Active())->where('category_id', $getCat->id)->with('category')->orderBy('created_at', 'desc')->take($countProducts)->get()
            : collect(); // returns empty collection if not found        
    }

    public function index()
    {
        $data['sliders'] = Slider::orderBy('created_at', 'desc')->get();
        $data['popularCategories'] = Category::where('status', '=', \App\Enums\CategoryStatus::PopularCategory)->where('active_status', \App\Enums\CommonStatus::Active())->orderBy('serial', 'asc')->get();
        $data['categories'] = Category::where('active_status', \App\Enums\CommonStatus::Active())->with('products')->orderBy('category_name', 'asc')->get();
        $data['products'] = Product::where('active_status', \App\Enums\CommonStatus::Active())->orderBy('created_at', 'desc')->take(8)->get();
        $data['outletSliders'] = OutletSlider::all();
        $data['bestSaleProducts'] = Product::where('active_status', \App\Enums\CommonStatus::Active())->where('is_best_sale', '=', \App\Enums\ProductStatus::BestSale()->value)
            ->where('is_variation', '=', null)
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        $data['homeTopProducts'] = $this->getCatProduct(CategoryPosition::HomePageTop()->value);
        $data['homeMedialProducts'] = $this->getCatProduct(CategoryPosition::HomePageMedial()->value);
        $data['homeBottomProducts'] = $this->getCatProduct(CategoryPosition::HomePageBottom()->value);
        $data['bannerTwoProducts'] = $this->getCatProduct(CategoryPosition::BannerTwo()->value, 16);
        $data['bannerThreeProducts'] = $this->getCatProduct(CategoryPosition::BannerThree()->value, 16);

        return view('front-end.home.index',)->with($data);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('active_status', \App\Enums\CommonStatus::Active())->where('name', 'like', '%' . $query . '%')
            ->orWhere('short_description', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(16); // you can change pagination count

        return view('front-end.search-result.index', compact('products', 'query'));
    }
}

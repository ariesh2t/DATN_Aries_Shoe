<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $brandRepo;
    protected $categoryRepo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        BrandRepositoryInterface $brandRepo,
        CategoryRepositoryInterface $categoryRepo
    ) {
        $this->middleware('auth');
        $this->brandRepo = $brandRepo;
        $this->categoryRepo = $categoryRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $get4Brands = $this->brandRepo->get4Brands();
        return view('customers.home', compact('get4Brands'));
    }
}

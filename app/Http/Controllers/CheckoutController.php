<?php

namespace Delivery\Http\Controllers;


use Delivery\Repositories\OrderRepository;
use Delivery\Repositories\ProductRepository;
use Delivery\Repositories\UserRepository;
use Delivery\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




class CheckoutController extends Controller
{
    private $repository;
    private $userRepository;
    private $productRepository;
    private $service;


    public function __construct(OrderRepository $repository, UserRepository $userRepository, ProductRepository $productRepository, OrderService $service){
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->service = $service;
    }

    public function index(){
        $client_id = $this->userRepository->find(Auth::user()->id)->client->id;
        $orders = $this->repository->scopeQuery(function($query) use ($client_id){
            return $query->where('client_id','=',$client_id);
        })->paginate();
        return view('customer.order.index',compact('orders'));
    }

    public function create (){
        $products = $this->productRepository->lists();
        return view('customer.order.create',compact('products'));
    }

    public function store (Request $request){
        $data = $request->all();
        $client_id = $this-> userRepository->find(Auth::user()->id)->client->id;
        $data['client_id'] = $client_id;
        $this->service->create($data);
        return redirect()->route('customer.order.index');
    }

}

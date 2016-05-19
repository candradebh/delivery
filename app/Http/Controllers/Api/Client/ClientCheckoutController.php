<?php

namespace Delivery\Http\Controllers\Api\Client;

use Delivery\Http\Controllers\Controller;
use Delivery\Http\Requests\CheckoutRequest;
use Delivery\Repositories\OrderRepository;
use Delivery\Repositories\ProductRepository;
use Delivery\Repositories\UserRepository;
use Delivery\Services\OrderService;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;



class ClientCheckoutController extends Controller
{
    private $repository;
    private $userRepository;
    private $productRepository;
    private $service;
    private $with = ['client', 'cupom', 'items'];



    public function __construct(OrderRepository $repository, UserRepository $userRepository, ProductRepository $productRepository, OrderService $service){
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->service = $service;
    }

    public function index(){
        $id = Authorizer::getResourceOwnerId();
        $client_id = $this->userRepository->find($id)->client->id;
        $orders = $this->repository
            ->skipPresenter(false)
            ->with($this->with)->scopeQuery(function($query) use ($client_id){
            return $query->where('client_id','=',$client_id);
        })->paginate();
        return $orders;
    }



    public function store (CheckoutRequest $request){
        $data = $request->all();
        $id = Authorizer::getResourceOwnerId();
        $client_id = $this-> userRepository->find($id)->client->id;
        $data['client_id'] = $client_id;
        $o = $this->service->create($data);
        return $this->repository
            ->with($this->with)
            ->find($o->id);
    }

    public function show($id){
        //$o = $this->repository->skipPresenter()->with(['client','items','cupom'])->find($id);
        //$o = $this->repository->with(['client','items','cupom'])->find($id);
       /** $o->items->each(function($item){
            $item->product;
        });**/
        return $this->repository
            ->skipPresenter(false)
            ->with($this->with)->find($id);
    }

}

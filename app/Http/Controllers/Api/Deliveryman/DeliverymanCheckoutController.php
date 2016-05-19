<?php

namespace Delivery\Http\Controllers\Api\Deliveryman;

use Delivery\Events\GetLocationDeliveryman;
use Delivery\Http\Controllers\Controller;
use Delivery\Models\Geo;
use Illuminate\Http\Request;
use Delivery\Repositories\OrderRepository;
use Delivery\Repositories\UserRepository;
use Delivery\Services\OrderService;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;



class DeliverymanCheckoutController extends Controller
{
    private $repository;
    private $userRepository;
    private $service;
    private $with = ['client', 'cupom', 'items'];


    public function __construct(OrderRepository $repository, UserRepository $userRepository, OrderService $service){
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->service = $service;
    }

    public function index(){
        $id = Authorizer::getResourceOwnerId();
       return $this->repository
           ->skipPresenter(false)
           ->with($this->with)->scopeQuery(function($query) use ($id){
            return $query->where('user_deliveryman_id','=',$id);
        })->paginate();
        return $orders;
    }


    public function show($id){
        $idDeliveryman = Authorizer::getResourceOwnerId();
        return $this->repository
            ->skipPresenter(false)
            ->getByIdAndDeliveryman($id, $idDeliveryman);
    }


    public function updateStatus(Request $request, $id){
        $idDeliveryman = Authorizer::getResourceOwnerId();
        return $this->service->updateStatus($id, $idDeliveryman, $request->get('status'));

    }


    public function geo (Request $request, Geo $geo, $id){
        $idDeliveryman = Authorizer::getResourceOwnerId();
        $order = $this->repository->getByIdAndDeliveryman($id,$idDeliveryman);
        $geo->lat = $request->get('lat');
        $geo->long = $request->get('long');
        event(new GetLocationDeliveryman($geo,$order));
        return $geo;

    }

}

<?php

namespace Delivery\Http\Controllers;

use Delivery\Repositories\OrderRepository;
use Delivery\Repositories\UserRepository;
use Illuminate\Http\Request;
use Delivery\Http\Requests;


class OrdersController extends Controller
{
     private $repository;

    public function __construct(OrderRepository $repository,UserRepository $userRepository){
        $this->repository=$repository;
        $this->userRepository = $userRepository;
    }

    public function index(OrderRepository $repository)
    {

        $orders = $repository->paginate(10);
        return view ('admin.orders.index',compact('orders'));
    }

    public function create()
    {
        $client = $this->userRepository->getClient();
        $deliveryman = $this->userRepository->getDeliverymen();
        $list_status = $this->repository->getStatus();
        return view('admin.orders.create',compact('client','deliveryman','list_status'));
    }


    public function store(AdminOrderRequest $request){
        $data = $request->all();
        $this->repository->create($data);
        return redirect()->route('admin.orders.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id,UserRepository $userRepository)
    {
        $client = $this->userRepository->getClient();
        $order = $this->repository->find($id);
        $deliveryman = $userRepository->getDeliverymen();
        $list_status = $this->repository->getStatus();
        return view('admin.orders.edit',compact('order','client','list_status','deliveryman'));
    }


    public function update(Request $request, $id)
    {
        $all = $request->all();

        $this->repository->update($all,$id);
        return redirect()->route('admin.orders.index');
    }


    public function destroy($id)
    {
        //
    }
}

<?php

namespace Delivery\Http\Controllers\Api\Client;

use Delivery\Http\Controllers\Controller;
use Delivery\Repositories\ProductRepository;



class ClientProductController extends Controller
{
    private $repository;




    public function __construct(ProductRepository $repository){
        $this->repository = $repository;

    }

    public function index(){
      $products = $this->repository->skipPresenter(false)->all();
        return $products;
    }





}

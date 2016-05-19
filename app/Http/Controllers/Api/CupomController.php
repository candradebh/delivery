<?php

namespace Delivery\Http\Controllers\Api;

use Delivery\Http\Controllers\Controller;
use Delivery\Repositories\CupomRepository;



class CupomController extends Controller
{
    private $repository;

    public function __construct(CupomRepository $repository){
        $this->repository = $repository;

    }

    public function show($code){
      return $this->repository->skipPresenter(false)->findByCode($code);
    }





}

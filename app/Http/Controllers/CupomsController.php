<?php

namespace Delivery\Http\Controllers;

use Delivery\Http\Requests\AdminCupomRequest;
use Delivery\Repositories\CupomRepository;
use Delivery\Http\Requests;


class CupomsController extends Controller
{
    private $repository;

    public function __construct(CupomRepository $repository){
        $this->repository = $repository;
    }

    public function index(CupomRepository $repository){

        $cupoms = $repository->paginate(10);
        return view('admin.cupoms.index',compact('cupoms'));
    }

    public function create(){
        return view('admin.cupoms.create');
    }
    public function edit ($id){
        $cupom = $this->repository->find($id);
        return view('admin.cupoms.edit',compact('cupom'));
    }

    public function update (AdminCupomRequest $request, $id){
        $data = $request->all();
        $this->repository->update($data,$id);
        return redirect()->route('admin.cupoms.index');

    }

    public function store(AdminCupomRequest $request){
        $data = $request->all();
        $this->repository->create($data);
        return redirect()->route('admin.cupoms.index');
    }
    public function destroy ($id){

        $this->repository->delete($id);
        return redirect()->route('admin.cupoms.index');

    }
}

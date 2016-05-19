<?php

namespace Delivery\Http\Controllers;

use Delivery\Http\Requests\AdminCategoryRequest;
use Delivery\Repositories\CategoryRepository;
use Delivery\Http\Requests;


class CategoriesController extends Controller
{
    private $repository;

    public function __construct(CategoryRepository $repository){
        $this->repository = $repository;
    }

    public function index(CategoryRepository $repository){

        $categories = $repository->paginate(10);
        return view('admin.categories.index',compact('categories'));
    }

    public function create(){
        return view('admin.categories.create');
    }
    public function edit ($id){
        $category = $this->repository->find($id);
        return view('admin.categories.edit',compact('category'));
    }

    public function update (AdminCategoryRequest $request, $id){
        $data = $request->all();
        $this->repository->update($data,$id);
        return redirect()->route('admin.categories.index');

    }

    public function store(AdminCategoryRequest $request){
        $data = $request->all();
        $this->repository->create($data);
        return redirect()->route('admin.categories.index');
    }
    public function destroy ($id){

        $this->repository->delete($id);
        return redirect()->route('admin.categories.index');

    }
}

<?php

namespace Delivery\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Delivery\Repositories\CategoryRepository;
use Delivery\Models\Category;

/**
 * Class CategoryRepositoryEloquent
 * @package namespace Delivery\Repositories;
 */
class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository
{

    public function lists()
    {
        return $this->model->lists('name','id');
    }
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}

<?php

namespace Delivery\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Delivery\Presenters\CupomPresenter;
use Delivery\Models\Cupom;

/**
 * Class CupomRepositoryEloquent
 * @package namespace Delivery\Repositories;
 */
class CupomRepositoryEloquent extends BaseRepository implements CupomRepository
{

    protected $skipPresenter = true;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Cupom::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter (){
        return CupomPresenter::class;
    }

    public function findByCode($code)
    {
       $result = $this->model
           ->where('code',$code)
           ->where('used',0)
           ->first();

        if($result){
            return $this->parserResult($result); //parse result prepara o resultado
        }

        throw (new ModelNotFoundException)->setModel(get_class($this->model));
    }
}

<?php

namespace Delivery\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Delivery\Repositories\OrderRepository;
use Delivery\Models\Order;

/**
 * Class OrderRepositoryEloquent
 * @package namespace Delivery\Repositories;
 */
class OrderRepositoryEloquent extends BaseRepository implements OrderRepository
{
    protected $skipPresenter = true;

    public function getStatus(){
        $list_status = [0=>'Pendente', 1=>'Aguardadando', 2=>'Entregue',3=>'Cancelado'];
        return $list_status;
    }


    public function getByIdAndDeliveryman($id,$idDeliveryman){

        $result = $this->model
                ->where('id',$id)
                ->where('user_deliveryman_id',$idDeliveryman)
                ->first();

        if($result){
            return $this->parserResult($result);
        }

        throw (new ModelNotFoundException())->setModel(get_class($this->model));
    }

    public function model()
    {
        return Order::class;
    }


    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
    {
        return \Delivery\Presenters\OrderPresenter::class;
    }


}

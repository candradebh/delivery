<?php

namespace Delivery\Transformers;

use Illuminate\Database\Eloquent\Collection;
use League\Fractal\TransformerAbstract;
use Delivery\Models\Order;

/**
 * Class OrderTransformer
 * @package namespace Delivery\Transformers;
 */
class OrderTransformer extends TransformerAbstract
{

    //protected $defaultIncludes = ['cupom', 'items']; //serializados por padrao -  pouca carga de dados
    protected $availableIncludes = ['cupom', 'items','client']; //serializados por demanda - muita carga de dados

    /**
     * Transform the \Order entity
     * @param \Order $model
     *
     * @return array
     */
    public function transform(Order $model)
    {
        return [
            'id'=> (int) $model->id,
            'total' => (float) $model->total,
            'product_names' => $this->getArrayProductNames($model->items),
            'status'=> $model->status,
            'hash'=> $model->hash,
            /* 'items' => $model->items,
            'cupom' => $model->cupom, */

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    protected function getArrayProductNames(Collection $items){
        $names = [];
        foreach($items as $item){
            $names[] = $item->product->name;
        }
        return $names;
    }

    //serializacao de relacionamento com  client
    public function includeClient(Order $model){
        return $this->item($model->client, new ClientTransformer());
    }

    //serializacao de relacionamento com  cupom
    public function includeCupom(Order $model){
        if(!$model->cupom){
            return null;
        }

        return $this->item($model->cupom, new CupomTransformer());
    }
    //serializacao de relacionamento com  items
    public function includeItems(Order $model){
        return $this->collection($model->items, new OrderItemTransformer());
    }


}

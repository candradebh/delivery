<?php

namespace Delivery\Transformers;

use League\Fractal\TransformerAbstract;
use Delivery\Models\Client;

/**
 * Class ClientTransformer
 * @package namespace Delivery\Transformers;
 */
class ClientTransformer extends TransformerAbstract
{


    public function transform(Client $model)
    {
        return [
            'id'         => (int) $model->id,
            'phone' => $model->phone,
            'address' => $model->address,
            'city' => $model->city,
            'state' => $model->state,
            'zipcode' => $model->zipcode,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}

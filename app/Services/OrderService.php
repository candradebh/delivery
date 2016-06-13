<?php
/**
 * Created by PhpStorm.
 * User: carlos.andrade
 * Date: 05/11/2015
 * Time: 14:20
 */

namespace Delivery\Services;


use Delivery\Repositories\CupomRepository;
use Delivery\Repositories\OrderRepository;
use Delivery\Repositories\ProductRepository;
use Dmitrovskiy\IonicPush\PushProcessor;


class OrderService
{
    private $orderRepository;
    private $cupomRepository;
    private $productRepository;
    /**
     * @var PushProcessor
     */
    private $pushProcessor;

    /**
     * OrderService constructor.
     * @param $orderRepository
     * @param $cupomRepository
     * @param $productRepository
     */
    public function __construct(
                   OrderRepository $orderRepository,
                   CupomRepository $cupomRepository,
                   ProductRepository $productRepository,
                   PushProcessor $pushProcessor
    )
    {

        $this->orderRepository = $orderRepository;
        $this->cupomRepository = $cupomRepository;
        $this->productRepository = $productRepository;
        $this->pushProcessor = $pushProcessor;
    }

    public function create (array $data){
       \DB::beginTransaction();

        try{
            $data['status']=0;
            if(isset($data['cupom_id'])){
                unset($data['cupom_id']);
            }
            if(isset($data['cupom_code'])){
                $cupom = $this->cupomRepository->findByField('code',$data['cupom_code'])->first();
                $data['cupom_id']=$cupom->id;
                $cupom->used = 1;
                $cupom->save();
                unset($data['cupom_code']);
            }


            $items = $data['items'];
            unset($data['items']);

            $order = $this->orderRepository->create($data);
            $total = 0;

            foreach($items as $item){
                $item['price'] = $this->productRepository->find($item['product_id'])->price;
                $order->items()->create($item);
                $total += $item['price'] * $item['qtd'];
            }

            $order->total = $total;

            //subitrair o valor de desconto se estiver utilizando cupom
            if(isset($cupom)){
                $order->total = $total - $cupom->value;
            }

            $order->save();
            \DB::commit();
            return $order;

        }catch (\Exception $e){
            \DB::rollback();
            throw $e;
        }
    }

    public function updateStatus($id, $idDeliveryman, $status){
        $order = $this->orderRepository->getByIdAndDeliveryman($id,$idDeliveryman);
        $order->status = $status;

        switch ((int)$status){
            case 1:
                //se nao existe o hash, gera o hash para trabalhar com o geoposicionamento
                if(!$order->hash){
                    $order->hash = md5( (new \DateTime())->getTimestamp());
                }
                $order->save();
            break;
            case 2:
                $user = $order->client->user;
                $order->save();
                $this->pushProcessor->notify(
                                [$user->device_token],
                                ['alert'=>"Seu pedido {$order->id} acabou de ser entregue."]
                );
            break;
        }

        return $order;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: carlos.andrade
 * Date: 29/10/2015
 * Time: 10:20
 */

namespace Delivery\Services;


use Delivery\Repositories\ClientRepository;
use Delivery\Repositories\UserRepository;

class ClientService
{
    private $clientRepository;
    private $userRepository;


    public function __construct( ClientRepository $clientRepository, UserRepository $userRepository)
    {
        $this->clientRepository = $clientRepository;
        $this->userRepository = $userRepository;
    }

    public function update(array $data,$id)
    {
        $this->clientRepository->update($data, $id);
        $userId = $this->clientRepository->find($id,['user_id'])->user_id;
        //dd($userId);
        $this->userRepository->update($data['user'], $userId);
    }

    public function create (array $data)
    {
        $data['user']['password']=bcrypt(123456);//atribui uma senha default para o array do formulario
        $user = $this->userRepository->create($data['user']); //cria usuario e retorna o user_id
        $data['user_id'] = $user->id;//adiciona user_id ao array principal
        //dd($data['user_id']);
        $this->clientRepository->create($data);
    }
}
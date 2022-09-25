<?php

namespace Modules\Api\Repositories_old;
use Doctrine\DBAL\DriverManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Api\Interfaces_old\OrderRepositoryInterface;


class OrderRepository implements OrderRepositoryInterface
{

    private $modelName ;

    public function __construct()
    {
        $this->modelName = $this->model();;
    }


    /**
     * here get all data of  orders  by sanding id of item
     **/
    public function getAllOrders($paginate=10,$searchItems=null,$ordering_filed='id',$ordering_dir='desc')
    {
        if($searchItems && !empty($searchItems)){
            $data = $this->filter($searchItems)->orderBy($ordering_filed,$ordering_dir)->paginate($paginate);
        }else{
            $data = $this->modelName::with(['groups'])->orderBy($ordering_filed,$ordering_dir)->paginate($paginate);
        }
        return $data;
    }


    /**
     * here get  order by sanding id of item
     **/
    public function getOrderById($orderId)
    {
        $item = $this->modelName::findOrFail($orderId);
        return $item;
    }

    /**
     * here delete order by sanding id of item
     **/
    public function deleteOrder($orderId)
    {
        $this->modelName::findOrFail($orderId)->delete();

    }


    /**
     * here create new  order by sanding  new data
     **/
     public function createOrder( array $newDetails){
         return   $this->modelName::create($newDetails);
     }

    /**
     * here update order by sanding id of item and new data
     **/

    public function updateOrder($orderId, array $newDetails)
    {

        return   $this->modelName::whereId($orderId)->update($newDetails);
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Order::class;
    }

    public function relation()
    {
        $data =['orders','orders'];
        return json_encode($data);
    }

    /**
     * here filter data by using search request data
     **/

    public function filter($searchItems)
    {
        $query = [];
        foreach ($searchItems as $key => $value) {
            $query =$this->modelName::with(['groups'])->where($key, $value);
        }
        return $query;
    }

}

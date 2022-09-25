@php echo "<?php";
@endphp

namespace Modules\{{ $module }}\ApiRepositories;
use Doctrine\DBAL\DriverManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\{{ $module }}\Interfaces\{{ $model }}RepositoryInterface;
use Modules\{{ $module }}\Entities\{{ $model }};

class {{ $model }}Repository implements {{ $model }}RepositoryInterface
{
        private $modelName ;

        public function __construct()
        {
             $this->modelName = $this->model();
        }

        /**
        * Configure the Model
        **/
        public function model()
        {
             return {{ $model }}::class;
        }

        /**
        * here get all data of  {{ $model }}
        **/
        public function getAllData($paginate=10,$searchItems=null,$ordering_filed='id',$ordering_dir='desc')
        {
            if($searchItems && !empty($searchItems)){
                 $data = $this->filter($searchItems)->orderBy($ordering_filed,$ordering_dir)->paginate($paginate);
            }else{
                 $data = $this->modelName::with([])->orderBy($ordering_filed,$ordering_dir)->paginate($paginate);
            }
            return $data;
        }


        /**
        * here get {{ $model }} by sanding id of item
        **/
        public function getItemById($itemId)
        {
            $item = $this->modelName::find($itemId);

            if(!$item){
               return false;

            }else{
              return $item;
            }
        }

        /**
        * here delete {{ $model }} by sanding id of item
        **/
        public function deleteItem($itemId)
        {
           $item = $this->modelName::find($itemId);
            if(!$item){
               return false;

            }else{
               $item->delete();
               return true;
            }

        }


        /**
        * here create new {{ $model }}   by sanding  new data
        **/
        public function createItem( array $newDetails){

               return   $this->modelName::create($newDetails);
        }

        /**
        * here update {{ $model }} by sanding id of item and new data
        **/

        public function updateItem($itemId, array $newDetails)
        {
             return   $this->modelName::whereId($itemId)->update($newDetails);
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
                $query =$this->modelName::with([])->where($key, $value);
             }
              return $query;
        }

}

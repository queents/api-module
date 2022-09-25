@php echo "<?php";
@endphp


namespace Modules\{{ $module }}\Http\Controllers\Api;
use Modules\{{ $module }}\Entities\{{ $model }};
use Modules\{{ $module }}\Interfaces\{{ $model }}RepositoryInterface;
use Modules\{{ $module }}\Http\Requests\Api\Store{{ $model }};
use Modules\{{ $module }}\Http\Requests\Api\Update{{ $model }};
use Modules\{{ $module }}\Http\Resources\Api\{{ $model }}Resource;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;


class {{ $model }}ApiController extends Controller
{

    public {{ $model }}RepositoryInterface  ${{$objectName}}Repository;

    public function __construct({{ $model }}RepositoryInterface ${{$objectName}}Repository)
    {
        $this->{{$objectName}}Repository = ${{$objectName}}Repository;
    }

    public function index(Request $request): JsonResponse
    {
        $searchItems = $request->except([
            'page',
            'limit'
        ]);
         $limit = $request->limit ?? 10;


        $data = {{ $model }}Resource::collection($this->{{$objectName}}Repository->getAllData( $limit,$searchItems,'created_at','desc')) ;
        return response()->json([
            'status' => 200,
            'message' =>' get all items',
            'data' => $data
        ]);
    }

    public function store(Store{{ $model }} $request) : JsonResponse
    {
        ${{$objectName}}Details = $request->all();
        $data = $this->{{$objectName}}Repository->createItem(${{$objectName}}Details);
        return response()->json([
            'status' => 200,
            'message' =>'Created Successfully .'
        ]);

     }

    public function show(Request $request): JsonResponse
    {
        ${{$objectName}}Id = $request->get('id');
        $item = $this->{{$objectName}}Repository->getItemById(${{$objectName}}Id);
        if(!$item){
            return response()->json([
                'success' => false,
                'status' => 401,
                'message' =>'Not Found.'
            ]);

        }else{

            $item =  new {{ $model }}Resource($item) ;

            return response()->json([
                'success' => true,
                'status' => 200,
                 'message' =>'Item Retrived Successfuly.',
                'data' => $item
            ]);

        }
        
    }

    public function update(Update{{$model}}  $request): JsonResponse
    {
        ${{$objectName}}Id = $request->get('id');

        ${{$objectName}}Details = $request->all();
        $data =  $this->{{$objectName}}Repository->updateItem(${{$objectName}}Id, ${{$objectName}}Details);
        return response()->json([
            'status' => 200,
            'message' =>'Updated Successfully .'
        ]);
    }

    public function delete(Request $request): JsonResponse
    {
        ${{$objectName}}Id = $request->get('id');
        ${{$objectName}}Item =  $this->{{$objectName}}Repository->deleteItem(${{$objectName}}Id);

        if(!${{$objectName}}Item){
            return response()->json([
                'success' => false,
                'status' => 401,
                'message' =>'Not Found.'
            ]);

        }else{
                
            return response()->json([
                'status' => 200,
                'message' =>'Deleted Successfully .'
                ]);

        }

       
    }
}


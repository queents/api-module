@php echo "<?php";
@endphp

namespace Modules\{{$module}}\Http\Resources\Api;
use Illuminate\Http\Resources\Json\JsonResource;

class {{$model}}Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
             @foreach($cols as $col)
              "{{ $col['name'] }}" => $this->{{ $col['name'] }} ?? "",
              @endforeach
        ];

        return $data;
      
    }
}

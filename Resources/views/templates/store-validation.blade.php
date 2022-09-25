@php echo "<?php";
@endphp

namespace Modules\{{$module}}\Http\Requests\Api;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class Store{{$model}} extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
                @foreach($cols as $col)
                    @php
                        if($col['required']){
                            $required = "required";
                        }
                        else {
                            $required = "";
                        }
                        if($col['unique']){
                            $unique = "unique:".$table.",".$col['name'];
                        }
                        else {
                            $unique = "";
                        }
                        if($col['maxLength']){
                            $max = "max:" . $col['maxLength'];
                        }
                        else {
                            $max = "";
                        }
                    @endphp
                    @if($col['name'] === 'password')
                        "password" => "{{ $required ? $required . "|" : "" }}{{ $max ? $max . "|" : "" }}string|min:8|confirmed",
                    @elseif($col['name'] === 'email')
                        "email" => "{{ $required ? $required . "|" : "" }}{{ $max ? $max . "|" : "" }}{{ $unique ? $unique . "|" : "" }}email|string",
                    @elseif($col['type'] === 'relation')
                        "{{ $col['name'] }}" => "{{ $required ? $required . "|" : "" }}{{ $max ? $max . "|" : "" }}{{ $unique ? $unique . "|" : "" }}array",
                    @elseif($col['type'] === 'boolean')
                        "{{ $col['name'] }}" => "{{ $required ? $required . "|" : "" }}{{ $max ? $max . "|" : "" }}{{ $unique ? $unique . "|" : "" }}bool",
                    @elseif($col['name'] === 'tel')
                        "{{ $col['name'] }}" => "{{ $required ? $required . "|" : "" }}{{ $max ? $max . "|" : "" }}{{ $unique ? $unique . "|" : "" }}string",
                    @elseif($col['name'] === 'id')
                    @else
                        "{{ $col['name'] }}" => "{{ $required ? $required . "|" : "" }}{{ $max ? $max . "|" : "" }}{{ $unique ? $unique . "|" : "" }}string",
                    @endif
                @endforeach
                ];
        return $rules;
    }
    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        if($this->wantsJson())
        {

            $response = response()->json([
                'success' => false,
                'message' =>$validator->errors()->first()
            ],400);
        }

        throw (new ValidationException($validator, $response))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }


}

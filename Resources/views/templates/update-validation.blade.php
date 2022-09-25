@php echo "<?php";
@endphp

namespace Modules\{{$module}}\Http\Requests\Api;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class Update{{$model}} extends FormRequest
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
                 "id" => "required",
            @foreach($cols as $col)
                @php
                    if($col['maxLength']){
                        $max = "max:" . $col['maxLength'];
                    }
                    else {
                        $max = "";
                    }
                    if($col['unique']){
                        $unique ="";
                    }
                    else {
                        $unique = "";
                    }
                @endphp
                @if($col['name'] === 'password')
                    "password" => "sometimes|string|min:8|confirmed",
                @elseif($col['name'] === 'email')
                    "email" => "sometimes|string|email{{ $unique ? "|" . $unique  : "" }}"{{ $unique ? '.$id': ''}},
                @elseif($col['type'] === 'integer')
                    "{{ $col['name'] }}" => "sometimes|integer{{ $unique ? "|" . $unique  : "" }}"{{ $unique ? '.$id': ''}},
                @elseif($col['type'] === 'boolean')
                    "{{ $col['name'] }}" => "sometimes|boolean{{ $unique ? "|" . $unique  : "" }}"{{ $unique ? '.$id': ''}},
                @elseif($col['type'] === 'relation')
                    "{{ $col['name'] }}" => "sometimes|array{{ $unique ? "|" . $unique  : "" }}"{{ $unique ? '.$id': ''}},
                @elseif($col['type'] === 'boolean')
                    "{{ $col['name'] }}" => "sometimes|bool{{ $unique ? "|" . $unique  : "" }}"{{ $unique ? '.$id': ''}},
                @elseif($col['type'] === 'datetime')
                    "{{ $col['name'] }}" => "sometimes|date{{ $unique ? "|" . $unique  : "" }}"{{ $unique ? '.$id': ''}},
                @elseif($col['name'] === 'id')
                @else
                    "{{ $col['name'] }}" => "sometimes|string{{ $unique ? "|" . $unique  : "" }}"{{ $unique ? '.$id' : ''}},
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

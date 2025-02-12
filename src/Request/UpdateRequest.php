<?php

namespace Froiden\LaravelInstaller\Request;



class UpdateRequest extends CoreRequest
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

//        dd(request()->all() , request("serializable") ?? 0);
        return [
            'hostname' => 'required',
            'username' => 'required',
            'database' => 'required',
            'name_co' => 'required|string',
            'year' => 'required|integer|digits:4|min:1400|max:2000',
            'invable' => 'required|in:0,1',
            'serializable' => 'required|in:0,1',
            'batchable' => 'required|in:0,1',

        ];
    }

}

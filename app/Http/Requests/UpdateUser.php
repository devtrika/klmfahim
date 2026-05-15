<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $id = $this->segment(3);
        return [
            //
            "username" => "required|unique:users,username,$id",
            "email" => "required|email|unique:users,email,$id",
            "name" => "required",
            "active" => "required",
            "phone" => "required|numeric",
        ];
    }

}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSite extends FormRequest {

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
        return [
            "ar_title" => "required",
            "en_title" => "required",
            "ar_address" => "required",
            "en_address" => "required",
            
            "tags" => "required",
            "phone" => "required",
            "mobile" => "required",
//            "fax" => "required",
            "email" => "required|email",
            "voice" => "nullable|file|mimes:mp3,mpga,m4a,mp4,wav,ogg,oga,aac|max:30720",
            "voice_title" => "nullable|max:120",
            
//            "logo" => "image|mimes:jpeg,jpg,png,bmp,gif,svg",
//            "first" => "image|mimes:jpeg,jpg,png,bmp,gif,svg",
//            "second" => "image|mimes:jpeg,jpg,png,bmp,gif,svg",
//            "third" => "image|mimes:jpeg,jpg,png,bmp,gif,svg"
        ];
    }

}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\User;
use App\Mail\Welcome;
use Illuminate\Support\Facades\Mail;

/*
 * FormRequest objects can access any field of a form
 * e.g. if form has 'name' input, we can access by '$this->name'
 *
 *
 * In this example, the idea is to replace the work done with the
 * RegistrationController.php with this type of setup
 *
 *
 * This is a request class, but we can also think of this as a dedicated form object
 */

class RegistrationRequest extends FormRequest
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


        return [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'  // 'confirmed' requires that the check field have name&id of '<name>_confirmation'
        ];
    }



    /*
     * dedicated form object leaning methods we can setup
     */
    public function persist(){
        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password'))
            /*
             * This is a Request object, so we can use $this to reference the values
             * NOTE: request([...]) = request()->only([...])
             *
             */
            //$this->only(['name', 'email', 'password']) This was causing an allowance issue for some reason...


        ]);

        auth()->login($user);    // auth helper function



        Mail::to($user)->send(new Welcome($user));

    }


}

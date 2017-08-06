<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Api\RegisterRequest;
use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Request;

use App\Http\Controllers\Api\ApiController;
use Sentinel;

/**
 * API user registeration
 *
 * @Resource("Register", uri="/auth/register")
 */
class RegisterController extends ApiController
{
    /**
     * Get address of a given Latitude and Longitude
     *
     * @Post("/")
     *
     * @Versions({"v1"})
     *
     * @Request("email=digitaldreams40@gmail.com&password=abc123456&first_name=Demo&last_name=User&phone=01925******&address=Road,area&city=Dhaka&country=Bangaldesh&zip_code=1234", contentType="application/x-www-form-urlencoded")
     *
     * @Response(200, body={
    "data": {
    "id": 2,
    "first_name": null,
    "last_name": null,
    "name": " ",
    "email": "rosemichele12@gmail.com",
    "permissions": {},
    "source": null,
    "phone_number": null,
    "address": "Soke,Mailborne",
    "city": "",
    "state": "",
    "country": "",
    "zip_code": "",
    "created_at": "2017-04-25 06:54:25",
    "updated_at": "2017-04-25 06:54:25"
    }
    })
     * @Response(500, body={"message": "Something is wrong while creating user"})
     */
    public function store(RegisterRequest $request)
    {
        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        $user = Sentinel::registerAndActivate($credentials);

        if ($request->group === 'owner') {
            $role = Sentinel::findRoleBySlug('owner');
        } else {
            $role = Sentinel::findRoleBySlug('user');
        }
        $role->users()->attach($user);

        $user = User::find($user->id);
        $user->phone_number = $request->get('phone');
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');

        $user->address = $request->get('address');
        $user->city = $request->get('city');
        $user->state = $request->get('state');
        $user->country = $request->get('country');
        $user->zip_code = $request->get('zip_code');

        if ($user->save()) {
            return $this->response->item($user, new UserTransformer());
        }
        return $this->response->errorInternal('Something is wrong while creating user');
    }

}

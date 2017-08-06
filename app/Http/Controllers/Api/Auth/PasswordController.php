<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\ApiForgetPasswordEvent;
use App\Http\Requests\Api\Password\ForgetRequest;
use App\Http\Requests\Api\Password\ResetRequest;
use App\Http\Requests\Api\Password\SetRequest;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Codeception\Util\HttpCode;
use Illuminate\Http\Request;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Hash;

/**
 * Password
 *
 * @Resource("Google", uri="/auth/password")
 */
class PasswordController extends ApiController
{
    /**
     * Get address of a given Latitude and Longitude
     *
     * @Get("/forget")
     *
     * @Versions({"v1"})
     *
     * @Request("lat=23.816376599999998&lng=90.3701369", contentType="application/x-www-form-urlencoded")
     *
     * @Response(200, body={"status": 200, "result": "Mirpur,Dhaka"})
     * @Response(404, body={"message": "Could not find locality"})
     */

    public function forget(ForgetRequest $request)
    {
        $user = User::where('email', $request->get('email'))->first();
        event(new ApiForgetPasswordEvent($user));

        return $this->response->array(['status' => HttpCode::OK, 'message' => 'An email has ben sent to ' . $user->email . ' with code. Please get the code to continue']);
    }

    /**
     * Reset authenticate users password
     *
     * @Post("/reset")
     *
     * @Version({"v1"})
     *
     * @Request("password=old_password&new_password=my_new_password",contentType="application/x-www-form-urlencoded")
     *
     * @Response(200, body={"status": 200, "message": "Password successfully changed"})
     *
     * @Response(500, body={"message": "Error occured while changing password"})
     *
     * @Response(400, body={"message": "Current password does not match"})
     */
    public function reset(ResetRequest $request)
    {
        $user = $this->user;
        if (Hash::check($request->get('password'), $user->password)) {
            $user->password = bcrypt($request->get('new_password'));

            if ($user->save()) {
                return $this->response->array(['status' => HttpCode::OK, 'message' => 'Password successfully changed']);
            } else {
                return $this->response->errorInternal('Error occured while changing password');
            }
        } else {
            return $this->response->errorBadRequest('Current password does not match');
        }


    }

    /**
     *Set a new password after completing forget password procedural
     *
     * @Post("/set")
     *
     * @Version({"v1"})
     *
     * @Request("password=new_password&code=xxxxasdfsdfsdf25444&email=digitaldreams40@gmail.com",contentType="application/x-www-form-urlencoded")
     *
     * @Response(200, body={"status": 200, "message": "Password successfully set"})
     *
     * @Response(500, body={"message": "Error occured while setting your new password"})
     *
     */
    public function set(SetRequest $request)
    {
        $user = User::where('email', $request->get('email'))->first();
        $response = Reminder::complete($user, $request->get('code'), $request->get('password'));

        if ($response) {
            //It will remove records from reminders table so. So code can be used only once.
            Reminder::removeExpired();
            return $this->response->array(['status' => HttpCode::OK, 'message' => 'Password successfully set']);
        } else {
            return $this->response->errorInternal('Error occurred while setting your new password');
        }

    }
}

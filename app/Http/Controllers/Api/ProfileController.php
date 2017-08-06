<?php

namespace App\Http\Controllers\Api;

use App\Point;
use App\Transformers\PointTransformer;
use Illuminate\Http\Request;
use App\Transformers\UserTransformer;
use App\Http\Requests\Api\ProfileUpdate;

/**
 * Logged in User Profile
 *
 * @Resource("Profile", uri="/profile")
 */
class ProfileController extends ApiController
{
    /**
     * Get user object of logged in user
     *
     * @Get("/")
     *
     * @Versions({"v1"})
     *
     *
     * @Response(200, body={"data": {
    "id": 1,
    "first_name": null,
    "last_name": null,
    "name": " ",
    "email": "digitaldreams40@gmail.com",
    "permissions": {},
    "source": null,
    "phone_number": "01925000036",
    "address": "Mirpur,Dhaka",
    "city": "Dhaka",
    "state": "Dhaka",
    "country": "Bangladesh",
    "zip_code": 1216,
    "created_at": "2017-04-22 16:01:53",
    "updated_at": "2017-04-22 16:01:53"
    }})
     */
    public function show(Request $request)
    {
        return $this->response->item($this->user, new UserTransformer());
    }

    /**
     * Update logged in user profile information
     *
     * @Put("/")
     *
     * @Versions({"v1"})
     *
     * @Request("first_name=Tuhin&last_name=Bepari&email=digitaldreams40@gmail.com&phone_number=01925000036&address=Mirpur,Dhaka&city=Dhaka&zip_code=1216", contentType="application/x-www-form-urlencoded")
     *
     * @Response(200, body={"data": {
    "id": 1,
    "first_name": null,
    "last_name": null,
    "name": " ",
    "email": "digitaldreams40@gmail.com",
    "permissions": {},
    "source": null,
    "phone_number": "01925000036",
    "address": "Mirpur,Dhaka",
    "city": "Dhaka",
    "state": "Dhaka",
    "country": "Bangladesh",
    "zip_code": 1216,
    "created_at": "2017-04-22 16:01:53",
    "updated_at": "2017-04-22 16:01:53"
    }})
     *
     * @Response(400, body={"message": "Unable to update user profile"})
     */
    public function update(ProfileUpdate $request)
    {
        $user = $this->user;
        $user->fill($request->except(['password']));

        if ($user->save()) {
            return $this->response->item($user, new UserTransformer());
        } else {
            return $this->response->errorBadRequest('Unable to update user profile');
        }

    }

    /**
     * Get all points of auth user
     *
     * @Get("/points")
     *
     * @Versions({"v1"})
     *
     *
     * @Response(200, body={
    "data": {
    {
    "id": 1,
    "user_id": 1,
    "business_id": "121",
    "business_name": "Dance &amp; Yoga By Malexah",
    "type": "share",
    "quantity": 1,
    "description": "Social Share"
    }

    },
    "meta": {
    "pagination": {
    "total": 6,
    "count": 6,
    "per_page": 20,
    "current_page": 1,
    "total_pages": 1,
    "links": {}
    }
    }
    })
     */
    public function points(Request $request)
    {
        $points = Point::userId($this->user->id)->paginate(20);

        return $this->response->paginator($points, new PointTransformer());
    }

}

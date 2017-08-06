<?php

namespace App\Http\Controllers\Api;

use App\Transformers\UserTransformer;
use App\Models\User;
use Codeception\Util\HttpCode;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Users\DestoryRequest;
use App\Http\Requests\Api\Users\IndexRequest;
use App\Http\Requests\Api\Users\ShowRequest;
use App\Http\Requests\Api\Users\StoreRequest;
use App\Http\Requests\Api\Users\UpdateRequest;
use App\Http\Controllers\Controller;

/**
 * Type web service
 *
 * @Resource("Users", uri="/users")
 */
class UserController extends ApiController
{
    /**
     * List of users
     *
     * @Get("/")
     *
     * @Versions({"v1"})
     *
     * @Response(200, body={
    "data": {{
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
    }
    })
     */
    public function index(IndexRequest $request)
    {
        return $this->response->paginator(User::paginate(10), new UserTransformer());
    }

    /**
     * Show details about a user
     *
     * @Get("/{id}")
     *
     * @Versions({"v1"})
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
     * @Response(404, body={"message": "No query results for model [App\Models\User]."})
     */
    public function show(ShowRequest $request, User $user)
    {
        return $this->response->item($user, new UserTransformer());
    }

    /**
     * Create a user
     *
     *
     * @Post("/store")
     *
     * @Versions({"v1"})
     *
     * @Request("email=digitaldreams40@gmail.com&password=abc123456&first_name=Demo&last_name=User&phone=01925******&address=Road,area&city=Dhaka&country=Bangaldesh&zip_code=1234", contentType="application/x-www-form-urlencoded")
     *
     * @Response(200, body={
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
    })
     */
    public function store(StoreRequest $request)
    {

        $user = new User();

        $user->name = $request->get('last_name');
        $user->email = $request->get('last_name');
        $user->password = bcrypt($request->get('password'));
        //$user->phone_number = $request->get('phone');
        //$user->address = $request->get('address');

        if ($user->save()) {
            $user->roles()->sync($request->get('role_ids', []));
            return $this->response->item($user, new UserTransformer());
        } else {
            return $this->response->errorInternal('Error occured while saving User');
        }
    }

    /**
     * Update a existing user
     *
     * @Put("/{id}")
     *
     * @Versions({"v1"})
     *
     * @Request("email=digitaldreams40@gmail.com&first_name=Demo&last_name=User&phone=01925******&address=Road,area&city=Dhaka&country=Bangaldesh&zip_code=1234", contentType="application/x-www-form-urlencoded")
     *
     * @Response(200, body={
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
    })
     * @Response(404, body={"message": "No query results for model [App\\User]."})
     */
    public function update(UpdateRequest $request, User $users)
    {
        $user = $users;
        $user->email = $request->get('email');
        $user->name = $request->get('name');
        // $user->address = $request->get('address', $user->address);
        // $user->phone_number = $request->get('phone');

        if ($user->save()) {
            $user->roles()->sync($request->get('role_ids', []));

            return $this->response->item($user, new UserTransformer());
        } else {
            return $this->response->errorInternal('Error occured while saving User');
        }
    }

    /**
     * Delete an existing User
     *
     * @Delete("/{id}")
     *
     * @Versions({"v1"})
     *
     * @Response(200, body={
    "status": 200,
    "message": "User successfully deleted"
    })
     * @Response(404, body={"message": "No query results for model [App\\User]."})
     */
    public function destroy(DestoryRequest $request, User $users)
    {
        if ($users->delete()) {
            return $this->response->array(['status' => HttpCode::OK, 'message' => 'User successfully deleted']);
        } else {
            return $this->response->errorInternal('Error occured while deleting type');
        }
    }
}

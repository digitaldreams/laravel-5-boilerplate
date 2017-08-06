<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Roles\DestoryRequest;
use App\Http\Requests\Api\Roles\IndexRequest;
use App\Http\Requests\Api\Roles\ShowRequest;
use App\Http\Requests\Api\Roles\StoreRequest;
use App\Http\Requests\Api\Roles\UpdateRequest;
use App\Transformers\RoleTransformer;
use Codeception\Util\HttpCode;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Roles\EloquentRole as Role;

/**
 * Type web service
 *
 * @Resource("Role", uri="/roles")
 */
class RoleController extends ApiController
{
    /**
     * Show all the Roles
     *
     * @Get("/")
     *
     * @Versions({"v1"})
     *
     * @Response(200, body={
    "data": {
    {
    "id": 1,
    "name": "Administrator",
    "slug": "admin",
    "permissions": {
    "user.create": true,
    "user.delete": true,
    "user.view": true,
    "user.update": true
    },
    "created_at": "2017-04-14 03:15:10",
    "updated_at": "2017-04-14 03:15:10"
    }
    },
    "meta": {
    "pagination": {
    "total": 3,
    "count": 3,
    "per_page": 10,
    "current_page": 1,
    "total_pages": 1,
    "links": {}
    }
    }
    })
     */
    public function index(IndexRequest $request)
    {
        return $this->response->paginator(Role::paginate(10), new RoleTransformer());
    }

    /**
     * Show details about a specific Role
     *
     * @Get("/{id}")
     *
     * @Versions({"v1"})
     *
     * @Response(200, body={
    "data":  {
    "id": 1,
    "name": "Administrator",
    "slug": "admin",
    "permissions": {
    "user.create": true,
    "user.delete": true,
    "user.view": true,
    "user.update": true
    },
    "created_at": "2017-04-14 03:15:10",
    "updated_at": "2017-04-14 03:15:10"
    }
    })
     * @Response(404, body={"message": "No query results for model [App\\Role]."})
     */
    public function show(ShowRequest $request, Role $roles)
    {
        return $this->response->item($roles, new RoleTransformer());
    }

    /**
     * Create a new role
     *
     * @Post("/store")
     *
     * @Versions({"v1"})
     *
     * @Request("name=Manager&slug=manager&permissions[users.create]=1&permissions[users.update]=1", contentType="application/x-www-form-urlencoded")
     *
     * @Response(200, body= {
    "id": 4,
    "name": "Manager",
    "slug": "manager",
    "permissions": {
    "users.create": "1",
    "users.update": "1"
    },
    "created_at": "2017-05-01 07:13:03",
    "updated_at": "2017-05-01 07:13:03"
    })
     * @Response(404, body={"message": "No query results for model [App\\Role]."})
     */
    public function store(StoreRequest $request)
    {
        $role = (new Role())->fill($request->all());

        if ($role->save()) {
            return $this->response->item($role, new RoleTransformer());
        } else {
            return $this->response->errorInternal('Error occured while saving role');
        }
    }

    /**
     * Update a existing role
     *
     * @Put("/{id}")
     *
     * @Versions({"v1"})
     *
     * @Request("name=Administrator&slug=admin&permissions[0]=users.create", contentType="application/x-www-form-urlencoded")
     *
     * @Response(200, body= {
    "id": 1,
    "name": "Administrator",
    "slug": "admin",
    "permissions": {
    "user.create": true,
    "user.delete": true,
    "user.view": true,
    "user.update": true
    },
    "created_at": "2017-04-14 03:15:10",
    "updated_at": "2017-04-14 03:15:10"
    })
     * @Response(404, body={"message": "No query results for model [App\\Role]."})
     */
    public function update(UpdateRequest $request, Role $roles)
    {
        $roles->fill($request->all());

        if ($roles->save()) {
            return $this->response->item($roles, new RoleTransformer());
        } else {
            return $this->response->errorInternal('Error occured while saving Role');
        }
    }

    /**
     * Delete an existing role
     *
     * @Delete("/{id}")
     *
     * @Versions({"v1"})
     *
     * @Response(200, body={
    "status": 200,
    "message": "Role successfully deleted"
    })
     * @Response(404, body={"message": "No query results for model [App\\Role]."})
     */
    public function destroy(DestoryRequest $request, Role $roles)
    {
        if ($roles->delete()) {
            return $this->response->array(['status' => HttpCode::OK, 'message' => 'Role successfully deleted']);
        } else {
            return $this->response->errorInternal('Error occured while deleting Role');
        }
    }
}

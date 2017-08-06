<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Photo;
use App\Place as PlaceDB;
use App\User;
use Cartalyst\Sentinel\Roles\EloquentRole;

class RoleTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    private $validParams = ['q', 'limit', 'page'];

    /**
     * @var array
     */
    protected $availableIncludes = [
        'users'
    ];

    public function transform(EloquentRole $role)
    {
        return [
            'id' => $role->id,
            'name' => $role->name,
            'slug' => $role->slug,
            'permissions' => $role->getPermissions(),
            'created_at' => $role->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $role->updated_at->format('Y-m-d H:i:s'),
        ];

    }



}
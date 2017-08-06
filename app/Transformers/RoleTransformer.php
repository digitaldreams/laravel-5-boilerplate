<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\User;
use App\Models\Role;

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

    public function transform(Role $role)
    {
        return [
            'id' => $role->id,
            'name' => $role->name,
            'slug' => $role->slug,
            'created_at' => $role->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $role->updated_at->format('Y-m-d H:i:s'),
        ];
    }



}
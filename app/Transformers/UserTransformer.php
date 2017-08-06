<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Photo;
use App\Place as PlaceDB;
use App\User;

class UserTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    private $validParams = ['q', 'limit', 'page'];

    /**
     * @var array
     */
    protected $availableIncludes = [
        'favorites', 'owns', 'roles'
    ];
    protected $defaultIncludes = [
        'roles'
    ];

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'name' => $user->getFullName(),
            'email' => $user->email,
            'permissions' => $user->getPermissions(),
            'source' => $user->source,
            'phone_number' => $user->phone_number,
            'address' => $user->address,
            'city' => $user->city,
            'state' => $user->state,
            'country' => $user->country,
            'zip_code' => $user->zip_code,
            'created_at' => $user->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
        ];

    }

    public function includeFavorites(User $user)
    {
        return $this->collection($user->favorites, new PlaceTransformer());
    }

    public function includeOwns(User $user)
    {

    }

    public function includeRoles(User $user)
    {
        return $this->collection($user->getRoles(), new RoleTransformer());
    }


}
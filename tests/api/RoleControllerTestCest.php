<?php


class RoleControllerTestCest
{
    protected $endpoint = '/api/roles';

    /**
     * Return Root URL of the application
     * @return url
     */
    private function getEndPoint()
    {
        return env('APP_URL') . ($this->endpoint);
    }

    public function _before(ApiTester $I)
    {
        $type = env('API_STANDARDS_TREE', 'x');
        $appName = env('API_SUBTYPE', 'kernel');
        $version = env('API_VERSION', 'v1');
        $I->haveHttpHeader('Accept', "application/$type.$appName.$version+json");

        $token = JWTAuth::attempt(['email' => env('TEST_ADMIN_EMAIL'), 'password' => env('TEST_ADMIN_PASSWORD')]);
        $I->amBearerAuthenticated($token);
    }

    /**
     * Test single role data display api endpoint
     *
     * @link GET /roles/{id}
     *
     * @param ApiTester $I
     */
    public function getSingleRole(ApiTester $I)
    {
        $I->wantTo('Test single role');
        $id = \Cartalyst\Sentinel\Roles\EloquentRole::first()->id;
        $I->sendGET($this->getEndPoint() . "/$id");
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
    }

    /**
     * Test role data endpoint with pagination
     *
     * @link GET /roles
     * @param ApiTester $I
     */
    public function getAllRoles(ApiTester $I)
    {
        $I->wantTo('Test all roles');
        $I->sendGET($this->getEndPoint());
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
    }

    /**
     * Test roles Storage
     *
     * @link POST /roles
     * @param ApiTester $I
     */
    public function createRole(ApiTester $I)
    {
        $I->wantTo('Test role store');

        $role = [
            'slug' => 'Testing',
            'name' => 'testing',
        ];
        $I->sendPOST($this->getEndPoint(), $role);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseContainsJson(['slug' => 'Testing']);
    }

    /**
     * Update an existing roles Test
     *
     * @link  PUT /roles/{id}
     * @param ApiTester $I
     */
    public function updateRole(ApiTester $I)
    {
        $I->wantTo('Test role update');
        $role = \Cartalyst\Sentinel\Roles\EloquentRole::first();

        $data = [
            'slug' => 'Testing 2',
            'name' => 'testing2',
        ];
        $I->sendPUT($this->getEndPoint() . '/' . $role->id, $data);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);

        $I->seeResponseContainsJson(['name' => 'testing2']);
        $I->dontSeeResponseContainsJson(['name' => $role->name]);
    }

    /**
     * Delete an existing roles Test
     *
     * @link  DELETE /roles/{id}
     * @param ApiTester $I
     */
    public function deleteRole(ApiTester $I)
    {
        $I->wantTo('Test role destroy');
        $role = \Cartalyst\Sentinel\Roles\EloquentRole::first();
        $I->sendDELETE($this->getEndPoint() . '/' . $role->id);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseContainsJson(['message' => 'Role successfully deleted']);

    }
}

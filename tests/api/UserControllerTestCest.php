<?php
use JWTAuth;


class UserControllerTestCest
{
    protected $endpoint = '/api/users';

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

    public function _after(ApiTester $I)
    {
    }

    /**
     * Test single user data display api endpoint
     *
     * @link GET /users/{id}
     *
     * @param ApiTester $I
     */
    public function getSingleUser(ApiTester $I)
    {
        $I->wantTo('Test single users');
        $id = \App\Models\User::first()->id;
        $I->sendGET($this->getEndPoint() . "/$id");
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
    }

    /**
     * Test users data endpoint with pagination
     *
     * @link GET /users
     * @param ApiTester $I
     */
    public function getAllUsers(ApiTester $I)
    {
        $I->wantTo('Test all users');
        $I->sendGET($this->getEndPoint());
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
    }

    /**
     * Test Users Storage
     *
     * @link POST /users
     * @param ApiTester $I
     */
    public function createUser(ApiTester $I)
    {
        $I->wantTo('Test user store');

        $email = 'testing123@bloom.se';
        $user = [
            'first_name' => 'Testing',
            'last_name' => 'User',
            'email' => $email,
            'password' => 123456,
            'phone' => '+8801925000036',
            'role_ids' => \Cartalyst\Sentinel\Roles\EloquentRole::pluck('id')->toArray()
        ];
        $I->sendPOST($this->getEndPoint(), $user);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseContainsJson(['email' => $email]);
    }

    /**
     * Update an existing user Test
     *
     * @link  PUT /users/{id}
     * @param ApiTester $I
     */
    public function updateUser(ApiTester $I)
    {
        $I->wantTo('Test user update');
        $user = \App\Models\User::first();

        $data = [
            'first_name' => 'Testing',
            'last_name' => 'User',
            'email' => 'updatingtest123@bloom.se',
            'password' => 123456,
            'phone' => '+8801925000036',
         //   'role_ids' => \Cartalyst\Sentinel\Roles\EloquentRole::pluck('id')->toArray()
        ];
        $I->sendPUT($this->getEndPoint() . '/' . $user->id, $data);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);

        $I->seeResponseContainsJson(['email' => 'updatingtest123@bloom.se']);
        $I->dontSeeResponseContainsJson(['email' => $user->email]);
    }

    /**
     * Delete an existing user Test
     *
     * @link  DELETE /users/{id}
     * @param ApiTester $I
     */
    public function deleteUser(ApiTester $I)
    {
        $I->wantTo('Test user destroy');
        $user = \App\Models\User::first();
        $I->sendDELETE($this->getEndPoint() . '/' . $user->id);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseContainsJson(['message' => 'User successfully deleted']);

    }

}

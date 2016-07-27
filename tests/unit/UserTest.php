<?php


class UserTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testJsonDataField()
    {
        $user = factory(\App\User::class)->make();
        $this->assertNotEmpty($user->json_data);
    }
}
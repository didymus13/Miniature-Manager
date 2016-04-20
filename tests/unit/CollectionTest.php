<?php

class CollectionTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testDefaultOrder()
    {
        $faker = \Faker\Factory::create();
        $user = factory(\App\User::class)->create();
        $collections = factory(\App\Collection::class, 10)
            ->create(['user_id' => $user->id, 'updated_at' => $faker->dateTimeThisYear]);
        $expected = \App\Collection::orderBy('updated_at', 'desc')->get();
        $this->assertEquals($expected, \App\Collection::defaultOrder()->get());
    }
}
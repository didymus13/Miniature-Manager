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

    public function testCollectionPhotos()
    {
        $user = factory(\App\User::class)->create();
        $collection = factory(\App\Collection::class)->create(['user_id' => $user->id]);
        $mini = factory(\App\Miniature::class)->create(['collection_id' => $collection->id]);
        $photos = factory(\App\Photo::class, 10)->create([
            'imageable_type' => \App\Miniature::class,
            'imageable_id' => $mini->id
        ]);

        $this->assertCount(10, $collection->photos);
    }
}
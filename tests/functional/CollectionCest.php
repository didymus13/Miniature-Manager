<?php

class CollectionCest
{
    protected $url = '/collections';

    // tests
    public function tryToListCollections(FunctionalTester $I)
    {
        $I->am('user');
        $I->wantTo('get a list of collections');

        $user = factory(\App\User::class)->create();
        $collection = factory(\App\Collection::class)->create(['user_id' => $user->id]);

        $I->amOnRoute('collections.index');
        $I->seeResponseCodeIs(200);
        $I->see($collection->label);
        $I->see($collection->updated_at->diffForHumans());
    }

    public function tryToCreateACollection(FunctionalTester $I)
    {
        $I->am('anonymous user');
        $I->wantTo('create a collection');
        $I->amLoggedAs(factory(\App\User::class)->create());

        $I->amOnRoute('collections.create');

        $collection = factory(\App\Collection::class)->make();
        $I->fillField('label', $collection->label);
        $I->fillField('description', $collection->description);
        $I->click('Submit');

        $I->seeCurrentRouteIs('collections.show');
        $I->see($collection->label);
        $I->see($collection->description);
    }

    public function tryToShowCollection(FunctionalTester $I)
    {
        $I->am('user');
        $I->wantTo('show collection');

        $user = factory(\App\User::class)->create();
        $collection = factory(\App\Collection::class)->create(['user_id' => $user->id]);
        $mini = factory(\App\Miniature::class)->create(['collection_id' => $collection->id]);

        $I->amOnRoute('collections.index');
        $I->click($user->collections()->first()->label);

        $I->seeCurrentRouteIs('collections.show');
        $I->seeResponseCodeIs(200);
        $I->see($collection->label);
        $I->see($mini->label);
        $I->see($mini->progress);
        $I->see($mini->updated_at->diffForHumans());
    }

    public function tryToUpdateACollection(FunctionalTester $I)
    {

    }

    public function tryToDeleteACollection(FunctionalTester $I)
    {

    }
}

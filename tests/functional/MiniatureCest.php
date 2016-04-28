<?php


class MiniatureCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function tryToShowMiniature(FunctionalTester $I)
    {
        $user = factory(\App\User::class)->create();
        $collection = factory(\App\Collection::class)->create(['user_id' => $user->id]);
        $miniature = factory(\App\Miniature::class)->create(['collection_id' => $collection->id]);

        $I->am('user');
        $I->wantTo('see miniature details');
        
        $I->amOnRoute('miniatures.show', ['slug' => $miniature->slug]);
        $I->seeResponseCodeIs(200);
        $I->seeElement('#photo-gallery');
        $I->seeElement('div.ads');
    }
}

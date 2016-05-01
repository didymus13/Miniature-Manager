<?php


class PhotoCest
{
    // tests
    public function tryToShowPhoto(FunctionalTester $I)
    {
        $user = factory(\App\User::class)->create();
        $collection = factory(\App\Collection::class)->create(['user_id' => $user->id]);
        $miniature = factory(\App\Miniature::class)->create(['collection_id' => $collection->id]);
        $photo = factory(\App\Photo::class)->make();
        $miniature->photos()->save($photo);

        $I->am('user');
        $I->wantTo('see a photo');

        $I->amOnRoute('photos.show', ['id' => $photo->id]);
        $I->seeResponseCodeIs(200);
        $I->seeElement('div#photo');
        $I->seeElement('div.ads');
    }
}

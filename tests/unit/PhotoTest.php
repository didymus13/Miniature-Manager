<?php


class PhotoTest extends \Codeception\TestCase\Test
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
    public function testTitleProperty()
    {
        $photo = factory(\App\Photo::class)->make();
        $this->assertNotEmpty($photo->title);
    }
}
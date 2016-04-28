<?php


class SitemapCest
{
    // tests
    public function tryToSeeTheSitemap(FunctionalTester $I)
    {
        $I->am('google');
        $I->wantTo('crawl the sitemap');
        $I->amOnRoute('sitemap.index');
    }
}

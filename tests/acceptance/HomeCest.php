<?php

/**
 * Acceptance tests for the home page
 *
 * @see https://codeception.com/docs/03-AcceptanceTests
 */
class HomeCest
{
    public function tryToCheckIfTheHomePageWorks(AcceptanceTester $I)
    {
        $I->wantTo('Check if the home page works.');
        $I->amOnPage('/');
        $I->waitForText('Welcome to the home page');
    }

    public function tryToTestIfTheClickCounterIsWorking(AcceptanceTester $I)
    {
        $I->wantTo('Check if the click counter is working.');
        $I->amOnPage('/');
        $I->waitForText('Try clicking the button below');
        $I->click('Click me');
        $I->see('Hold on');
        $I->wait(2);
        $I->see('The button has been clicked 1 times');
        $I->click('Click me');
        $I->see('Hold on');
        $I->wait(2);
        $I->see('The button has been clicked 2 times');
    }
}

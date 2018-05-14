<?php

class HomeCest
{
    public function tryToTest(AcceptanceTester $I)
    {
        $I->wantTo('Check if the home page has the text I expect.');
        $I->amOnPage('/');
        $I->waitForText('Example Component', 5);
    }
}

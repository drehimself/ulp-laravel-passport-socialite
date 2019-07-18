<?php

namespace SocialiteProviders\Passportapp;

use SocialiteProviders\Manager\SocialiteWasCalled;

class PassportappExtendSocialite
{
    /**
     * Execute the provider.
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('passportapp', __NAMESPACE__.'\Provider');
    }
}

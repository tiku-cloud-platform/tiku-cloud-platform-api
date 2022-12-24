<?php
declare(strict_types = 1);

use App\Listener\ValidatorEmailFactoryResolvedListener;
use App\Listener\ValidatorScoreFactoryResolvedListener;
use App\Listener\ValidatorMobileFactoryResolvedListener;
use App\Listener\ValidatorMoneyFactoryResolvedListener;
use App\Listener\ValidatorTimeFactoryResolvedListener;

return [
    ValidatorMoneyFactoryResolvedListener::class,
    ValidatorMobileFactoryResolvedListener::class,
    ValidatorTimeFactoryResolvedListener::class,
    ValidatorEmailFactoryResolvedListener::class,
    ValidatorScoreFactoryResolvedListener::class,
];

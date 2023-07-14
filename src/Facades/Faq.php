<?php

namespace Wepa\Faq\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Wepa\Faq\Faq
 */
class Faq extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Wepa\Faq\Faq::class;
    }
}

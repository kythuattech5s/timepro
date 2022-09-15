<?php

namespace Tech5sShoppingCart\Tech5sCart\Facades;
use Illuminate\Support\Facades\Facade;
class Tech5sCart extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Tech5sCart';
    }
}
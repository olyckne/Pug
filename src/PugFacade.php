<?php namespace Olyckne\Pug;

use Illuminate\Support\Facades\Facade;

class PugFacade extends Facade {


    /**
     * The name of the binding in the IoC container.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return "Pug";
    }
}
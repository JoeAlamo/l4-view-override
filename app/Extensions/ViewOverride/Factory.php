<?php
/**
 * Created by PhpStorm.
 * User: Joe Alamo
 * Date: 18/07/2015
 * Time: 19:48
 */

namespace app\Extensions\ViewOverride;

class Factory extends \Illuminate\View\Factory {
    protected $dummyProperty = 'test';
}
<?php

namespace Steria\SolidaUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SteriaSolidaUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

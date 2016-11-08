<?php

namespace AppBundle\Service;

interface InvalidateInterface
{
    /**
     * @param string $url URL to invalidate
     * @return bool
     */
    public function invalidate($url);
}

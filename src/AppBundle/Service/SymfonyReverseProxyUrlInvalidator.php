<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\Request;

class SymfonyReverseProxyUrlInvalidator implements InvalidateInterface
{
    private $kernel;

    public function __construct($kernel)
    {
        $this->kernel = new \AppCache($kernel);
    }

    /**
     * @inheritdoc
     */
    public function invalidate($url)
    {
        if (empty($url)) {
            throw new \InvalidArgumentException('No URL to invalidate provided!');
        }
        $request = Request::create($url);
        $request->setMethod('PURGE');

        return $this->kernel->handle($request);
    }
}

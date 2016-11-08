<?php

namespace Tests\AppBundle\Service;

use AppBundle\Service\SymfonyReverseProxyUrlInvalidator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SymfonyReverseProxyUrlInvalidatorTest extends WebTestCase
{
    public function test_should_throw_exception_for_empty_url()
    {
        $this->expectException(\InvalidArgumentException::class);

        $kernel = new \AppKernel('prod', false);
        $invalidator = new SymfonyReverseProxyUrlInvalidator($kernel);

        $invalidator->invalidate('');
    }

    public function test_invalidate()
    {
        $kernel = new \AppKernel('prod', false);
        $invalidator = new SymfonyReverseProxyUrlInvalidator($kernel);

        $response = $invalidator->invalidate('url');

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}

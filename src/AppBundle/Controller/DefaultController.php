<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->redirectToRoute('cache_expire_max_age');
    }

    public function cacheMaxAgeAction()
    {
        $response = $this->render('cache/max-age.html.twig');

        $response->setPublic();
        $response->setMaxAge(10);
        //or
        //$response->setSharedMaxAge(10);

        return $response;
    }

    public function cacheDateAction()
    {
        $response = $this->render('cache/expire-date.html.twig');

        $response->setPublic();
        $date = new \DateTime();
        $date->modify('+10 seconds');
        $response->setExpires($date);

        return $response;
    }

    public function esiAction()
    {
        $response = $this->render('cache/esi.html.twig');
        $response->setSharedMaxAge(10);

        return $response;
    }

    public function esiPartAction()
    {
        return $this->render('cache/esi-part.html.twig');
    }

    public function cacheMaxAgeHourAction()
    {
        $response = $this->render('cache/max-age-hour.html.twig');
        $response->setSharedMaxAge(3600);

        return $response;
    }

    public function cacheInvalidationAction(Request $request)
    {
        $referer = $request->headers->get('referer');
        if (!$referer) {
            throw new \Exception('No referer!');
        }

        $invalidator = $this->get('symfony_reverse_proxy_url_invalidator');
        try {
            $response = $invalidator->invalidate($referer);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return $this->render('cache/invalidate.html.twig', ['referer' => $referer, 'response' => $response]);
    }
}

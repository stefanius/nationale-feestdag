<?php

namespace Stefanius\NationalHolidayBundle\Controller;

use Stefanius\NationalHolidayBundle\Model\Domain;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SitemapController extends Controller
{
    protected $months = [
        'januari'   => 1,
        'februari'  => 2,
        'maart'     => 3,
        'april'     => 4,
        'mei'       => 5,
        'juni'      => 6,
        'juli'      => 7,
        'augustus'  => 8,
        'september' => 9,
        'oktober'   => 10,
        'november'  => 11,
        'december'  => 12,
    ];

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Request $request)
    {
        $domain = new Domain($request);

        $response = $this->render('StefaniusNationalHolidayBundle:Sitemaps:default.xml.twig', [
            'links'  => $this->buildSitemapLinks($domain, $request),
            'domain' => $domain,
            'months' => array_keys($this->months),
        ]);

        $response->headers->set('Content-Type', 'xml');

        return $response;
    }

    /**
     * @param Domain $domain
     * @param Request $request
     *
     * @return array
     */
    protected function buildSitemapLinks(Domain $domain, Request $request)
    {
        $links = [];

        if (!$domain->hasYearSpecificDomain()) {
            return [$request->getSchemeAndHttpHost()];
        }

        foreach ($this->months as $key => $value) {
            $links["{$request->getSchemeAndHttpHost()}/{$key}"] = "{$request->getHttpHost()}/{$key}";
        }

        return $links;
    }
}

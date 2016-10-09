<?php

namespace Stefanius\NationalHolidayBundle\Twig;

use Carbon\Carbon;

class CarbonExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('localize', array($this, 'localizeFilter')),
        ];
    }

    public function localizeFilter(\DateTime $dateTime, string $format = null)
    {
        $carbon = Carbon::createFromTimestampUTC($dateTime->getTimestamp());
        $carbon->setTimezone(new \DateTimeZone('Europe/Amsterdam'));
        setlocale(LC_ALL, 'nl_NL');


        $carbon->setTimezone(new \DateTimeZone('Europe/Amsterdam'));
        return $carbon->formatLocalized($format);
    }

    public function getName()
    {
        return 'app_extension';
    }
}
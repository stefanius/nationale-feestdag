<?php

namespace Stefanius\NationalHolidayBundle\Model;

use Symfony\Component\HttpFoundation\Request;

class Domain
{
    protected $request;

    protected $year;

    /**
     * @param $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function hasYearSpecificDomain(): bool
    {
        $splitTld = explode('.', $this->request->getHttpHost());
        $splitOnDashes = explode('-', $splitTld[0]);

        return array_key_exists(2, $splitOnDashes) && is_numeric($splitOnDashes[2]) && strlen($splitOnDashes[2]) === 4;
    }

    /**
     * @return integer
     */
    public function pickYear(): int
    {
        if ($this->hasYearSpecificDomain()) {
            $splitTld = explode('.', $this->request->getHttpHost());
            $splitOnDashes = explode('-', $splitTld[0]);

            return (int) $splitOnDashes[2];
        }

        return 0;
    }
}

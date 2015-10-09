<?php

namespace Stefanius\NationalHolidayBundle\Model;

class Page
{
    protected $title;

    protected $description;

    protected $domainYear;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDomainYear()
    {
        return $this->domainYear;
    }

    /**
     * @param mixed $domainYear
     */
    public function setDomainYear($domainYear)
    {
        $this->domainYear = $domainYear;
    }
}
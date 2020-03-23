<?php

namespace Studiosidekicks\Alfred\Pagination\Services;

class PaginationDetails
{
    private $perPage;

    public function __construct()
    {
        $this->setPerPage(20);
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * @param int $defaultPerPage
     */
    public function setPerPage(int $defaultPerPage)
    {
        $limitFromRequest = request()->get('limit', $defaultPerPage);

        if (!in_array($limitFromRequest, [20, 50, 100, 150, 200])) {
            $this->perPage = $defaultPerPage;
            return;
        }

        $this->perPage = $limitFromRequest;
    }

}

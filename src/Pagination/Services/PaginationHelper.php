<?php

namespace Studiosidekicks\Alfred\Pagination\Services;

class PaginationHelper
{
    private $details;

    public function __construct()
    {
        $this->details = new PaginationDetails();
    }

    public function resolveQuery($query, $columns)
    {
        if (request()->filled('no_pagination')) {
            return $query->get($columns);
        }

        return $query->paginate($this->details->getPerPage(), $columns);
    }

}

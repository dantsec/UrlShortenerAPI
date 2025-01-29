<?php

namespace App\Services;

use App\Models\Url;
use Illuminate\Pagination\LengthAwarePaginator;

class MetricService
{
    /**
     * @param Url $url
     * @param array $filters
     *
     * @return LengthAwarePaginator
     */
    public function getFilteredMetrics(Url $url, array $filters, array $availableFields): LengthAwarePaginator
    {
        $query = $url->metrics();

        // Filtering
        foreach ($availableFields as $filter) {
            if (!empty($filters[$filter])) {
                $query->where($filter, $filters[$filter]);
            }
        }

        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
        }

        // Sorting
        if (!empty($filters['sort_by']) && !empty($filters['order'])) {
            $query->orderBy($filters['sort_by'], $filters['order']);
        }

        // Paginating
        return $query->paginate($filters['per_page'] ?? 10);
    }
}

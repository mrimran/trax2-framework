<?php

namespace Trax\XapiStore\Stores\Statements;

use Illuminate\Support\Collection;
use Trax\Repo\Querying\Query;
use Trax\XapiValidation\Statement;

trait XapiStatementRepository
{
    /**
     * Get statements conforming with the standard process.
     *
     * @param \Trax\Repo\Querying\Query  $query
     * @return \Illuminate\Support\Collection
     */
    public function getWithStandardProcess(Query $query = null): Collection
    {
        // Sequence based request.
        // Get only unvoided statements.
        // Do not check targeted statements.

        if ($query->hasLimit() || (
            !$query->hasFilter('agent')
            && !$query->hasFilter('verb')
            && !$query->hasFilter('activity')
            && !$query->hasFilter('registration')
        )) {
            // Force the limit.
            if (!$query->hasLimit()) {
                $query->setLimit(config('trax-xapi-store.limit', 100));
            }
            // Request.
            return $this->addFilter(['voided' => false])->getRelationalFirst($query);
        }

        // Not sequence based. We must check the targeted statements, including voided ones.
        // This process is not perfect because it will happen under the default limit.
        // So the number of returned statements may be under the default limit,
        // which does not mean that is no other matching statement.
        // We recommended to limit the use of StatementRefs.

        // Force the limit.
        if (!$query->hasLimit()) {
            $query->setLimit(config('trax-xapi-store.limit', 100));
        }
        // Request.
        $all = $this->getRelationalFirst($query);
        $result = $all->where('voided', false);

        $targeting = $all;
        while (!$targeting->isEmpty()) {
            //
            $targeting = $this->addFilter([
                'data->object->objectType' => 'StatementRef',
                'data->object->id' => ['$in' => $targeting->pluck('data.id')],
            ])->getRelationalFirst();

            $result =  $this->mergeCollections($result, $targeting);
        }
        
        // Keep unvoided and unique statements.
        return $result->where('voided', false)->unique('id');
    }

    /**
     * Finalize a resource before returning it.
     *
     * @param  \Illuminate\Database\Eloquent\Model|object  $resource
     * @param  \Trax\Repo\Querying\Query  $query
     * @return \Illuminate\Database\Eloquent\Model|object
     */
    public function finalize($resource, Query $query = null)
    {
        // Get statement OBJECT. DB query builder returns json encoded data.
        $statement = $resource->data;
        if (is_string($statement)) {
            $statement = json_decode($statement);
        }

        // Early exit for performance improvement.
        if (!isset($query) || (!$query->hasOption('format') && !$query->hasOption('reorder'))) {
            $resource->data = $statement;
            return $resource;
        }

        // Format.
        $format = isset($query) ? $query->option('format', 'exact') : 'exact';
        $lang = isset($query) ? $query->option('lang') : null;
        $statement = Statement::format($statement, $format, $lang);

        // Reorder props for readability.
        $reorder = isset($query) ? $query->option('reorder') : false;
        if ($reorder) {
            $statement = Statement::reorderStatement($statement);
        }

        // Result.
        $resource->data = $statement;
        return $resource;
    }

    /**
     * Merge 2 collections.
     * Because ->merge function does not work with collections of MongoDB models.
     *
     * @param  \Illuminate\Support\Collection  $collection1
     * @param  \Illuminate\Support\Collection  $collection2
     * @return \Illuminate\Support\Collection
     */
    protected function mergeCollections(Collection $collection1, Collection $collection2): Collection
    {
        return collect(array_merge($collection1->all(), $collection2->all()));
    }
}

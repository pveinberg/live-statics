<?php

namespace Petrelli\LiveStatics\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;


trait Pagination
{


    /**
     *
     * Total number of pages to return
     *
     * The paginator will behave as expected until page number `$totalPages`.
     * In that case that one will be the last one and our
     * `LengthAwarePaginator` will behave appropriately
     *
     */
    protected $totalPages = 3;


    /**
     *
     * Pagination emulator builder
     *
     *
     * We have two ways of using it:
     *
     * 1 - We pass a class/interface to be instantiated, and the number of elements
     *     per page.
     *
     *
     * 2 - We pass null for the class/interface, the number of elements per page, and
     *     an array with all elements to be returned. This use case is not common but it
     *     can be useful when we need very tight control over the results.
     *
     *
     * And then to use it just add something like this:
     *
     * public function paginate($perPage = 8)
     * {
     *     return $this->buildPaginator(VideoInterface::class, $perPage);
     * }
     *
     *
     * Or if you don't need a special case, forget about these steps and simply `paginate`
     * as with Eloquent. This will build the paginator with our default options that
     * are usually ok for most cases.
     *
     */
    protected function buildPaginator($klass, $perPage, $items = [])
    {

        if (empty($items)) {
            for($n = 1; $n <= $perPage ; $n ++) {
                array_push($items, app($klass));
            }
        }

        $total = $perPage * $this->totalPages;
        $currentPage = 1;

        return new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            Paginator::resolveCurrentPage(),
            [
                'path' => Paginator::resolveCurrentPath()
            ]
        );

    }


    /**
     *
     * Paginate helper.
     *
     *
     * Emulates the behavior from Eloquent paginator
     *
     * These default values are usually ok for prototypes but
     * can be easily modified just overloading this function
     *
     */
    public function paginate($perPage = 8)
    {

        return $this->buildPaginator(static::$baseInterface, $perPage);

    }


}

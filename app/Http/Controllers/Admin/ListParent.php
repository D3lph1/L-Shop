<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Class ListParent
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin
 */
class ListParent extends Controller
{
    /**
     * @var array
     */
    protected $orderByAvailable = [
        'id',
        'name'
    ];

    /**
     * @var array
     */
    protected $filtersAvailable = [
        'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р',
        'С', 'Т', 'У', 'Ф','Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ю', 'Я', 'A', 'B', 'C', 'D', 'E', 'F', 'G',
        'H', 'I', 'J', 'K', 'L', 'K', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W',
        'X', 'Y', 'Z'
    ];

    protected function checkOrderBy(string $orderBy): ?string
    {
        $orderBy = mb_strtolower($orderBy);

        if (in_array($orderBy, $this->orderByAvailable)) {
            return $orderBy;
        }

        return null;
    }

    protected function checkOrderType(string $orderType): ?string
    {
        $orderType = strtolower($orderType);

        if ($orderType == 'asc' or $orderType == 'desc') {
            return $orderType;
        }

        return null;
    }
}

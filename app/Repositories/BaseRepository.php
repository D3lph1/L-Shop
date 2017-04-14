<?php

namespace App\Repositories;

use App\Exceptions\InvalidArgumentTypeException;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class BaseRepository
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Repositories
 */
abstract class BaseRepository
{
    /**
     * Find by id
     *
     * @param int $id
     *
     * @return mixed
     */
    public function find($id)
    {
        if (!is_int($id)) {
            throw new InvalidArgumentTypeException('integer', $id);
        }

        return $this->query()->find($id);
    }

    /**
     * Update by id
     *
     * @param int   $id
     * @param array $attributes
     *
     * @return bool
     */
    public function update($id, array $attributes)
    {
        if (!is_int($id)) {
            throw new InvalidArgumentTypeException('integer', $id);
        }

        return $this->query()->where('id', $id)
            ->update($attributes);
    }

    /**
     * Delete by id
     *
     * @param int|array $id
     *
     * @return bool|null
     */
    public function delete($id)
    {
        if (!(is_int($id) or is_array($id))) {
            throw new InvalidArgumentTypeException('integer', $id);
        }

        if (is_array($id)) {
            return $this->query()->whereIn('id', $id)->delete();
        }

        return $this->query()->where('id', $id)->delete();
    }

    /**
     * Checks for existence by id
     *
     * @param int $id
     *
     * @return bool
     */
    public function exists($id)
    {
        if (!is_int($id)) {
            throw new InvalidArgumentTypeException('integer', $id);
        }

        return $this->query()->where('id', $id)->exists();
    }

    /**
     * Checking argument on a valid type
     *
     * @throws InvalidArgumentTypeException
     *
     * @param null|string|array $columns
     *
     * @return mixed
     */
    protected function prepareColumns($columns = null)
    {
        if (is_null($columns)) {
            return '*';
        }

        if (is_string($columns)) {
            return $columns;
        }

        if (is_array($columns)) {
            if (count($columns) === 0) {
                return '*';
            }

            return $columns;
        }

        throw new InvalidArgumentTypeException(['string', 'array'], $columns);
    }

    /**
     * @return Builder
     */
    private function query()
    {
        return call_user_func(static::MODEL . '::query');
    }
}

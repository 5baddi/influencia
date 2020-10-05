<?php

namespace App\Interfaces;


use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

/**
* Interface EloquentRepositoryInterface
* @package App\Repositories
*/
interface EloquentRepositoryInterface
{

    /**
     * @return Collection
     */
    public function all() : Collection;

   /**
    * @param int $id
    * @return Model
    */
   public function find(int $id) : ?Model;

    /**
    * @param array $attributes
    * @return Model
    */
    public function create(array $attributes) : Model;

    /**
    * @param Model $model
    * @param array $data
    * @return Model
    *
    */
   public function update(Model $entity, array $data) : Model;
}
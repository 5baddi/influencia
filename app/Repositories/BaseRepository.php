<?php   

namespace App\Repositories;   

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\EloquentRepositoryInterface;

class BaseRepository implements EloquentRepositoryInterface 
{     
    /**      
     * @var Model      
     */     
     protected $model;       

    /**      
     * BaseRepository constructor.      
     *      
     * @param Model $model      
     */     
    public function __construct(Model $model)     
    {         
        $this->model = $model;
    }
 
    /**
    * @param int $id
    * @return Model
    */
    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * List all model rows
     * 
     * @return Collection
     */
    public function all() : Collection
    {
        return $this->model->all();
    }

    
    /**
    * @param array $attributes
    *
    * @return Model
    */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
    * @param Model $model
    * @param array $data
    *
    * @return Model
    */
    public function update(Model $entity, array $data) : Model
    {
        $entity->update($data);

        return $entity->refresh();
    }
}
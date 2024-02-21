<?php

namespace App\Repositories;

use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
  protected $model;
  protected $app;

  public function __construct()
  {
    $this->app = new Application;
    $this->makeModel();
  }

  abstract public function model();

  public function makeModel()
  {
    $model = $this->app->make($this->model());

    if (!$model instanceof Model) {
      throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
    }

    return $this->model = $model;
  }

  public function create($input)
  {
    $model = $this->model->newInstance($input);
    $model->save();

    return $model;
  }

  public function find($id, $columns = ['*'])
  {
    $query = $this->model->newQuery();

    return $query->find($id, $columns);
  }

  public function update($input, $id)
  {
    $query = $this->model->newQuery();
    $model = $query->findOrFail($id);
    $model->fill($input);
    $model->save();

    return $model;
  }

  public function delete($id)
  {
    $query = $this->model->newQuery();
    $model = $query->findOrFail($id);
    return $model->delete();
  }

  public function all($columns = ['*'])
  {
    return $this->model->get($columns);
  }

  public function newQuery()
  {
    return $this->model->newQuery();
  }

  public function paginate($per_page) 
  {
    return $this->model->paginate($per_page);
  }

  public function check_exists($column, $value)
  {
    return $this->newQuery()->where($column, $value)->exists();
  }
}

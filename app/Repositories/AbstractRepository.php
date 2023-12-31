<?php

namespace App\Repositories;

use App\Trait\StringTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements IEntityRepository
{
    use StringTrait;
    /**
     * @var Model
     */
    protected $model;


    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        $result = $this->model->find($id);
        if($result) {
            return $result;
        }
        return false;
    }

    public function findByKey($key, $value)
    {
        $result = $this->model->where($key, $value)->first();
        if($result) {
            return $result;
        }
        return false;
    }

    public function findAllByKey($key, $value)
    {
        $result = $this->model->where($key, $value)->get();
        if($result) {
            return $result;
        }
        return false;
    }

    public function store($data,$key = 'id')
    {
        $data = $this->convertToSnakeCase($data);
        $id = isset($data[$key]) ? $data[$key] : null;
        $this->model->fill($data);
        if($this->model->validate($data)) {
            $item = $this->model->updateOrCreate(
                [$key => $id],
                $data
            );
            return $item;
        }
        return false;
    }

    public function update($id, $data)
    {
        $data['updated_at'] = Carbon::now();
        $data = $this->convertToSnakeCase($data);
        $this->model->fill($data);
        if($this->model->validate($data)) {
            if(!$this->model->where('id', $id)->update($data)) {
                return false;
            }
        }
        return true;
    }

    public function delete($id)
    {
        return $this->model->where('id', $id)->delete();
    }


}
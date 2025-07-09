<?php

namespace App\Models;

/**
 * Base Model Class
 */
class BaseModel 
{
    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];
    
    public function __construct()
    {
        if (!$this->table) {
            $this->table = strtolower(str_replace('Model', '', 
                (new \ReflectionClass($this))->getShortName()
            )) . 's';
        }
    }
    
    public function all($columns = ['*'])
    {
        $sql = "SELECT " . implode(', ', $columns) . " FROM {$this->table}";
        return \Database::query($sql)->fetchAll();
    }
    
    public function find($id, $columns = ['*'])
    {
        $sql = "SELECT " . implode(', ', $columns) . " FROM {$this->table} WHERE {$this->primaryKey} = ?";
        return \Database::query($sql, [$id])->fetch();
    }
    
    public function where($column, $operator, $value = null, $columns = ['*'])
    {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }
        
        $sql = "SELECT " . implode(', ', $columns) . " FROM {$this->table} WHERE {$column} {$operator} ?";
        return \Database::query($sql, [$value])->fetchAll();
    }
    
    public function create($data)
    {
        $data = $this->filterFillable($data);
        
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        
        \Database::query($sql, $data);
        
        return \Database::connection()->lastInsertId();
    }
    
    public function update($id, $data)
    {
        $data = $this->filterFillable($data);
        
        $set = [];
        foreach (array_keys($data) as $column) {
            $set[] = "{$column} = :{$column}";
        }
        
        $sql = "UPDATE {$this->table} SET " . implode(', ', $set) . " WHERE {$this->primaryKey} = :id";
        $data['id'] = $id;
        
        return \Database::query($sql, $data);
    }
    
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        return \Database::query($sql, [$id]);
    }
    
    public function paginate($page = 1, $perPage = null)
    {
        $perPage = $perPage ?? \App::config('items_per_page');
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT * FROM {$this->table} LIMIT {$perPage} OFFSET {$offset}";
        $data = \Database::query($sql)->fetchAll();
        
        $countSql = "SELECT COUNT(*) as total FROM {$this->table}";
        $total = \Database::query($countSql)->fetch()['total'];
        
        return [
            'data' => $data,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage)
        ];
    }
    
    protected function filterFillable($data)
    {
        if (empty($this->fillable)) {
            return $data;
        }
        
        return array_intersect_key($data, array_flip($this->fillable));
    }
}

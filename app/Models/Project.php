<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model{
    use HasFactory;
    protected $guarded = [];
    /**
     * The project has many tasks
     * @return array All related tasks with this project
     */
    public function Task(){
        return $this->hasMany(Task::class, 'project_id');
    }
}

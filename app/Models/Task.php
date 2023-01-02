<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model{
    use HasFactory;
    protected $guarded = [];
    public $appends = ['is_completed'];

    /**
     * Task model belong to one user
     * @return int The user id of the task
     */
    public function User(){
        return $this->belongsTo(User::class , 'user_id');
    }
    /**
     * Task model belong to one project
     * @return int The project id of the task
     */
    public function Project(){
        return $this->belongsTo(Project::class , 'project_id');
    }
    /**
     * Custom attribute return task status
     * @return boolean The task status
     */
    public function getIsCompletedAttribute(){
        return $this->status == 'done';
    }

}

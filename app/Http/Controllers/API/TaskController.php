<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;


class TaskController extends BaseController{

    /**
     *Get all tasks
     *
     * @return object All tasks
     */
    public function index(){
        return $this->sendResponse(Task::all(), 'All tasks sent');
    }
    /**
     * Create a new task
     *
     * The function will create a new task after make sure the user and project exists
     *
     * @param Request $r
     *
     * @return object The created task data
     */
    public function store(Request $r){
        $validator = Validator::make($r->all(), [
            'title' => 'required',
            'description' => 'required',
            'project_id' => 'required',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Please validate error', $validator->errors(),422);
        }
        //Check if the user exists
        $user = User::find($r->user_id);
        if (!$user) {
            return $this->sendError('User not found');
        }
        //Check if the project exists
        $TheProject = Project::find($r->project_id);
        if (!$TheProject) {
            return $this->sendError('Project not found');
        }
        $input = Task::create($r->all());
        return $this->sendResponse($input, 'Task created successfully');
    }

    /**
     * Get specific task
     *
     * @param int $id
     *
     * @return [type]
     */
    public function show($id){
        $project = Task::find($id);
        if (is_null($project)) {
            return $this->sendError('Task not found');
        }
        return $this->sendResponse($project, 'Task found successfully');
    }

    /**
     * Update task
     *
     * The function will update task after make sure the user, task and project exists and task status is pending
     *
     * @param Request $r Requested data
     * @param int $id The task id
     *
     * @return object The updated task data
     */
    public function update(Request $r, $id){
        $validator = Validator::make($r->all(), [
            'title' => 'required',
            'description' => 'required',
            'project_id' => 'required',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Please validate error', $validator->errors());
        }
        //Check if the user exists
        $user = User::find($r->user_id);
        if (!$user) {
            return $this->sendError('User not found', 404);
        }
        //Check if the project exists
        $TheProject = Project::find($r->project_id);
        if (!$TheProject) {
            return $this->sendError('Project not found', 404);
        }
        $task = Task::find($id);
        if (is_null($task)) {
            return $this->sendError('Task not found', 404);
        }
        if ($task->status == 'done') {
            return $this->sendError('Task aleady done', 403);
        }
        $task->update($r->all());
        return $this->sendResponse($task, 'Task  successfully');
    }

    /**
     * Delete Task
     *
     * The function will delete the task after make sure the task exists
     *
     * @param int $id
     *
     * @return object The deleted task data
     */
    public function destroy(Task $id){
        $task = Task::find($id);
        if (!$task) {
            return $this->sendError('Project not found');
        }
        $task->delete();
        return $this->sendResponse($task, 'Task deleted successfully');
    }

    /**
     * Get all tasks
     *
     * The function returns all tasks to all employees(authenticated or not)
     *
     * @return object All tasks data
     */
    public function allTasks(){
        return $this->sendResponse(Task::all(), 'All Tasks sent');
    }

    /**
     * Submit task as done from employees
     *
     * The function updates the task as done after making sure the user has assigned before to the task and the task exists
     *
     * @param object $r The requested data
     * @param int $id Task id
     *
     * @return object The deleted task data
     */
    public function submitTask(Request $r, $id){
        $userId = auth()->user()->id;
        $task = Task::find($id);
        $data = $r->all();
        if (is_null($task)) {
            return $this->sendError('Task not found', 404);
        }
        if ($task->user_id != $userId) {
            return $this->sendError('You cannot submit this task', 403);
        }
        $validator = Validator::make($data, [
            'status' => 'required',
            'user_description' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Please validate error', $validator->errors());
        }
        if ($task->IsCompleted) {
            return $this->sendError('Task already done', 403);
        }
        $task->status = $r->status;
        $task->user_description = $r->user_description;
        $task->save();
        return $this->sendResponse('Task updated successfully', 200);
    }
}

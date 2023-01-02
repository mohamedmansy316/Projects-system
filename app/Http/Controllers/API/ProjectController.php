<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;

class ProjectController extends BaseController{

    /**
     * Get all projects
     *
     * @return object of projects
     */
    public function index(){
        $projects = Project::all();
        return $this->sendResponse($projects, 'All projects sent');
    }

    /**
     * Create a new project
     *
     * @param array
     *
     * @return object of created data
     */
    public function store(Request $r){
        $validator = Validator::make($r->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Please validate error', $validator->errors(),422);
        }
        Project::create($r->all());
        return $this->sendResponse($r->all(), 'Project created successfully');
    }

    /**
     * Get specific project
     *
     * @param array $id The project id
     *
     * @return object of created data
     */
    public function show($id){
        $project = Project::find($id);
        if (!$project) {
            return $this->sendError('Project not found');
        }
        return $this->sendResponse($project ,'Project found successfully');
    }

    /**
     * Update specific project
     *
     * @param object $r The requested data , @param int $id
     *
     * @return object of updated data
     */
    public function update(Request $r, Project $id){
        $validator = Validator::make($r->all() , [
            'title'=> 'required',
            'description'=> 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Please validate error' ,$validator->errors(),422);
        }
        $id->update($r->all());
        return $this->sendResponse($id ,'Project updated successfully');
    }

    /**
     * Delete project
     *
     * @param int $id The project id
     *
     * @return object of deleted project
     */
    public function destroy($id){
        $project = Project::find($id);
        if (!$project) {
            return $this->sendError('Project not found');
        }
        $project->delete();
        return $this->sendResponse($project ,'Project deleted successfully');

    }
}

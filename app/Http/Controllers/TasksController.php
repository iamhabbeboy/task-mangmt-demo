<?php

namespace App\Http\Controllers;

use App\Repository\Contract\ProjectRepositoryInterface;
use App\Repository\Contract\TaskRepositoryInterface;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function __construct(public TaskRepositoryInterface $taskRepository, public ProjectRepositoryInterface $projectRepository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $projects = $this->projectRepository->findAll();
        $tasks = $this->taskRepository->findAll(['limit' => 5]);

        if($request->get('project_id')) {
            $projectId = $request->get('project_id');
            $tasks = $this->taskRepository->findAll(['project' => $projectId]);
        }

        return view('welcome', ['tasks' => $tasks, 'projects' => $projects, 'projectId' => $request->get('project_id') ?? '']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'priority' => 'required|integer',
            'project' => 'required|string'
        ]);
        $projectId = $request->project;
        if(!preg_match('/\d/', $request->project)) {
            $projectId = $this->projectRepository->store(['name' => $request->project])->id;
        }
        $data = $request->all();
        $data['project_id'] = $projectId;

        try {
            $this->taskRepository->store($data);
            return redirect()->route('task.index')->with('success', 'Task created successfully');
        }catch(\Exception $e) {
            return redirect()->route('task.index')->with('success', 'Error occured: '. $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        dd($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'priority' => 'sometimes'
        ]);

        $response = $this->taskRepository->update($id, $request->toArray());

        return redirect()->route('task.index')->with('success', 'Task updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $response = $this->taskRepository->delete($id);
        return redirect()->route('task.index')->with('success', 'Task deleted successfully');
    }
}

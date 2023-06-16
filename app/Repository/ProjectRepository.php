<?php

namespace App\Repository;

use App\Models\Project;
use App\Repository\Contract\ProjectRepositoryInterface;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function __construct(public Project $project)
    {
    }

    public function store(array $data)
    {
        return $this->project->firstOrCreate($data, $data);
    }

    public function findOne(int $id)
    {
        return $this->project->findOrFail($id);
    }

    public function findAll(array $params = [])
    {
        if(!isset($params['limit'])) {
            return $this->project->cursor();
        }
        return $this->project->paginate($params['limit'] ?? 10);
    }

    public function delete(int $id)
    {
        return $this->project->findOrFail($id)->delete();
    }

    public function update(int $id, array $data)
    {
        $project = $this->project->findOrFail($id);
        return $project->update($data);
    }
}

<?php

namespace App\Repository;

use App\Models\Task;
use App\Repository\Contract\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface
{
    public function __construct(public Task $task)
    {
    }

    /**
     * @throws \Throwable
     */
    public function store(array $data)
    {
        $find = $this->task->available($data);
        throw_if($find->count() > 0, 'Task name or priority already assigned.');

        return $this->task->create($data);
    }

    public function findOne(int $id)
    {
        return $this->task->findOrFail($id);
    }

    public function findAll(array $params)
    {
        $query = $this->task;
        if(isset($params['project'])) {
            $query = $query->where('project_id', $params['project']);
        }
        return $query->orderBy('priority')->paginate($params['limit'] ?? 10);
    }

    public function delete(int $id)
    {
        return $this->task->findOrFail($id)->delete();
    }

    public function update(int $id, array $data)
    {
        return $this->task->findOrFail($id)
            ->update($data);
    }
}

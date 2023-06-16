<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'name',
        'priority',
        'project_id',
    ];

    public function scopeAvailable($query, $data)
    {
        return $query->where(function ($query) use ($data) {
            $query->where([
                ['name', '=', $data['name']],
                ['project_id', '=', $data['project_id']],
            ])->orWhere(function ($query) use ($data) {
                $query->where([
                    ['priority', '=', $data['priority']],
                    ['project_id', '=', $data['project_id']],
                ]);
            });
        });
    }
}

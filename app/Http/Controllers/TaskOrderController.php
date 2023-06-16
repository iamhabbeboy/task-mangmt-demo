<?php

namespace App\Http\Controllers;

use App\Repository\Contract\TaskRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TaskOrderController extends Controller
{
    public function __construct(public TaskRepositoryInterface $taskRepository)
    {
    }

    public function __invoke(Request $request)
    {
        $request->validate([
            'order' => 'required|array'
        ]);
        foreach($request->order as $key => $order) {
            $exp = explode("-", $order);
            if(!isset($exp[2])) {
                continue;
            }
            $id = $exp[2];
            $this->taskRepository->update($id, ['priority' => $key+1]);
        }
        return response()->json(['status' => 'success', 'data' => $request->order], ResponseAlias::HTTP_OK);
    }
}

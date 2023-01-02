<?php

namespace App\Http\Controllers\Counter;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QueueController extends Controller
{
    public function getAll(Request $request)
    {
        $query = Queue::query();

        if ($search = $request->input('search')) {
            $query->where('note', 'LIKE', '%' . $search . '%');
        }

        if ($sort = $request->input('sort')) {
            $query->orderBy('created_at', $sort);
        }

        $perPage = $request->input('perPage', 10);
        $currentPage = $request->input('currentPage', 1);
        $total = $query->count();

        $result = $query->offset(($currentPage - 1) * $perPage)->limit($perPage)->get();

        return response()->json([
            'message' => 'Success Get All!',
            'totalData' => $total,
            'perPage' => $perPage,
            'currentPage' => $currentPage,
            'last_page' => ceil($total / $perPage),
            'data' => $result,
        ]);
    }

    public function getOne($id)
    {
        $queue = Queue::find($id);
        return response()->json($queue);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'counters_id' => 'required',
            'note' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => "Input Error"]);
        }

        $request['status_queues_id'] = 1;

        $input = $request->all();
        $data = Queue::create($input);
        return response()->json([
            'message' => 'Success Created !',
            'data' => $data,
        ]);
    }

    public function update(Request $request, Queue $queue)
    {
        $validator = Validator::make($request->all(), [
            'counters_id' => 'required',
            'note' => 'required',
            'status_queues_id' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => "Input Error"]);
        }

        $input = $request->all();

        $queue->update($input);

        $data = Queue::find($queue->id);

        return response()->json([
            'message' => 'Success updated !',
            'data' => $data,
        ]);
    }

    public function delete($id)
    {
        $data  = Queue::find($id);

        $data->delete();

        return response()->json([
            'message' => 'Delete Successfuly !',
        ]);
    }

    public function getAllByCounter(Request $request, $id)
    {
        $query = Queue::query()->where('counters_id', $id);

        if ($search = $request->input('search')) {
            $query->where('note', 'LIKE', '%' . $search . '%');
        }

        if ($sort = $request->input('sort')) {
            $query->orderBy('created_at', $sort);
        }

        $perPage = $request->input('perPage', 10);
        $currentPage = $request->input('currentPage', 1);
        $total = $query->count();

        $result = $query->offset(($currentPage - 1) * $perPage)->limit($perPage)->get();

        return response()->json([
            'message' => 'Success Get All Counter !',
            'totalData' => $total,
            'perPage' => $perPage,
            'currentPage' => $currentPage,
            'last_page' => ceil($total / $perPage),
            'data' => $result,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Counter;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use App\Models\UserCounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CounterController extends Controller
{
    public function getAll(Request $request)
    {
        $query = Counter::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('purpose', 'LIKE', '%' . $search . '%');
        }

        if ($sort = $request->input('sort')) {
            $query->orderBy('created_at', $sort);
        }

        if ($status = $request->input('status')) {
            $query->where('status_counters_id', $status);
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

    public function getOne($id)
    {
        $counter = Counter::find($id);
        return response()->json($counter);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'purpose' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => "Input Error"]);
        }

        $request['status_counters_id'] = 1;

        $input = $request->all();
        $data = Counter::create($input);
        return response()->json([
            'message' => 'Success Created !',
            'data' => $data,
        ]);
    }

    public function update(Request $request, Counter $counter)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'purpose' => 'required',
            'status_counters_id' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => "Input Error"]);
        }

        $input = $request->all();

        $counter->update($input);

        $data = Counter::find($counter->id);

        return response()->json([
            'message' => 'Success updated !',
            'data' => $data,
        ]);
    }

    public function delete($id)
    {
        $data  = Counter::find($id);

        $data->delete();

        return response()->json([
            'message' => 'Delete Successfuly !',
        ]);
    }

    public function assigUser(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => "Input Error"]);
        }

        $request['counter_id'] = $id;

        $input = $request->all();
        $data = UserCounter::create($input);
        return response()->json([
            'message' => 'Success Assign user to this counter!',
            'data' => $data,
        ]);
    }

    public function unAssigUser($id)
    {
        $data  = UserCounter::where('user_id', $id);

        $data->delete();

        return response()->json([
            'message' => 'Unassign user Successfuly !',
        ]);
    }
}

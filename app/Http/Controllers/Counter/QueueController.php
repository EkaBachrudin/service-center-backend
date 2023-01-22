<?php

namespace App\Http\Controllers\Counter;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use Carbon\Carbon;
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

        if ($status = $request->input('status')) {
            $query->where('status_queues_id', $status);
        }

        if ($dateRange = $request->input('dateRange')) {
            $from = Carbon::createFromFormat('Y-m-d', '2021-06-01');
            $to = Carbon::createFromFormat('Y-m-d', '2023-01-05');
            $query->whereBetween('created_at', [$from, $to]);
        }

        $perPage = $request->input('perPage', 10);
        $currentPage = $request->input('currentPage', 1);
        $total = $query->count();

        $result = $query->offset(($currentPage - 1) * $perPage)->limit($perPage)->get();

        return response()->json([
            'message' => 'Success Get All Queue By Counter !',
            'totalData' => $total,
            'perPage' => $perPage,
            'currentPage' => $currentPage,
            'last_page' => ceil($total / $perPage),
            'data' => $result,
        ]);
    }

    public function control(Request $request, Queue $queue)
    {
        $counter_id = $request->counters_id;

        // $data = Queue::where("counters_id", $counter_id)->where("status_queues_id", 1)->first();

        // dd(json_encode($data));

        if (!$request->input('status_queues_id')) {
            $input = $request['status_queues_id'] = 1;
        }

        $input = $request->all();

        $queue->update($input);

        $data = Queue::find($queue->id);

        //If Change to Witing (Previouse)
        if ($request['status_queues_id'] == 1) {
            $previousDataOccure = Queue::where("counters_id", $counter_id)->where("status_queues_id", 3)->orwhere("status_queues_id", 4)->orderBy('created_at', 'desc')->first();

            if ($previousDataOccure) {
                $request['status_queues_id'] = 2;

                $input = $request->all();

                $previousDataOccure->update($input);
            }
        }

        //If Change to done (Next)
        if ($request['status_queues_id'] == 3) {
            $nextDataOccure = Queue::where("counters_id", $counter_id)->where("status_queues_id", 1)->first();

            if ($nextDataOccure) {
                $nextDataOccure->status_queues_id = 2;
                $nextDataOccure->save();
            }
        }

        //If Change to Skip (Skip)
        if ($request['status_queues_id'] == 4) {
            $skipDataOccure = Queue::where("counters_id", $counter_id)->where("status_queues_id", 1)->first();

            if ($skipDataOccure) {
                $request['status_queues_id'] = 2;

                $input = $request->all();

                $skipDataOccure->update($input);
            }
        }


        return response()->json([
            'message' => 'Change To ' . $data->status->name . ' Success !',
            'data' => $data,
        ]);
    }

    public function getTodayData($id)
    {
        $query = Queue::query()->where('counters_id', $id);

        $result = $query->whereDate('created_at', Carbon::today())->get();

        return response()->json([
            'message' => 'Success Get All Queue By  Today !',
            'data' => $result,
        ]);
    }

    public function getOccureStatus($id)
    {
        $query = Queue::query()->where('counters_id', $id)
            ->where('status_queues_id', 2)
            ->whereDate('created_at', Carbon::today())
            ->first();

        if (!$query) {
            return $this->getWittingStatus($id);
        }

        return response()->json([
            'message' => 'Success Get Queue with OCCURE status Today !',
            'data' => $query,
        ]);
    }

    private function getWittingStatus($id)
    {
        $query = Queue::query()->where('counters_id', $id)
            ->where('status_queues_id', 1)
            ->whereDate('created_at', Carbon::today())
            ->first();

        if (!$query) {
            return response()->json([
                'message' => 'There is no more data for today with WITING status !',
                'data' => null,
            ]);
        }

        $query->status_queues_id = 2;
        $query->save();

        return response()->json([
            'message' => 'Success Get firts queue witing status Oldest Today !',
            'data' => $query,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Transport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\TransportRegistration;

class TransportRegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_if(Gate::denies('TransportRegistration'), redirect('error'));
        $regTrans = TransportRegistration::orderBy('created_at', 'desc')->get();
        $transport_info = Transport::pluck('title','id');
        $active_tranReg = $regTrans->filter(function($regTr){
            return $regTr->status == 'active';
        });
        $inActive_tranReg = $regTrans->filter(function($regTr){
            return $regTr->status == 'inactive';
        });
        return view('transport_registration.index', compact('active_tranReg','inActive_tranReg','transport_info'));
    }

    public function create(){
        abort_if(Gate::denies('TransportRegistration'), redirect('error'));
        $transport_info = Transport::pluck('title','id');
        return view('transport_registration.create',compact('transport_info'));
    }

    public function store(Request $request){
        $request->validate([
            'user_id.*' => 'required',
            'transport_id.*' => 'required|exists:transports,id',
        ]);

        $user_ids = $request->input('user_id');
        $transport_ids = $request->input('transport_id');

        foreach ($user_ids as $index => $user_id) {
            $existingRegistration = TransportRegistration::where('user_id', $user_id)
                ->where('status', 'active')
                ->first();

            if ($existingRegistration) {
                continue;
            }

            TransportRegistration::create([
                'user_id' => $user_id,
                'transport_id' => $transport_ids[$index],
                'status' => 'active',
            ]);
        }

        \Session::flash('flash_message', 'Successfully Added');
        return redirect('transport-registration');
    }

    public function auto_student_transport()
    {
        if (!empty($_POST['type'])) {
            $type = $_POST['type'];
            $name = $_POST['name_startsWith'];

            // Subqueries for each group
            $students = DB::table('students')
                ->select('first_name', 'middle_name', 'last_name', 'user_id', 'id');

            // Use the union as a subquery
            $result = DB::query()
                ->fromSub($students, 'people')   // alias for the union result
                ->join('users', 'users.id', '=', 'people.user_id')
                ->select('people.first_name', 'people.middle_name', 'people.last_name', 'people.user_id', 'people.id', 'users.personnel_id')
                ->where($type, 'like', "%" . strtoupper($name) . "%")
                ->get();

            $data = [];
            foreach ($result as $value) {
                $name = $value->first_name. '|' . $value->middle_name. '|' . $value->last_name. '|' . $value->personnel_id. '|' . $value->id. '|' . $value->user_id;
                $data[] = $name;
            }

            echo json_encode($data);
            exit;

        }
    }

    public function edit($id){
        abort_if(Gate::denies('TransportRegistration'), redirect('error'));
        $trData = TransportRegistration::findOrFail($id);
        $data = [
            'personnel_id' => $trData->user->personnel_id,
            'first_name' => $trData->user->student->first_name,
            'middle_name' => $trData->user->student->middle_name,
            'last_name' => $trData->user->student->last_name,
            'user_id' => $trData->user_id,
            'transport_id' => $trData->transport_id,
            'status' => $trData->status,
            'id' => $trData->id,
        ];
        return json_encode($data);
    }

    public function update(Request $request, $id){
        $trData = TransportRegistration::findOrFail($id);
        $trData->update($request->all());

        \Session::flash('flash_message', 'Successfully Updated');
        return redirect('transport-registration');
    }

    public function destroy($id){
        $data = TransportRegistration::findOrFail($id);
        $data->delete();
        \Session::flash('flash_message', 'Successfully Deleted');
        return redirect('transport-registration');
    }
}

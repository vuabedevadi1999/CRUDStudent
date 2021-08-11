<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['students'=>Student::all()],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Trường tên không được để trống',
            'email.required' => 'Trường email không được để trống',
            'email.unique' => 'Email này đã có người sử dụng',
            'email.email' => 'Đại chỉ email không hợp lệ',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.max' => 'Số điện thoại phải bao gồm 10 số',
            'phone.min' => 'Số điện thoại phải bao gồm 10 số',
            'phone.regex' => 'Số điện thoại phải bao gồm 10 chữ số và bắt đầu bằng số 0',
        ];
        $validator = Validator::make($request->only(['name','email','phone']),[
            'name'=> 'required',
            'email' => 'required|unique:students|email',
            'phone' => 'required|max:10|min:10|regex:/(0)[0-9]{9}/',
        ], $messages);
        if($validator->fails()){
            return response()->json([
                'errors'=>$validator->errors(),
                'inputData'=>$request->only(['name','email','phone'])
            ],422);
        }
        Student::create($request->only(['name','email','phone']));
        return response()->json(['success'=> 'Them sinh vien thanh cong']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        $student = Student::find($student->id);
        return response()->json(['student'=>$student],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $messages = [
            'name.required' => 'Trường tên không được để trống',
            'email.required' => 'Trường email không được để trống',
            'email.unique' => 'Email này đã có người sử dụng',
            'email.email' => 'Đại chỉ email không hợp lệ',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.max' => 'Số điện thoại phải bao gồm 10 số',
            'phone.min' => 'Số điện thoại phải bao gồm 10 số',
            'phone.regex' => 'Số điện thoại phải bao gồm 10 chữ số và bắt đầu bằng số 0',
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:students,email,'.$student->id,
            'phone' => 'required|max:10|min:10|regex:/(0)[0-9]{9}/',
        ],$messages);

        if ($validator->fails()) {
            return response()->json([
                'errors'=> $validator->errors(),
                'inputData'=>$request->only(['name','email','phone'],422)
            ]);
        }
        $student->update($request->only(['name','email','phone']));
        return response()->json(['success'=> 'Cập sinh vien thanh cong']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json(['success'=>'Xóa thành công sinh viên có id là '.$student->id]);
    }
}

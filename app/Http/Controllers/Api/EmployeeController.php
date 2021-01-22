<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Employee;
use Illuminate\Http\Request;
use Image;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Employee::orderBy('created_at','desc')->get();
        return response()->json($employee);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // return response()->json($request->all());

      $position = strpos($request->photo,';');
      $sub = substr($request->photo,0,$position);
      $ext = explode('/',$sub)[1];

      $name = time().".".$ext;
      $img = Image::make($request->photo)->resize(240,200);
      $upload_path = 'images/employee/';
      $image_url= $upload_path.$name;
      $img->save($image_url);

        $inputData = [
            'name' => $request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'dob'=>$request->dob,
            'photo'=>$image_url,
        ];
        //return response()->json($inputData);
        Employee::create($inputData);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::where('id',$id)->first();
     return response()->json($employee);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $data = array();
        $data['name']= $request->name;
        $data['email']= $request->email;
        $data['phone']= $request->phone;
        $data['dob']= $request->dob;
        $image = $request->newphoto;

        if($image){
            $position = strpos($image,';');
            $sub = substr($image,0,$position);
            $ext = explode('/',$sub)[1];

            $name = time().".".$ext;
            $img = Image::make($image)->resize(240,200);
            $upload_path = 'images/employee/';
            $image_url= $upload_path.$name;
           $success =  $img->save($image_url);


           if($success){
               $data['photo'] = $image_url;
               $dataImage = Employee::where('id',$id)->first();
               $path = $dataImage->photo;
               $done = unlink($path);
               $user = Employee::where('id',$id)->update($data);
               return response()->json($user);

           }
           else{
               $old_photo = $request->photo;
               $data['photo'] = $old_photo;
               $user = Employee::where('id',$id)->update($data);
               return response()->json($user);

           }
        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::where('id',$id)->first();
        $photo = $employee->photo;
        if($photo){
            unlink($photo);
            Employee::where('id',$id)->delete();
        }else{
            Employee::where('id',$id)->delete();
        }
    }
}

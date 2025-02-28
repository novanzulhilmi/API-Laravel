<?php

namespace App\Http\Controllers;

use App\Models\Students;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $students = Students::all();
      
            return response()->json([
              'status' => 'success',
              'message' => 'Get all students success',
              'data' => $students,
            ]);
          } catch (\Exception $e) {
            return response()->json([
              'status' => 'error',
              'message' => 'Get all students failed',
              'error' => $e->getMessage(),
            ]);
          }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string',
            'address'       => 'required|string',
            'class'         => 'required|integer',
            'phone'         => 'required|integer'
        ]);

        $students = new Students([
            'name'          => $request->name,
            'address'       => $request->address,
            'class'         => $request->class,
            'phone'         => $request->phone
        ]);
        $students->save();

        if($students) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data added succesfully',
                'data' => $students
            ]);
        } else {
            return Response ()->json([
                'status' => 'error',
                'message' => 'Error adding data',
                'data' => $students
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $students = Students::find($id);

        // Jika data siswa tidak ditemukan
        if (!$students) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $students -> update([
            'name'          => $request->name,
            'address'       => $request->address,
            'class'         => $request->class,
            'phone'         => $request->phone
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data updated succesfully',
            'data' => $students
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $students = Students::find($id);

        // Jika data siswa tidak ditemukan
        if (!$students) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $students->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data deleted succesfully',
            'data' => $students
        ]);
    }
}

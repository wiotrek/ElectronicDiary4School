<?php

namespace App\Http\Controllers;

use App\Models\StudentActivity;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StudentController extends Controller
{
    public function storeStudentActivity (Request $request) {

        foreach($request->all() as $req) {

            $saveActive = new StudentActivity(
                [
                    'student_id' => $req['student_id'],
                    'subject_id' => $req['subject_id'],
                    'active' => $req['active'],
                    'date_active' => $req['date_active'],
                ]
            );

            if(!$saveActive -> save()){
                response([
                    'message' => 'Unsuccessfuly saved student activity with id '.$req['student_id'],
                    Response::HTTP_BAD_REQUEST]
                );
            }
        }


        return response([
            'message' => 'Student activities inserted'
        ] );
    }
}

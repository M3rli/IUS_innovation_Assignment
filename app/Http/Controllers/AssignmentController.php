<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Assignment;
use App\Owner;
use DB;






class AssignmentController extends Controller
{

    function __construct()
    {
        $this->AM = new Assignment;
        $this->OM = new Owner;

    }


    public function index()
    {   
        /*Look if we got a connection to the database*/
        if (DB::connection()->getPdo()) {

            /*Try our model function*/
            try {
                $all_ass_own = Assignment::all()->owners;
            } catch (\Exception $e) {
                return 'Something wrong with the connection.';
            }

            /*Get all assignments and owners with the values that we want.
            After that decode it to json then return it.*/
            // $all_ass_own = $this->AM->getAllAO();

            // $all_ass_own_json = $all_ass_own->toJson();

            return $all_ass_own_json;
        }else{
            return 'Something wrong with the connection.';
        }

    
    }
   


    /*We are going to post the data into database 
      after the POST method on URI assignments*/
    public function store(Request $request)
    {

        /*See if we even have $request*/
        if (!isset($request)) {
            return "There is no object.";
        }if (!isset($request->owner_id)) {
            return "Did not found a owner.";
        }if (!isset($request->device_type)) {
            return "Did not found any device.";
        }if (!isset($request->log)) {
            return "Did not found any log.";
        }if (!isset($request->resolved)) {
            return "Did not if the device are resolved.";
        }else{

            /*Test if we can post it to the model*/
            try {
                $assignment = $this->AM->postAssignment($request);
                
            } catch (\Exception $e) {
                return 'Something wrong with the connection.';
            }
            if($assignment){
                return 'Assignment created' . $request;
            }
        }





    }

    public function show($id)
    {
        try {
            $assignment = Assignment::find($id);
            $owner = Assignment::find($id)->owner;
        } catch (\Exception $e) {
            return 'Something wrong with the connection.';
        }
        if (!isset($assignment)) {
            return 'There is no assignment object to get from database.';
        }if (!isset($owner)) {
            return 'There is no owner object to get from database.';
        }else{

            $assignment_json = $assignment->toJson();
            $owner_json = $owner->toJson();

            return $assignment_json . $owner_json;
        } 

    }

    /*We are going to update the data in the database table assignments
      after the PUT method on URI assignments/id.*/
    public function update(Request $request, $id)
    {

        if (!isset($request)) {
            return 'Something went wrong.';
        }
        /*Try our model function*/
        try {
            $this->AM->updateAssignment($request,$id);
            return redirect('assignment/'.$id);

        } catch (Exception $e) {
            return 'Something wrong with the connection.';
        }
        return;

    }

    public function destroy($id)
    {

        try{
            $this->AM->destroy($id);
        }catch (Exception $e){
            return 'Something went wrong.';
        }

        return "Assignment deleted.";
    }
}

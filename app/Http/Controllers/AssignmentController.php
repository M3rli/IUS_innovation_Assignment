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
                $this->AM->getAllAO();
            } catch (\Exception $e) {
                return 'Something wrong with the connection.';
            }

            /*Get all assignments and owners with the values that we want.
            After that decode it to json then return it.*/
            $all_ass_own = $this->AM->getAllAO();

            $all_ass_own_json = $all_ass_own->toJson();

            return $all_ass_own_json;
        }else{
            return 'Something wrong with the connection.';
        }

    
    }

    public function create()
    {
        /*Get all the owners for the assignment creation*/
        try {
            $all_owners = $this->OM->getAllOwners();
        } catch (\Exception $e) {
            return 'Something wrong with the connection.';
        }

        $all_owns_json = $all_owners->toJson();

        /*We don't have a form with a post method. 
          So we have almost the store function here aswell.*/

        // $o_count = count($all_owners);
        // $request = (object) array('owner_id' => rand(0,$o_count), 'device_type'=>'iphone','log'=>'något','resolved'=>0);
        // try {
        //     $this->AM->postAssignment($request);
        // } catch (\Exception $e) {
        //     return 'Something wrong with the connection.';
        // }


        return $all_owners;
    }   


    /*We are going to post the data into database 
      after the POST method on URI assignments*/
    public function store(Request $request)
    {

        $request = (object) array('owner_id' => '1', 'device_type'=>'iphone','log'=>'något','resolved'=>0);

        /*See if we even have $request*/
        if (!isset($request)) {
            return "Something went wrong.";
        }if (!isset($request->owner_id)) {
            return "Something went wrong.";
        }if (!isset($request->device_type)) {
            return "Something went wrong.";
        }if (!isset($request->log)) {
            return "Something went wrong.";
        }if (!isset($request->resolved)) {
            return "Something went wrong.";
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
            $assignment = $this->AM->getSpecAssOwn($id);
        } catch (\Exception $e) {
            return 'Something wrong with the connection.';
        }
        if (!isset($assignment)) {
            return 'Something wrong with the connection.';
        }else{
            $assignment_json = $assignment->toJson();

            return $assignment_json;
        }

    }

    public function edit($id)
    {

        if (DB::connection()->getPdo()) {

            
            /*getSpecAssOwn will get specific assignment and join owner with it.*/
            try {
                $assignment_owner = $this->AM->getSpecAssOwn($id);
            } catch (\Exception $e) {
                return 'Something wrong with the connection.';
            }

            if (!isset($assignment_owner)) {
                return 'Something wrong with the connection.';
            }else{
                $assignment_owner_json = $assignment_owner->toJson();

                /*No put method, uncomment to test*/
                /*This is our request from our "view".
                  This update will change the owner_id*/

                // $request = array('owner_id' => 4);
                // $this->AM->updateAssignment($request,$id);
                // return redirect('assignments/'.$id);
                return $assignment_owner_json;
            }
        }else{
            return 'Something wrong with the connection.';
        }


    }

    /*We are going to update the data in the database table assignments
      after the PUT method on URI assignments/id.*/
    public function update(Request $request, $id)
    {
        /*This is our request from our "view"*/
        $request = array('owner_id' => 4);


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

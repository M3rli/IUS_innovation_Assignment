<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Owner;
use DB;


class OwnerController extends Controller
{

    function __construct()
    {
        $this->OM = new Owner;
    }


    public function index()
    {
        /*Look if we got a connection to the database*/
        if (DB::connection()->getPdo()) {

            /*Try our model function*/
            try {
                $all_owners = $this->OM->All();
            } catch (\Exception $e) {
                return 'Something wrong with the connection.';
            }

            /*Get all owners.
            After that encode it to json then return it.*/

            $all_own_json = $all_owners->toJson();

            return $all_own_json;
        }else{
            return 'Something wrong with the connection.';
        }
    }

    public function create()
    {


        /*We don't have a form with a post method. 
          So we can uncomment down below if we want to test with new data.*/

        // $request = (object) array('first_name'=>'David','last_name'=>'Olsson');
        // try {
        //     $owner = $this->OM->postOwner($request);
        // } catch (\Exception $e) {
        //     return 'Something wrong with the connection.';
        // }

        return 'Creation view';

    }


    /*We are going to post the data into database 
      after the POST method on URI owners/*/
    public function store(Request $request)
    {
        $request = (object) array('first_name'=>'David','last_name'=>'Olsson');
        if (!isset($request)) {
            return 'Something went wrong';
        }if (!isset($request->first_name)) {
            return "Something went wrong.";
        }if (!isset($request->last_name)) {
            return "Something went wrong.";
        }

        /*Test if we can post it to the model*/
        try {
            $assignment = $this->AM->postOwner($request);
            
        } catch (\Exception $e) {
            return 'Something wrong with the connection.';
        }
        if($assignment){
            return 'Assignment created' . $request;
        }
    }


    public function show($id)
    {

        /*Get all the specific owner*/
        try {
            $owner = $this->OM->getSpecOwner($id);
        } catch (\Exception $e) {
            return 'Something wrong with the connection.';
        }
        if (!isset($owner)) {
            return 'Something wrong with the connection.';
        }else{
            $owner_json = $owner->toJson();

            return $owner_json;
        }



    }

    public function edit($id)
    {
  if (DB::connection()->getPdo()) {

            /*Try our model function*/
            /*getSpecAssOwn will get specific assignment and join owner with it.*/
            try {
                $assignment_owner = $this->AM->getSpecOwner($id);
            } catch (\Exception $e) {
                return 'Something wrong with the connection.';
            }

            if (!isset($assignment_owner)) {
                return 'Something wrong with the connection.';
            }else{
                $assignment_owner_json = $assignment_owner->toJson();

                /*This is our request from our "view".
                  This update will change first_name in the table*/

                // $request = array('first_name' => 'Divad');
                // $this->OM->updateOwner($request,$id);
                // return redirect('assignments/'.$id);

                return $assignment_owner_json;
            }
        }else{
            return 'Something wrong with the connection.';
        }
    }

    public function update(Request $request, $id)
    {
        $request = array('first_name' => 'Divad');
        if (!isset($request)) {
            return 'Something went wrong';
        }
        try{
          $this->OM->updateOwner($request,$id);  
        }catch(Exception $e){
            return 'Something wrong with the connection.';
        }

        /*Lets return to the view we changed*/
        return redirect('assignments/'.$id);

    }


    public function destroy($id)
    {

        try{
            $this->OM->destroy($id);
        }catch (Exception $e){
            return 'Something went wrong.';
        }

        return "Assignment deleted.";

    }
}

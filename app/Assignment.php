<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{


	/* This function will connect owner with assignment thru owner_id. */
    public function owner()
    {
        return $this->belongsTo('App\Owner');
    }



    /*Get all the assignments and owners values*/
    public function getAllAO()
    {

        return $all_assignments = $this->join('owners', 'owners.id', '=', 'assignments.owner_id')
                                            ->select('assignments.id','owners.first_name','owners.last_name',
                                                'assignments.device_type', 'assignments.log', 'assignments.resolved', 'assignments.created_at')->get();


    }

	/*Get assignment and join owner.*/
    public function getSpecAssOwn($id)
    {
        return $assignment_owner = $this->join('owners', 'owners.id', '=', 'assignments.owner_id')
        									->where('assignments.id',$id)
                                            ->select('assignments.id','assignments.owner_id','owners.first_name','owners.last_name',
                                                'assignments.device_type', 'assignments.log', 'assignments.resolved', 'assignments.created_at')
                                            ->get();


    }


    public function updateAssignment($object, $id)
    {
    	return $this->where('id', $id)->update($object);

    }


    public function postAssignment($object)
    {

        return $this->insert(['owner_id' => $object->owner_id,
                                            'device_type' => $object->device_type,
                                            'log'=> $object->log,
                                            'resolved'=>$object->resolved,
                                            'created_at' => date("Y-m-d H:i:s"),
                                            'updated_at' => date("Y-m-d H:i:s")]);


    }


}

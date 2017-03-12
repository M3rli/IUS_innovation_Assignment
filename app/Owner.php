<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{




	public function getAllOwners()
	{
		return $this->select('id', 'first_name', 'last_name')->get();


	}

	public function getSpecOwner($id)
	{
		return $this->select('id', 'first_name', 'last_name','created_at')->where('id', $id)->get();
	}


	public function postOwner($object)
	{

        return $this->insert(['first_name' => $object->first_name,
                                            'last_name' => $object->last_name,
                                            'created_at' => date("Y-m-d H:i:s"),
                                            'updated_at' => date("Y-m-d H:i:s")]);


	}


    public function updateOwner($object, $id)
    {
    	return $this->where('id', $id)->update($array);

    }

}

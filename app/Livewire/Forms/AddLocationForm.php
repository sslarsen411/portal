<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class AddLocationForm extends Form{
    public $biz;
    public $addr;
    public $city;
    public $state;
    public $zip;
    public $loc_phone;
     public $PID;
     public $CID;
    // public $type;
     public $ttl;
     public $rate;

     public function rules(){
        return [
           'loc_phone' => 'required|phone:US|min:9',
           'CID' => 'min:18',
           'PID' => 'min:27',
        ];         
    }
    public function messages(){
       return [
           'CID.min' => 'CID must be :min+ digits',
           'PID.min' => 'PID must be :min+ characters',
           'loc_phone.required' => 'A valid phone is required',
           'phone' => 'Enter a valid phone number',        
       ];
   }
     
}
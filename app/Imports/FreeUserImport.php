<?php

namespace App\Imports;

use App\Models\FreeUser;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Log;

class FreeUserImport implements ToModel
{
    protected $subject_id;
    protected $course_id;
    protected $lecture_id;
    protected $admin_id;

    public function __construct($subject_id, $course_id, $lecture_id, $admin_id)
    {
        $this->subject_id   = $subject_id;
        $this->course_id    = $course_id;
        $this->lecture_id   = $lecture_id;
        $this->admin_id     = $admin_id;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (isset($row[0]) && isset($row[1]))
        {
            return new FreeUser([
                'subject_id'    => $this->subject_id, 
                'course_id'     => $this->course_id, 
                'lecture_id'    => $this->lecture_id, 
                'admin_id'      => $this->admin_id,
                'phone_prefix'  => $row[0], 
                'phone'         => $row[1], 
            ]);
        }
        
        return null;
    }
}

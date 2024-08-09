<?php

namespace App\Exports;

use App\Models\FreeUser;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Auth;

class FreeUserExport implements FromCollection
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
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Customize the query to get the data you need
        if( Auth::guard('admin')->user()->role == "Teacher" ) 
        {
            return FreeUser::select("phone_prefix", "phone")
                ->where('subject_id', $this->subject_id)
                ->where('course_id', $this->course_id)
                ->where('lecture_id', $this->lecture_id)
                ->where('admin_id', $this->admin_id)
                ->get();
        } else {
            return FreeUser::select("phone_prefix", "phone")
                ->where('subject_id', $this->subject_id)
                ->where('course_id', $this->course_id)
                ->where('lecture_id', $this->lecture_id)
                ->get();
        }
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // Customize the column headings
        return [
            'phone_prefix', 
            'phone', 
        ];
    }

    /**
     * @param mixed $user
     * @return array
     */
    public function map($user): array
    {
        // Customize the columns and the data format
        return [
            $user->phone_prefix,
            $user->phone,
        ];
    }
}

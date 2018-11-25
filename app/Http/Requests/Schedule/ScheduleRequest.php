<?php

namespace App\Http\Requests\Schedule;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'schedulerName'=>'required|max:10',
            'schedulerStartDate'=>'required',
            'schedulerStartTime'=>'required',
            'schedulerEndDate'=>'required',
            'schedulerEndTime'=>'required',
            'schedulerDescription'=>'required|max:50',
        ];
    }
}

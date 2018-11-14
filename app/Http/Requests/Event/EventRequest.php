<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'eventImage'=>'required',
            'eventType'=>'required|max:50',
            'eventName'=>'required|max:80',
            'eventPlace'=>'required|max:50',
            'eventStartDate'=>'required|max:50',
            'eventStartTime'=>'required|max:50',
            'eventEndDate'=>'required|max:50',
            'eventEndTime'=>'required|max:50',
            'eventDescription'=>'required|max:250'

        ];
    }
}

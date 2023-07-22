<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateObjectRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_id' => 'required|integer',
            'name' => 'required|string|min:2|max:255',
            'country' => 'required|string|min:2|max:255',
            'city' => 'required|string|min:2|max:255',
            'street' => 'required|string|min:2|max:255',
            'house' => 'required|string|min:2|max:255',
            'contract_number' => 'nullable|string',
            'contract_date_start' => 'nullable|date',
            'contract_date_end' => 'nullable|date',
            'type_installation' => 'required|string|min:2|max:255',
            'name_organization_do_project' => 'nullable|string|min:2|max:255',
            'project_release_date' => 'nullable|date',
            'organization_name_mounting' => 'nullable|string|min:2|max:255',
            'date_delivery_object' => 'nullable|date',
            'services_schedule' => 'required|string|min:1|max:1',
            'description_object' => 'required|string|min:2|max:4294967295',
            'scheme' => 'nullable|string|min:2|max:255',
            'loop_lists' => 'nullable|string|min:2|max:255',
            'photos' => 'nullable|string|min:2|max:255',
        ];
    }
}

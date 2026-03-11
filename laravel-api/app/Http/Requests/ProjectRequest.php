<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->get('id') ?? $this->route('id');

        return [
            'title' => 'required|min:2|max:255',
            'slug' => [
                'required',
                'min:2',
                'max:255',
                \Illuminate\Validation\Rule::unique('projects', 'slug')->ignore($id),
            ],
            'repo_url' => 'nullable|url',
            'live_url' => 'nullable|url',
            'metrics' => 'nullable|json',
            'cover_image' => 'nullable|string',
            
            // Core publish logic: if marked as published, core content is strictly required
            'excerpt' => 'required_if:is_published,1',
            'description' => 'required_if:is_published,1',
            
            // Case study translatable fields don't need strict type checks here 
            // since backpack handles the json/array encoding, but they are available.
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}

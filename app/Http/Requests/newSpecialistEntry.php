<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class newSpecialistEntry
 * @package App\Http\Requests
 */
class newSpecialistEntry extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasAccess('admin.specialists.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'adverb' => 'required',
            'sur_name' => 'required',
            'gender' => 'required',
            'occupation' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'region' => 'required',
            'country' => 'required',
            'phone_number' => 'required',
            'mobile_number' => 'nullable',
            'is_anonymous' => 'boolean',
            'url_name' => 'required_if:is_anonymous,1|unique:specialists',
            'profile_image_filename' => 'required_with:profile_image_cropped',
            'story' => 'required_if:is_anonymous,1',
            'url' => 'nullable',
            'email' => 'nullable|required_if:is_anonymous,1|email',
            'images.*.caption' => 'required_with:images.*.file',
            'images.*.file' => 'nullable|file|max:10000|image',
            'diverses.*.name' => 'required_with:diverses.*.target',
            'diverses.*.target' => 'nullable|file|max:10000|mimes:docx,doc,pdf,jpeg,jpg,png,svg,gif,txt,rtf',
            'specialisms.*.name' => 'sometimes|nullable|distinct|exists:specialisms',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'required' => 'U moet een  :attribute invullen',
            'unique' => 'De :attribute, :input komt al voor in ons systeem, gelieve een andere te kiezen',
            'required_if' => 'Voor betaalde specialisten dient u een  :attribute in te vullen',
            'url.regex' => ':input is geen geldige url, voer een url in het formaat: www.example.com in',
            'email' => ':input is geen geldig email adres voer een email adres in het formaat: example@example.com',
            'file' => ':input is geen fgeldig bestand',
            'mimes' => ':input heeft geen geldig bestandstype, kies een geldig bestandstype'
        ];
    }
}

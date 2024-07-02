<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
                'description' => 'required|string',
                'rooms' => 'required|integer|min:1',
                'beds' => 'required|integer|min:1',
                'bathrooms' => 'required|integer|min:1',
                'square_meters' => 'required|integer|min:10',
                'image_cover' => 'required|image|max:2048',
                'streetName' => 'required|string|max:255',
                'houseNumber' => 'required|integer|min:1',
                'city' => 'required|string|max:255',
                'cap' => 'required|string|max:99999|min:00001',
                'services' => 'required|array|min:1', 
                'services.*' => 'integer|exists:services,id',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Il campo nome è obbligatorio.',
            'name.string' => 'Il campo nome deve essere una stringa.',
            'name.max' => 'Il campo nome non può superare i 255 caratteri.',
            
            'description.required' => 'Il campo descrizione è obbligatorio.',
            'description.string' => 'Il campo descrizione deve essere una stringa.',
            
            'rooms.required' => 'Il campo stanze è obbligatorio.',
            'rooms.integer' => 'Il campo stanze deve essere un numero intero.',
            'rooms.min' => 'Il campo stanze deve essere almeno 1.',
            
            'beds.required' => 'Il campo letti è obbligatorio.',
            'beds.integer' => 'Il campo letti deve essere un numero intero.',
            'beds.min' => 'Il campo letti deve essere almeno 1.',
            
            'bathrooms.required' => 'Il campo bagni è obbligatorio.',
            'bathrooms.integer' => 'Il campo bagni deve essere un numero intero.',
            'bathrooms.min' => 'Il campo bagni deve essere almeno 1.',
            
            'square_meters.required' => 'Il campo metri quadrati è obbligatorio.',
            'square_meters.integer' => 'Il campo metri quadrati deve essere un numero intero.',
            'square_meters.min' => 'Il campo metri quadrati deve essere almeno 10.',
            
            'streetName.required' => 'Il campo street name è obbligatorio.',
            'streetName.string' => 'Il campo indirizzo deve essere una stringa.',
            'streetName.max' => 'Il campo indirizzo non può superare i 255 caratteri.',

            'houseNumber.required' => 'Il campo house number è obbligatorio.',
            'houseNumber.integer' => 'Il campo metri quadrati deve essere un numero intero.',
            'houseNumber.min' => 'Il campo metri quadrati deve essere almeno 1.',

            'city.required' => 'Il campo city è obbligatorio.',
            'city.string' => 'Il campo indirizzo deve essere una stringa.',
            'city.max' => 'Il campo indirizzo non può superare i 255 caratteri.',

            'cap.required' => 'Il campo cap è obbligatorio.',
            'cap.integer' => 'Il campo metri quadrati deve essere un numero intero.',
            'cap.min' => 'Il campo cap deve avere 5 cifre.',
            'cap.max' => 'Il campo cap deve avere 5 cifre.',
            
            'visibility.required' => 'Il campo visibilità è obbligatorio.',
            'visibility.boolean' => 'Il campo visibilità deve essere vero o falso.',
            
            'image_cover.string' => 'Il campo immagine di copertina deve essere una stringa.',
            'image_cover.max' => 'Il campo immagine di copertina non può superare i 255 caratteri.',
            
            'services.required' => 'Please select at least one service.',
            'services.*.integer' => 'Each selected service must be valid.',
            'services.*.exists' => 'Each selected service must exist.',
        ];
        
    }
}

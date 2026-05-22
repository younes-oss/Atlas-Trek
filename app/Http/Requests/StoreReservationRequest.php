<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    /**
     * Seuls les voyageurs connectés peuvent réserver.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'voyageur';
    }

    public function rules(): array
    {
        return [
            'number_of_people' => 'required|integer|min:1|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'number_of_people.required' => 'Veuillez indiquer le nombre de personnes.',
            'number_of_people.min'      => 'Le nombre de personnes doit être au minimum 1.',
            'number_of_people.max'      => 'Le nombre de personnes ne peut pas dépasser 50.',
        ];
    }
}

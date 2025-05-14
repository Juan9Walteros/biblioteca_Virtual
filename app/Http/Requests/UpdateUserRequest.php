<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password as PasswordRules;
class UpdateUserRequest extends FormRequest
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
        $user_id = $this->route("usuario");

        return [
            "name" => ["required", "string"],
            "email" => [
                "required", 
                "email", 
                "unique:users,email," . $user_id // Excluir el correo del usuario actual
            ],
            "password" => [
                "required",
                "confirmed",
                PasswordRules::min(8)->letters()->symbols()->numbers()
            ],
            "id_rol" =>  ["required"], // Asegura que el "rol_id" exista en la tabla "roles"
            //
        ];
    }
}

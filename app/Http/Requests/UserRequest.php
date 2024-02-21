<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return TRUE;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules()
  {
    return [
      "role_id" => [
        "required", "exists:roles,id"
      ],
      "name" => [
        "required", "string"
      ],
      "email" => [
        "required", "email", \request()->method() == "POST" ? "unique:users,email" : Rule::unique("users", "email")->ignore(\request()->route("user")->id, "id")->whereNull("deleted_at")
      ],
      "username" => [
        "nullable", "string", request()->method() == "POST" ? "unique:users,username" : Rule::unique("users", "username")->ignore(\request()->route("user")->id, "id")->whereNull("deleted_at")
      ],
      "password" => [
        \request()->method() == "POST" ? "required" : "nullable", "string", "min:6"
      ]
    ];
  }
}

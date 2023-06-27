<?php


use Illuminate\Contracts\Validation\Validator;

trait FailedValidation
{
     public function failedValidation(Validator $validator)
     {
          response()->json([
               'status' => 422,
               'message' => $validator->errors()->first(),
               'error' => $validator->errors()
          ], 422)->send();
          exit();
     }
}
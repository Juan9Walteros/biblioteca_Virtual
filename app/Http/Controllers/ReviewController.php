<?php

namespace App\Http\Controllers;

use App\Helpers\AuthHelper;
use App\Http\Requests\CreateReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Review;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ReviewController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(): JsonResponse

    {

          try{  

            
            $review = Review::all();

            return response()->json([

              'reseña' => $review,
 
            ]);
            
          }catch(Exception $e){

            return response()->json([

              'error' =>'error al obtener reseña' . $e->getMessage()

            ],500);

        }   

}

    public function show($id): JsonResponse

    {

        try {
            // Buscar el usuario por su ID

            $review = Review::findOrFail($id);
 
            // Devolver el usuario encontrado en formato JSON

            return response()->json([

                'reseña' => $review

            ]);

        } catch (ModelNotFoundException $e) {

            // Manejar la excepción si el usuario no existe

            return response()->json(['message' => 'La reseña no existe'], 404);

        } catch (Exception $e) {

            // Manejar cualquier otro error y devolver una respuesta de error

            return response()->json([

                'message' => 'Error al obtener la reseña: ' . $e->getMessage()

            ], 500);

        }

    }
 

    public function store(CreateReviewRequest $request): JsonResponse

    {
        if (!AuthHelper::isUser()){
 
            return response()->json([
             
                'message' => 'el usuario no es un lector'   
            ]);
        }
        try {
 
            

            $data = $request->validated();

            // Crear un nuevo usuario con los datos proporcionados

            $review = Review::create([

                'id_user'=> $data['id_user'],
                'id_book'=> $data['id_book'],
                'comment'=> $data['comment'],
                'qualification'=> $data['qualification'],
                'review_date'=> $data['review_date'], 

            ]);
 
            return response()->json([

                'message' => 'Reseña registrada correctamente',

                
                'Reseña' => $review

            ], 201); // Código de estado HTTP 201 para indicar éxito en la creación

        } catch (ValidationException $e) {

            $errors = $e->validator->errors()->all();
 
            // En caso de error, devolver una respuesta JSON con un mensaje de error

            return response()->json([

                'message' => 'Error al registrar la reseña: ' . $e->getMessage(),

                'errors' => $errors

            ], 422); // Código de estado HTTP 422 para indicar una solicitud mal formada debido a errores de validación

        } catch (Exception $e) {

            // En caso de otros errores, devuelve un mensaje genérico de error

            return response()->json([

                'message' => 'Error al registrar la reseña: ' . $e->getMessage()

            ], 500); // Código de estado HTTP 500 para indicar un error del servidor

        }
 
    }
 
    public function update(UpdateReviewRequest $request, $id): JsonResponse
    {
        if (!AuthHelper::isUser()){
 
            return response()->json([
             
                'message' => 'el usuario no es un lector'   
            ]);
        }
        try {
            // Encuentra el usuario por su ID
            $review = Review::findOrFail($id);

            $data = $request->validated();

            // Actualizar el usuario con los datos proporcionados
            $review->update([
                'id_user'=> $data['id_user'],
                'id_book'=> $data['id_book'],
                'comment'=> $data['comment'],
                'qualification'=> $data['qualification'],
                'review_date'=> $data['review_date'], 
            ]);
            $review->refresh();
            return response()->json([
                'message' => 'Reseña actualizada correctamente',
                'Reseña' => $review
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'La reseña no existe'], 404);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            // En caso de error, devolver una respuesta JSON con un mensaje de error
            return response()->json([
                'message' => 'Error al actualizar la reseña: ' . $e->getMessage(),
                'errors' => $errors
            ], 422);
        }
        
    }
 


    public function destroy($id): JsonResponse

    {
        if (!AuthHelper::isUser()){
 
            return response()->json([
             
                'message' => 'el usuario no es un lector'   
            ]);
        }
        try {
 
            

            // Encuentra el usuario por su ID

            $review = Review::findOrFail($id);
 
            // Eliminar el usuario

            $review->delete();
 
            return response()->json([

               'message' => 'Reseña eliminada correctamente'

            ]);

        } catch (ModelNotFoundException $e) {

            return response()->json(['message' => 'La reseña no existe'], 404);

        } catch (Exception $e) {

            // En caso de otros errores, devuelve un mensaje genérico de error

            return response()->json([

                'message' => 'Error al eliminar la reseña: ' . $e->getMessage()

            ], 500); // Código de estado HTTP 500 para indicar un error del servidor

        }

    }

}
<?php

namespace App\Http\Controllers;
 
use App\Helpers\AuthHelper;
use App\Http\Requests\CreateFavoritesRequest;
use App\Http\Requests\UpdateFavoritesRequest;
use App\Models\Favorites;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class FavoritesController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(): JsonResponse

    {

          try{

            $favorites = Favorites::all();

            return response()->json([

              'Favoritos' => $favorites,
 
            ]);

          }catch(Exception $e){

            return response()->json([

              'error' =>'error al obtener favoritos' . $e->getMessage()

            ],500);

        }   

}

    public function show($id): JsonResponse

    {

        try {
            // Buscar el usuario por su ID

            $favorites = Favorites::findOrFail($id);
 
            // Devolver el usuario encontrado en formato JSON

            return response()->json([

                'Favoritos' => $favorites

            ]);

        } catch (ModelNotFoundException $e) {

            // Manejar la excepción si el usuario no existe

            return response()->json(['message' => 'El favorito no existe'], 404);

        } catch (Exception $e) {

            // Manejar cualquier otro error y devolver una respuesta de error

            return response()->json([

                'message' => 'Error al obtener el favorito: ' . $e->getMessage()

            ], 500);

        }

    }
 

    public function store(CreateFavoritesRequest $request): JsonResponse

    {
        if (!AuthHelper::isUser()){
 
            return response()->json([
             
                'message' => 'el usuario no es un lector'   
            ]);
        }
        try {
 
            

            $data = $request->validated();

            // Crear un nuevo usuario con los datos proporcionados

            $favorites = Favorites::create([
                
                'id_user'=> $data['id_user'],
                'id_book'=> $data['id_book'],
                'saved_data'=> $data['saved_data'],
 
            ]);
 
            return response()->json([

                'message' => 'Favorito registrado correctamente',

                
                'Favoritos' => $favorites

            ], 201); // Código de estado HTTP 201 para indicar éxito en la creación

        } catch (ValidationException $e) {

            $errors = $e->validator->errors()->all();
 
            // En caso de error, devolver una respuesta JSON con un mensaje de error

            return response()->json([

                'message' => 'Error al registrar el favorito: ' . $e->getMessage(),

                'errors' => $errors

            ], 422); // Código de estado HTTP 422 para indicar una solicitud mal formada debido a errores de validación

        } catch (Exception $e) {

            // En caso de otros errores, devuelve un mensaje genérico de error

            return response()->json([

                'message' => 'Error al registrar el favorito: ' . $e->getMessage()

            ], 500); // Código de estado HTTP 500 para indicar un error del servidor

        }
 
    }
 
    public function update(UpdateFavoritesRequest $request, $id): JsonResponse
    {
        if (!AuthHelper::isUser()){
 
            return response()->json([
             
                'message' => 'el usuario no es un lector'   
            ]);
        }
        try {
            // Encuentra el usuario por su ID
            $favorites = Favorites::findOrFail($id);

            $data = $request->validated();

            // Actualizar el usuario con los datos proporcionados
            $favorites->update([
                'id_user'=> $data['id_user'],
                'id_book'=> $data['id_book'],
                'saved_data'=> $data['saved_data'],
            ]);
            $favorites->refresh();
            return response()->json([
                'message' => 'Favorito actualizado correctamente',
                'Favoritos' => $favorites
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'El favorito no existe'], 404);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            // En caso de error, devolver una respuesta JSON con un mensaje de error
            return response()->json([
                'message' => 'Error al actualizar el favorito: ' . $e->getMessage(),
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

            $favorites = Favorites::findOrFail($id);
 
            // Eliminar el usuario

            $favorites->delete();
 
            return response()->json([

               'message' => 'Favorito eliminado correctamente'

            ]);

        } catch (ModelNotFoundException $e) {

            return response()->json(['message' => 'El favorito no existe'], 404);

        } catch (Exception $e) {

            // En caso de otros errores, devuelve un mensaje genérico de error

            return response()->json([

                'message' => 'Error al eliminar el favorito: ' . $e->getMessage()

            ], 500); // Código de estado HTTP 500 para indicar un error del servidor

        }

    }

}
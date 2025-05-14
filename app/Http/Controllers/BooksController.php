<?php

namespace App\Http\Controllers;
 
use App\Helpers\AuthHelper;
use App\Http\Requests\CreateBooksRequest;
use App\Http\Requests\UpdateBooksRequest;
use App\Models\Books;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class BooksController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(): JsonResponse

    {

          try{

            $books = Books::all();

            return response()->json([

              'Libros' => $books,
 
            ]);

          }catch(Exception $e){

            return response()->json([

              'error' =>'error al obtener libros' . $e->getMessage()

            ],500);

        }   

}

    public function show($id): JsonResponse

    {

        try {
            // Buscar el usuario por su ID

            $books = Books::findOrFail($id);
 
            // Devolver el usuario encontrado en formato JSON

            return response()->json([

                'Libros' => $books

            ]);

        } catch (ModelNotFoundException $e) {

            // Manejar la excepción si el usuario no existe

            return response()->json(['message' => 'El libro no existe'], 404);

        } catch (Exception $e) {

            // Manejar cualquier otro error y devolver una respuesta de error

            return response()->json([

                'message' => 'Error al obtener el libro: ' . $e->getMessage()

            ], 500);

        }

    }
 

    public function store(CreateBooksRequest $request): JsonResponse

    {
        if (!AuthHelper::isAdmin()){
 
            return response()->json([
             
                'message' => 'el usuario no es un administrador'   
            ]);
        }
        try {
 
            

            $data = $request->validated();

            // Crear un nuevo usuario con los datos proporcionados

            $books = Books::create([


                'name' => $data['name'],
                'description' => $data['description'],
                'author' => $data['author'],
                'publication_date' => $data['publication_date'],
                'id_category' => $data['id_category'],
                'id_user' => $data['id_user'],
                
 
            ]);
 
            return response()->json([

                'message' => 'Libro registrado correctamente',

                
                'Libros' => $books

            ], 201); // Código de estado HTTP 201 para indicar éxito en la creación

        } catch (ValidationException $e) {

            $errors = $e->validator->errors()->all();
 
            // En caso de error, devolver una respuesta JSON con un mensaje de error

            return response()->json([

                'message' => 'Error al registrar el libro: ' . $e->getMessage(),

                'errors' => $errors

            ], 422); // Código de estado HTTP 422 para indicar una solicitud mal formada debido a errores de validación

        } catch (Exception $e) {

            // En caso de otros errores, devuelve un mensaje genérico de error

            return response()->json([

                'message' => 'Error al registrar el libro: ' . $e->getMessage()

            ], 500); // Código de estado HTTP 500 para indicar un error del servidor

        }
 
    }
 
    public function update(UpdateBooksRequest $request, $id): JsonResponse
    {
        if (!AuthHelper::isAdmin()){
 
            return response()->json([
             
                'message' => 'el usuario no es un administrador'   
            ]);
        }
        try {
            // Encuentra el usuario por su ID
            $books = Books::findOrFail($id);

            $data = $request->validated();

            // Actualizar el usuario con los datos proporcionados
            $books->update([
                'name' => $data['name'],
                'description' => $data['description'],
                'author' => $data['author'],
                'publication_date' => $data['publication_date'],
                'id_category' => $data['id_category'],
                'id_user' => $data['id_user'],
            ]);
            $books->refresh();
            return response()->json([
                'message' => 'Libro actualizado correctamente',
                'Libros' => $books
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'El libro no existe'], 404);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            // En caso de error, devolver una respuesta JSON con un mensaje de error
            return response()->json([
                'message' => 'Error al actualizar el libro: ' . $e->getMessage(),
                'errors' => $errors
            ], 422);
        }
        
    }
 


    public function destroy($id): JsonResponse

    {
        if (!AuthHelper::isAdmin()){
 
            return response()->json([
             
                'message' => 'el usuario no es un administrador'   
            ]);
        }
        try {
 
            

            // Encuentra el usuario por su ID

            $books = Books::findOrFail($id);
 
            // Eliminar el usuario

            $books->delete();
 
            return response()->json([

               'message' => 'Libro eliminado correctamente'

            ]);

        } catch (ModelNotFoundException $e) {

            return response()->json(['message' => 'El Libro no existe'], 404);

        } catch (Exception $e) {

            // En caso de otros errores, devuelve un mensaje genérico de error

            return response()->json([

                'message' => 'Error al eliminar el libro: ' . $e->getMessage()

            ], 500); // Código de estado HTTP 500 para indicar un error del servidor

        }

    }

}
<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
class UserController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
       
        return UserResource::collection(User::join("tipo_usuarios", "tipo_usuarios.id", "=", "users.tipo_usuarios_id")
        ->select("users.id","users.name", "users.email","tipo_usuarios.descripcion","users.tipo_usuarios_id")->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         /** Datos recibidos */
         $post = $request->all();
         /** Datos a Validar */
         $rules = [
             'id' =>  ['required', Rule::unique('users', 'id')]  ,            
             'name' =>  ['required'],
             'email' =>  ['required', Rule::unique('users', 'email')]  ,
             'password' =>  ['required'],
             'tipo_usuarios_id' =>  ['required', Rule::exists('tipo_usuarios', 'id')]          
             
 
         ];
 
         /** Verificar   */
         $validator = Validator::make($post, $rules);

         if ($validator->fails()) return $validator->errors()->all();

         $task = User::create([
                    'id' => $post['id'],                    
                    'name' => $post['name'],
                    'email' => $post['email'],
                    'password' => bcrypt($post['password'])  ,
                    'tipo_usuarios_id' => $post['tipo_usuarios_id']                   
                ]);
                return response()->json([
                "guardado"  => 'guardado'
            ], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        


    }

    public function buscarId(Request $request)
    {

         /** Datos recibidos */
         $post = $request->all();
           /** Datos a Validar */
       $rules = [
            'id' =>   ['required'  , Rule::exists('users', 'id')]
        ];
           /** Mensajes personalizados */
        $messages = [
            'id.exists' => 'Este registro no existe!!!'
        ];

          /** Verificar   */
          $validator = Validator::make($post, $rules, $messages);
          /** Error Validacion */
          if ($validator->fails()) return $validator->errors()->all();

         
            $de =  User::join("tipo_usuarios", "tipo_usuarios.id", "=", "users.tipo_usuarios_id")
            ->select("users.id","users.name", "users.email","tipo_usuarios.descripcion","users.tipo_usuarios_id")
            ->where('users.id', '=',  $post['id'])->get();
            return  $de;
       


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
           /** Datos recibidos */
           $post = $request->all();
           /** Datos a Validar */
       $rules = [
            'id' =>   ['required'  , Rule::exists('users', 'id')]
            
        ];
           /** Mensajes personalizados */
        $messages = [
            'id.exists' => 'Este registro no existe!!!'
        ];

          /** Verificar   */
          $validator = Validator::make($post, $rules, $messages);
          /** Error Validacion */
          if ($validator->fails()) return $validator->errors()->all();

          $usuario = User::findOrFail($post['id']);
          $usuario->name = $post['name'];
          $usuario->save(); 

    }

    public function changepassword(Request $request)
    {
           /** Datos recibidos */
           $post = $request->all();
           /** Datos a Validar */
       $rules = [
        'id' =>   ['required'  , Rule::exists('users', 'id')]
        ];
           /** Mensajes personalizados */
        $messages = [
            'id.exists' => 'Este registro no existe!!!'
        ];

          /** Verificar   */
          $validator = Validator::make($post, $rules, $messages);
          /** Error Validacion */
          if ($validator->fails()) return $validator->errors()->all();

          $usuario = User::findOrFail($post['id']);
          $usuario->password = bcrypt($post['password']);
          $usuario->save(); 

    }

    public function cambiarTipoUsuario(Request $request)
    {
             /** Datos recibidos */
             $post = $request->all();
             /** Datos a Validar */
         $rules = [
              'id' =>   ['required'  , Rule::exists('users', 'id')],
              'tipo_usuarios_id' =>   ['required'  , Rule::exists('users', 'tipo_usuarios_id')]
          ];
             /** Mensajes personalizados */
          $messages = [
              'id.exists' => 'Este registro no existe!!!',
              'tipo_usuarios_id.exists' => 'el tipo de usuario Este registro no existe!!!'
          ];
  
            /** Verificar   */
            $validator = Validator::make($post, $rules, $messages);
            /** Error Validacion */
            if ($validator->fails()) return $validator->errors()->all();
  
            $usuario = User::findOrFail($post['id']);
            $usuario->tipo_usuarios_id = $post['tipo_usuarios_id'];
            $usuario->save(); 

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

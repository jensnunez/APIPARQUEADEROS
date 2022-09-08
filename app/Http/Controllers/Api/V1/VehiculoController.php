<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\VehiculoResource;
use App\Models\User;
use App\Models\UsuarioVehiculo;
use App\Models\Vehiculo;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\FuncCall;

class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Vehiculo::all();
       
        return VehiculoResource::collection(Vehiculo::join("tipo_vehiculos", "tipo_vehiculos.id", "=", "vehiculos.tipo_vehiculo_id")
        ->leftJoin("user_vehiculo", "user_vehiculo.placa_id", "=", "vehiculos.id")
        ->leftJoin("users", "users.id", "=", "user_vehiculo.user_id")
        ->select("vehiculos.id","vehiculos.placa", "vehiculos.observacion","tipo_vehiculos.descripcion","vehiculos.tipo_vehiculo_id","user_vehiculo.user_id","users.name","users.email")->paginate(10));
    }

    public function listado_pendiente() {   
        
        $vehiculos = UsuarioVehiculo::all();
            foreach ($vehiculos as $vehiculo) {
                $data[] = $vehiculo->id;
            }
       
        return VehiculoResource::collection(Vehiculo::join("tipo_vehiculos", "tipo_vehiculos.id", "=", "vehiculos.tipo_vehiculo_id")       
        ->select("vehiculos.id","vehiculos.placa", "vehiculos.observacion","tipo_vehiculos.descripcion","vehiculos.tipo_vehiculo_id")
        ->whereNotIn('vehiculos.id', $data)->paginate(10));
    }

    public function buscarId(Request $request)
    {
         /** Datos recibidos */
         $post = $request->all();
           /** Datos a Validar */
       $rules = [
            'id' =>   ['required'  , Rule::exists('vehiculos', 'id')]
        ];
           /** Mensajes personalizados */
        $messages = [
            'id.exists' => 'Este registro no existe!!!'
        ];

          /** Verificar   */
          $validator = Validator::make($post, $rules, $messages);
          /** Error Validacion */
          if ($validator->fails()) return $validator->errors()->all();

         
          return VehiculoResource::collection(Vehiculo::join("tipo_vehiculos", "tipo_vehiculos.id", "=", "vehiculos.tipo_vehiculo_id")
          ->leftJoin("user_vehiculo", "user_vehiculo.placa_id", "=", "vehiculos.id")
          ->leftJoin("users", "users.id", "=", "user_vehiculo.user_id")
          ->select("vehiculos.id","vehiculos.placa", "vehiculos.observacion","tipo_vehiculos.descripcion","vehiculos.tipo_vehiculo_id","user_vehiculo.user_id","users.name","users.email")
          ->where('vehiculos.id', $post['id'])->paginate(10));
          
        
       


    }
    public function buscarPlaca(Request $request)
    {
         /** Datos recibidos */
         $post = $request->all();
           /** Datos a Validar */
       $rules = [
            'placa' =>   ['required'  , Rule::exists('vehiculos', 'placa')]
        ];
           /** Mensajes personalizados */
        $messages = [
            'placa.exists' => 'Este registro no existe!!!'
        ];

          /** Verificar   */
          $validator = Validator::make($post, $rules, $messages);
          /** Error Validacion */
          if ($validator->fails()) return $validator->errors()->all();

         
          return VehiculoResource::collection(Vehiculo::join("tipo_vehiculos", "tipo_vehiculos.id", "=", "vehiculos.tipo_vehiculo_id")
          ->leftJoin("user_vehiculo", "user_vehiculo.placa_id", "=", "vehiculos.id")
          ->leftJoin("users", "users.id", "=", "user_vehiculo.user_id")
          ->select("vehiculos.id","vehiculos.placa", "vehiculos.observacion","tipo_vehiculos.descripcion","vehiculos.tipo_vehiculo_id","user_vehiculo.user_id","users.name","users.email")
          ->where('vehiculos.placa', $post['placa'])->paginate(10));
          
        
       


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
        'placa' =>  ['required', Rule::unique('vehiculos', 'placa')]  ,            
        'observacion' =>  ['required'],      
        'tipo_vehiculo_id' =>  ['required', Rule::exists('tipo_vehiculos', 'id')] ,      
        'propietario' =>  Rule::in([0, 1])       

    ];

       /** Verificar   */
       $validator = Validator::make($post, $rules);

       if ($validator->fails()) return $validator->errors()->all();   


       $task = Vehiculo::create([                               
                  'placa' => $post['placa']   ,
                  'observacion' => $post['observacion']     ,
                  'tipo_vehiculo_id' => $post['tipo_vehiculo_id']                   
              ]);          

              if ($post['propietario']===1) {
                $record = Vehiculo::where("placa","=",$post['placa'])->select("id")->value('id');
                UsuarioVehiculo::create([
                  'placa_id' => $record,
                  'user_id' =>  Auth::user()->id,
      
                ]);
              }
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
    public function show($id)
    {
        //
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
          'id' =>   ['required'  , Rule::exists('sedes', 'id')],
          'observacion' => ['required']    ,
          'tipo_vehiculo_id' => ['required']
          
      ];
         /** Mensajes personalizados */
      $messages = [
          'id.exists' => 'Este registro no existe!!!',
         
      ];

        /** Verificar   */
        $validator = Validator::make($post, $rules, $messages);
        /** Error Validacion */
        if ($validator->fails()) return $validator->errors()->all();

        $vehiculo = Vehiculo::findOrFail($post['id']);      
        $vehiculo->observacion = $post['observacion'];
        $vehiculo->tipo_vehiculo_id = $post['tipo_vehiculo_id'];
        $vehiculo->save(); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
         /** Datos recibidos */
         $post = $request->all();
         /** Datos a Validar */
     $rules = [
          'id' =>   ['required'  , Rule::exists('vehiculos', 'id')]
      ];
         /** Mensajes personalizados */
      $messages = [
          'id.exists' => 'Este registro no existe!!!'
      ];

        /** Verificar   */
        $validator = Validator::make($post, $rules,  $messages);
/** Error Validacion */
if ($validator->fails()) return $validator->errors()->all();


        if (DB::table('reportes')
        ->where('placa_id',$post['id'])->count() == 0 ) 
        {  
            if (DB::table('user_vehiculo')
            ->where('placa_id',$post['id'])->count() == 0 ) 
            {

                $record = Vehiculo::where('id', $post['id']);
                $record->delete();
                return response()->json([
                    "eliminado"  => 'eliminado'
                ], 200);
            } 
              else {
                return response()->json([
                    "sin exito"  => 'este vehiculo ya esta asociado un usuario'
                ], 200);
              }

        } else {
           return response()->json([
               "sin exito"  => 'este vehiculo ya esta asociado a un reporte'
           ], 200);
        }
    }

    public function asignar_usuario(Request $request)
    {
        /** Datos recibidos */
       $post = $request->all();
       /** Datos a Validar */
       $rules = [
        'user_id' =>  ['required', Rule::exists('users', 'id')] ,     
        'placa_id' =>  ['required', Rule::exists('vehiculos', 'id')] ,      
            

    ];

       /** Verificar   */
       $validator = Validator::make($post, $rules);

       if ($validator->fails()) return $validator->errors()->all();   

       if (DB::table('user_vehiculo')
       ->where('user_id',$post['user_id'])
       ->where('placa_id',$post['placa_id'])->count() == 0 ) 
       {
            UsuarioVehiculo::create([
                'placa_id' => $post['placa_id'],
                'user_id' =>  $post['user_id'],

            ]);
       }   else {
                    return response()->json([
                        "sin exito"  => 'este usuario ya pertenece a este vehiculo'
                    ], 200);
     }
     
               
              
            
    }

    public function desasignar_usuario(Request $request) {
         /** Datos recibidos */
         $post = $request->all();
         /** Datos a Validar */
     $rules = [
        'user_id' =>  ['required', Rule::exists('users', 'id')] ,     
        'placa_id' =>  ['required', Rule::exists('vehiculos', 'id')] ,     
      ];
         /** Mensajes personalizados */
      

        /** Verificar   */
        $validator = Validator::make($post, $rules);
/** Error Validacion */
if ($validator->fails()) return $validator->errors()->all();


if (DB::table('user_vehiculo')
->where('user_id',$post['user_id'])
->where('placa_id',$post['placa_id'])->count() > 0 ) 
{
           $record = UsuarioVehiculo::where('user_id',$post['user_id'])
           ->where('placa_id',$post['placa_id']);
           $record->delete();
           return response()->json([
               "eliminado"  => 'eliminado'
           ], 200);

        }   else {
            return response()->json([
                "sin exito"  => 'este usuario no pertenece a este vehiculo'
            ], 200);
}

    }

}

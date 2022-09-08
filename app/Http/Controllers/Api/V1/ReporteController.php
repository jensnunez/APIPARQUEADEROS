<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ReporteResource;
use App\Mail\ReportarMail;
use App\Models\Reporte;
use App\Models\User;
use App\Models\Vehiculo;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ReporteResource::collection(Reporte::join("vehiculos", "vehiculos.id", "=", "reportes.placa_id")
        ->Join("tipo_reportes", "tipo_reportes.id", "=", "reportes.tipo_reporte_id")
        ->Join("sedes", "sedes.id", "=", "reportes.sede_id")
        ->Join("users", "users.id", "=", "reportes.user_id")
        ->Join("periodos", "periodos.id", "=", "reportes.periodo_id")
        ->select("reportes.id","vehiculos.placa", "reportes.placa_id","tipo_reportes.descripcion as tipo_reporte","reportes.tipo_reporte_id","reportes.sede_id","sedes.descripcion", "reportes.user_id","users.name","users.email", "reportes.periodo_id", "periodos.descripcion as periodo")
        ->where("reportes.estado","=","1")->paginate(10));
    }

    public function reportes_desbloqueados(){
        return ReporteResource::collection(Reporte::join("vehiculos", "vehiculos.id", "=", "reportes.placa_id")
        ->Join("tipo_reportes", "tipo_reportes.id", "=", "reportes.tipo_reporte_id")
        ->Join("sedes", "sedes.id", "=", "reportes.sede_id")
        ->Join("users", "users.id", "=", "reportes.user_id")
        ->Join("periodos", "periodos.id", "=", "reportes.periodo_id")
        ->select("reportes.id","vehiculos.placa", "reportes.placa_id","tipo_reportes.descripcion as tipo_reporte","reportes.tipo_reporte_id","reportes.sede_id","sedes.descripcion", "reportes.user_id","users.name","users.email", "reportes.periodo_id", "periodos.descripcion as periodo")
        ->where("reportes.estado","=","0")->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function buscarId(Request $request)
    {

         /** Datos recibidos */
         $post = $request->all();
           /** Datos a Validar */
       $rules = [
            'id' =>   ['required'  , Rule::exists('reportes', 'id')]
        ];
           /** Mensajes personalizados */
        $messages = [
            'id.exists' => 'Este registro no existe!!!'
        ];

          /** Verificar   */
          $validator = Validator::make($post, $rules, $messages);
          /** Error Validacion */
          if ($validator->fails()) return $validator->errors()->all();

         
            return ReporteResource::collection(Reporte::join("vehiculos", "vehiculos.id", "=", "reportes.placa_id")
          ->Join("tipo_reportes", "tipo_reportes.id", "=", "reportes.tipo_reporte_id")
          ->Join("sedes", "sedes.id", "=", "reportes.sede_id")
          ->Join("users", "users.id", "=", "reportes.user_id")
          ->Join("periodos", "periodos.id", "=", "reportes.periodo_id")
          ->select("reportes.id","vehiculos.placa", "reportes.placa_id","tipo_reportes.descripcion as tipo_reporte","reportes.tipo_reporte_id","reportes.sede_id","sedes.descripcion", "reportes.user_id","users.name","users.email", "reportes.periodo_id", "periodos.descripcion as periodo")
          ->where('reportes.id', $post['id'])->get());
          
        
       


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

          $record = Vehiculo::where("placa","=",$request['placa'])->select("id")->value('id');

         
            return ReporteResource::collection(Reporte::join("vehiculos", "vehiculos.id", "=", "reportes.placa_id")
          ->Join("tipo_reportes", "tipo_reportes.id", "=", "reportes.tipo_reporte_id")
          ->Join("sedes", "sedes.id", "=", "reportes.sede_id")
          ->Join("users", "users.id", "=", "reportes.user_id")
          ->Join("periodos", "periodos.id", "=", "reportes.periodo_id")
          ->select("reportes.id","vehiculos.placa", "reportes.placa_id","tipo_reportes.descripcion as tipo_reporte","reportes.tipo_reporte_id","reportes.sede_id","sedes.descripcion", "reportes.user_id","users.name","users.email", "reportes.periodo_id", "periodos.descripcion as periodo")
          ->where('reportes.placa_id', $record)->get());
          
        
       


    }



    public function store(Request $request)
    {
         /** Datos recibidos */
       $post = $request->all();
       /** Datos a Validar */
       $rules = [
        'placa_id' =>  ['required', Rule::exists('vehiculos', 'id')]  ,            
        'fecha' =>  ['required'],      
        'tipo_reporte_id' =>  ['required', Rule::exists('tipo_reportes', 'id')] , 
        'sede_id' =>  ['required', Rule::exists('sedes', 'id')] , 
        'periodo_id' =>  ['required', Rule::exists('periodos', 'id')] ,   
        'user_id' =>  ['required', Rule::exists('users', 'id')] ,            

    ];
       /** Verificar   */
       $validator = Validator::make($post, $rules);
       if ($validator->fails()) return $validator->errors()->all(); 

       $task = Reporte::create([                               
                  'placa_id' => $post['placa_id']   ,
                  'fecha' => $post['fecha']     ,
                  'tipo_reporte_id' => $post['tipo_reporte_id']   ,
                  'sede_id' => $post['sede_id']     ,
                  'periodo_id' => $post['periodo_id']  ,
                  'user_id' => $post['user_id']  ,
                  'estado' => 1,              
              ]);        

              $record = Vehiculo::where("id","=",$post['placa_id'])->select("placa")->value('placa');
              $correodestino = User::where("id","=",$post['user_id'])->select("email")->value('email');



             
              $correo = new ReportarMail($record,"Imagen reportada");
              Mail::to("jens0415@gmail.com")->send($correo);


              
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
            'id' =>   ['required'  , Rule::exists('reportes', 'id')]
        ];
           /** Mensajes personalizados */
        $messages = [
            'id.exists' => 'Este registro no existe!!!'
        ];

          /** Verificar   */
          $validator = Validator::make($post, $rules, $messages);
          /** Error Validacion */
          if ($validator->fails()) return $validator->errors()->all();

          $reporte = Reporte::findOrFail($post['id']);
          $reporte->estado = 0;         
          $reporte->save(); 

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

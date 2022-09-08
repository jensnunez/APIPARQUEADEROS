<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\SedeResource;
use App\Models\Sede;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SedeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $de =  SedeResource::collection(Sede::all('id','nombre','direccion','descripcion'));       
        return  $de;
    }

    public function buscarId(Request $request)
    {

         /** Datos recibidos */
         $post = $request->all();
           /** Datos a Validar */
       $rules = [
            'id' =>   ['required'  , Rule::exists('sedes', 'id')]
        ];
           /** Mensajes personalizados */
        $messages = [
            'id.exists' => 'Este registro no existe!!!'
        ];

          /** Verificar   */
          $validator = Validator::make($post, $rules, $messages);
          /** Error Validacion */
          if ($validator->fails()) return $validator->errors()->all();

         
          return SedeResource::collection(Sede::where('id', $post['id'])->get());
          
        
       


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
        'nombre' =>  ['required']   ,
        'direccion' =>  ['required']  ,
        'descripcion' =>  ['required']       

           

       ];

       /** Verificar   */
       $validator = Validator::make($post, $rules);

       if ($validator->fails()) return $validator->errors()->all();

     


       $task = Sede::create([                               
                  'nombre' => $post['nombre']   ,
                  'direccion' => $post['direccion']     ,
                  'descripcion' => $post['descripcion']                   
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
          'nombre' => ['required']   ,
          'direccion' => ['required']   ,
          'descripcion' => ['required']   ,
          
      ];
         /** Mensajes personalizados */
      $messages = [
          'id.exists' => 'Este registro no existe!!!',
         
      ];

        /** Verificar   */
        $validator = Validator::make($post, $rules, $messages);
        /** Error Validacion */
        if ($validator->fails()) return $validator->errors()->all();

        $sede = Sede::findOrFail($post['id']);
        $sede->nombre = $post['nombre'];
        $sede->direccion = $post['direccion'];
        $sede->descripcion = $post['descripcion'];
        $sede->save(); 
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
           'id' =>   ['required'  , Rule::exists('sedes', 'id')]
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
         ->where('sede_id',$post['id'])->count() == 0 ) 
         {
            $record = Sede::where('id', $post['id']);
            $record->delete();
            return response()->json([
                "eliminado"  => 'eliminado'
            ], 200);

         } else {
            return response()->json([
                "sin exito"  => 'esta sede ya esta asociada a un reporte'
            ], 200);
         }


    }
}

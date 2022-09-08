<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PeriodoResource;
use App\Models\Periodo;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeriodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $de =  PeriodoResource::collection(Periodo::all('id','descripcion'));       
        return  $de;
    }

    public function buscarId(Request $request)
    {

         /** Datos recibidos */
         $post = $request->all();
           /** Datos a Validar */
       $rules = [
            'id' =>   ['required'  , Rule::exists('periodos', 'id')]
        ];
           /** Mensajes personalizados */
        $messages = [
            'id.exists' => 'Este registro no existe!!!'
        ];

          /** Verificar   */
          $validator = Validator::make($post, $rules, $messages);
          /** Error Validacion */
          if ($validator->fails()) return $validator->errors()->all();

         
          return PeriodoResource::collection(Periodo::where('id', $post['id'])->get());
          
        
       


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
           'descripcion' =>  ['required', Rule::unique('periodos', 'descripcion')]                 
           

       ];

       /** Verificar   */
       $validator = Validator::make($post, $rules);

       if ($validator->fails()) return $validator->errors()->all();

     


       $task = Periodo::create([
                               
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
          'id' =>   ['required'  , Rule::exists('periodos', 'id')],
          'descripcion' =>   ['required'  , Rule::Unique('periodos', 'descripcion')]
          
      ];
         /** Mensajes personalizados */
      $messages = [
          'id.exists' => 'Este registro no existe!!!',
         
      ];

        /** Verificar   */
        $validator = Validator::make($post, $rules, $messages);
        /** Error Validacion */
        if ($validator->fails()) return $validator->errors()->all();

        $TipoReporte = Periodo::findOrFail($post['id']);
        $TipoReporte->descripcion = $post['descripcion'];
        $TipoReporte->save(); 
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
           'id' =>   ['required'  , Rule::exists('periodos', 'id')]
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
         ->where('periodo_id',$post['id'])->count() == 0 ) 
         {
            $record = Periodo::where('id', $post['id']);
            $record->delete();
            return response()->json([
                "eliminado"  => 'eliminado'
            ], 200);

         } else {
            return response()->json([
                "sin exito"  => 'este periodo ya esta asociado a un reporte'
            ], 200);
         }


    }
}
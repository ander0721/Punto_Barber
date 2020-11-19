<?php

namespace App\Http\Controllers;

use App\Comentario;
use Illuminate\Http\Request;


class ComentarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {       
        $comentarios = Comentario::paginate(5);
        return view ('posts.index')
        ->with("comentarios" ,$comentarios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('comentario.new'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comentario = new Comentario();
        $comentario->comentario = $request->input("nombreB");

        $comentario->save();

        return redirect()->route('comentarios.index')
        ->with("exito" , "el comentario fue registrado correctamente");
    }

    public function like(): JsonResponse
    {
        $comentario = Comentario::find(request()->id);

        if ($comentario->isLikedByLoggedInUser()) {
            $res = Like::where([
                'user_id' => auth()->user()->id,
                'comentario_idC' => request()->id
            ])->delete();

            if ($res) {
                return response()->json([
                    'count' => Comentario::find(request()->id)->likes->count()
                ]);
            }

        } else {
            $like = new Like();

            $like->user_id = auth()->user()->id;
            $like->comentario_idC = request()->id;

            $like->save();

            return response()->json([
                'count' => Comentario::find(request()->id)->likes->count()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function show(Comentario $comentario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function edit(Comentario $comentario)
    {
        return view('comentario.edit',compact('comentario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comentario $comentario)
    {
        $comentario->update($request->all());
  
        return redirect()->route('comentarios.index')
                        ->with('Exito','Se actualizó correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comentario $comentario)
    {
        
        $comentario->delete();
  
        return redirect()->route('comentario.index')
                        ->with('Exito','El comentario se elimino correctamente');
    }
}

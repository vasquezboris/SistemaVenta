<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


//use SisVentas\Http\Request;

use SisVentas\Categoria;

use Illuminate\Support\Facades\Redirect;

use SisVentas\Http\Request\CategoriaFormRequest;

use DB;

class CategoriaController extends Controller
{
    public function __construct()
    {

    }
    public function index(Request $request)
    {
    	if($request)
    	{
    		$query=trim($request->get('searchText'));
    		$categorias=DB::table('categoria')->where('nombre','LIKE','%'.query.'%')
    		->where('condicion','=','1')
    		->orderBy('idcategoria','desc')
    		->paginate(7);

    		return view('almacen.index',["categorias"=>$categorias,"searchText"=>$query]);
    	}
    }
    public function create()
    {
    	return view("almacen.create");
    }
    public function store(CategoriaFormRequest $request)
    {
    	$categoria=new Categoria;
    	$categoria->nombre=$request->get('nombre');
    	$categoria->descripcion=$request->get('descripcion');
    	$categoria->condicion='1';
    	$categoria->save();

    	return Redirect::to('almacen.index');
    }
    public function show($id)
    {
    	return view('almacen.show',['categoria'=>Categoria::findOrFail($id)]);
    }
    public function edit($id)
    {
    	return view('almacen.edit',['categoria'=>Categoria::findOrFail($id)]);
    }
    public function update(CategoriaFormRequest $request, $id)
    {
    	$categoria=Categoria::findOrFail($id);
    	$categoria->nombre=$request->get('nombre');
    	$categoria->descripcion=$request->get('descripcion');
    	$categoria->update();

    	return Redirect::to('almacen');
    }
    public function destroy($id)
    {
    	$categoria=CAtegoria::findOrFail($id);
    	$categoria->condicion='0';
    	$categoria->update();

    	return Redirect::to('almacen');
    }
}

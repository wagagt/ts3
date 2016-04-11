<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProyectosRequest;
use Illuminate\Http\Request;
use App\Libraries\Repositories\ProyectosRepository;
use App\Libraries\Repositories\ClientesRepository;
use App\Libraries\Repositories\EstadosRepository;
use Mitul\Controller\AppBaseController;
use App\Models\Proyectos;
use Response;
use Flash;


class PdfController extends Controller {
	
	private $proyectosRepository;
	private $clientesRepository;
	private $estadosRepository;
	
	function __construct(ProyectosRepository $proyectosRepo, EstadosRepository $estadosRepo, ClientesRepository $clientesRepo )
	{
		$this->proyectosRepository 	= $proyectosRepo;
		$this->clientesRepository  	= $clientesRepo;
		$this->estadosRepository  	= $estadosRepo;
	}
	
	public function proyecto($id){
		$proyecto = $this->proyectosRepository->findProyectosById($id);
		if(empty($proyecto))
		{
			Flash::error('Proyectos not found');
			return redirect(route('proyectos.index'));
		}
		
		$isAdmin 		= (\Auth::user()->id_rol == 1 )? 'true' : 'false';
		$proyectos 		= \DB::table('proyectos')->where('id_cliente',\Auth::user()->id_cliente)->orderBy('id_estado','asc')->get();
		$comentarios 	= \DB::table('comentarios')->where('id_proyecto', $id)->orderBy('fecha', 'asc')->get();
		$proyectosShow = ($isAdmin=='true')? 'proyectos.admin-show' : 'proyectos.client-show';
		//return view($proyectosShow)
		$view = \View::make('pdf.proyecto') 
		->with('proyectos',$proyectos)
		->with('proyecto',$proyecto)
		->with('comentarios', $comentarios)
		->with('isAdmin', $isAdmin)
		->with('title','Detalle de Proyecto:')
		->with('subTitle', $proyecto->nombre)		
		->render();
		//return $view;
		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($view);
		return $pdf->stream('invoice');
		
	}

	public function index()
	{
		//
	}

	public function create()
	{
		//
	}

	public function store()
	{
		//
	}

	public function show($id)
	{
		//
	}

	public function edit($id)
	{
		//
	}

	public function update($id)
	{
		//
	}

	public function destroy($id)
	{
		//
	}

}

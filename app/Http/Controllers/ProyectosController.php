<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateProyectosRequest;
use Illuminate\Http\Request;
use App\Libraries\Repositories\ProyectosRepository;
use App\Libraries\Repositories\ClientesRepository;
use App\Libraries\Repositories\EstadosRepository;
use Mitul\Controller\AppBaseController;
use App\Models\Proyectos;
use Response;
use Flash;

class ProyectosController extends AppBaseController
{

	private $proyectosRepository;
	private $clientesRepository;
	private $estadosRepository;
	private $maquina_options;
	private $metodo_options;
	

	function __construct(ProyectosRepository $proyectosRepo, EstadosRepository $estadosRepo, ClientesRepository $clientesRepo )
	{
		$this->proyectosRepository 	= $proyectosRepo;
		$this->clientesRepository  	= $clientesRepo;
		$this->estadosRepository  	= $estadosRepo;
		$this->maquina_options		= ['M-3' => 'M-3','M-4' => 'M-4','M-5' => 'M-5','M-6' => 'M-6',
		'M-7' => 'M-7', 'M-8' => 'M-8', 'M-9' => 'M-9', 'M-10' => 'M-10', 'M-11' => 'M-11', 'M-12' => 'M-12', 'M-13' => 'M-13']; 
		$this->metodo_options		= ['Rotativo' => 'Rotativo', 'Percusión' => 'Percusión', 
		'Roto-Percusión' => 'Roto-Percusión'];
	}

	public function index(Request $request)
	{
	    $input = $request->all();

		$result = $this->proyectosRepository->search($input);
		$attributes = $result[1];
		$proyectos = Proyectos::with('cliente')->orderBy('id_estado','asc')->get();
		return view('proyectos.index')
		    ->with('proyectos', $proyectos)
		    ->with('attributes', $attributes);;
	}

	public function create()
	{
		$estados_options 	= $this->estadosRepository->optionList();
		$clientes_options 	= $this->clientesRepository->optionList();
		return view('proyectos.create')
		->with('estado_options', $estados_options)
		->with('cliente_options', $clientes_options)
		->with('maquina_options', $this->maquina_options)
		->with('metodo_options', $this->metodo_options);
	}

	public function store(CreateProyectosRequest $request)
	{
        $input = $request->all();
		$proyectos = $this->proyectosRepository->store($input);
		Flash::message('Proyectos saved successfully.');
		return redirect(route('proyectos.index'));
	}

	public function show($id)
	{
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
			return view($proyectosShow)
			->with('proyectos',$proyectos)
			->with('proyecto',$proyecto)
			->with('comentarios', $comentarios)
			->with('isAdmin', $isAdmin)
			->with('title','Detalle de Proyecto: ')
			->with('subTitle', $proyecto->nombre);
	}

	public function edit($id)
	{
		$proyectos = $this->proyectosRepository->findProyectosById($id);
		$estados_options 	= $this->estadosRepository->optionList();
		$clientes_options 	= $this->clientesRepository->optionList();
		if(empty($proyectos))
		{
			Flash::error('Proyectos not found');
			return redirect(route('proyectos.index'));
		}
		return view('proyectos.edit')
		->with('proyectos', $proyectos)
		->with('estado_options', $estados_options)
		->with('cliente_options', $clientes_options)
		->with('maquina_options', $this->maquina_options)
		->with('metodo_options', $this->metodo_options);
	}

	public function update($id, CreateProyectosRequest $request)
	{
		$proyectos = $this->proyectosRepository->findProyectosById($id);
		if(empty($proyectos))
		{
			Flash::error('Proyectos not found');
			return redirect(route('proyectos.index'));
		}
		$proyectos = $this->proyectosRepository->update($proyectos, $request->all());
		Flash::message('Proyectos updated successfully.');
		return redirect(route('proyectos.index'));
	}

	public function destroy($id)
	{
		$proyectos = $this->proyectosRepository->findProyectosById($id);
		if(empty($proyectos))
		{
			Flash::error('Proyectos not found');
			return redirect(route('proyectos.index'));
		}
		$proyectos->delete();
		Flash::message('Proyectos deleted successfully.');
		return redirect(route('proyectos.index'));
	}
}

<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateComentariosRequest;
use Illuminate\Http\Request;
use App\Libraries\Repositories\ComentariosRepository;
use App\Libraries\Repositories\ProyectosRepository;
use Mitul\Controller\AppBaseController;
use App\Http\Controllers\App\Comentarios;
use Response;
use Flash;
use Auth;
use App\Models;
use Carbon\Carbon;

class ComentariosController extends AppBaseController
{
	private $comentariosRepository;
	private $proyectosRepository;

	function __construct(ComentariosRepository $comentariosRepo, ProyectosRepository $proyectosRepo)
	{
		$this->comentariosRepository = $comentariosRepo;
		$this->proyectosRepository = $proyectosRepo;
	}

	public function index(Request $request)
	{
	    $input = $request->all();
		$comentarios = \DB::table('comentarios')->orderBy('created_at', 'desc')->paginate(25);
		$comentarios->setPath($request->url());
		return view('comentarios.index')
		    ->with('comentarios', $comentarios);
	}

	public function create()
	{
		$proyectos_options = $this->proyectosRepository->optionList();
		return view('comentarios.create')
		->with('proyecto_options', $proyectos_options);
	}

	public function store(CreateComentariosRequest $request)
	{
        $input = $request->all();
		$comentarios = $this->comentariosRepository->store($input);
		Flash::message('Comentarios agregados exitosamente.');

		if (isset($input['pathReturn']) && $input['pathReturn']=='proyecto'){
			return redirect('proyectos/'.$input['id_proyecto'] );
		}

		return redirect(route('comentarios.index'));
	}

	public function show($id)
	{
		$comentarios = $this->comentariosRepository->findComentariosById($id);
		if(empty($comentarios))
		{
			Flash::error('Comentarios not found');
			return redirect(route('comentarios.index'));
		}
		return view('comentarios.show')->with('comentarios', $comentarios);
	}

	public function edit($id)
	{
		$comentarios = $this->comentariosRepository->findComentariosById($id);
		$proyectos_options = $this->proyectosRepository->optionList();
		if(empty($comentarios))
		{
			Flash::error('Comentarios not found');
			return redirect(route('comentarios.index'));
		}
		return view('comentarios.edit')
		->with('comentarios', $comentarios)
		->with('proyecto_options', $proyectos_options);
	}

	public function update($id, CreateComentariosRequest $request)
	{
		$comentarios = $this->comentariosRepository->findComentariosById($id);
		$input = $request->all();
		if(empty($comentarios))
		{
			Flash::error('Comentarios not found');
			return redirect(route('comentarios.index'));
		}

		$comentarios = $this->comentariosRepository->update($comentarios, $request->all());
		Flash::message('Comentario actualizado.');
		return redirect('/proyectos/'.$input['id_proyecto']);
	}

	public function destroy($id, Request $request)
	{
		//dd($id);
		$comentarios = $this->comentariosRepository->findComentariosById($id);
		$message='Comentario ['.$id.'] borrado exitosamente.';
		$comentarios->delete();
		return $message;
	}
}

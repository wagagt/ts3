@extends('app')

@section('content')
<div class="container">
      @include('flash::message')
    <div>
        @include('proyectos.show-fields')
    </div>
</div>
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading row-fluid ">
                    <h3>{!! $proyecto->nombre !!}  ->  Avances</h3>
        </div>
        <div class="panel-body">
            <!--<div class="col-md-6">-->
                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                 <i class="fa fa-comments-o"></i> Agregar Comentarios
                </button>
            <!--</div>-->
            <div>
                @include('proyectos.admin-show-comentarios')
            </div>
        </div>
        <div class="panel-footer">
            Comentarios para proyecto:  {!! $proyecto->nombre !!}
        </div>
    </div>
</div>

    <!-- MODAL ADD-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Agregar Comentario a Proyecto:  <strong>{!! $proyecto->nombre !!}</strong></h4>
          </div>
          <div class="modal-body"> 
            {!! Form::open(['route' => 'comentarios.store']) !!}
                <div class="row">
                    <div class="form-group col-sm-4 col-lg-6">
                     {!! Form::label('fecha', 'Fecha (mm-dd-yy):') !!}
                        {!! Form::input('date', 'fecha', date('m-d-Y'), ['class' => 'form-control', 'id' => 'fecha']) !!}

                    </div>
                <!--- Horas Field --->
                    <div class="form-group col-sm-4 col-lg-6"></div>
                </div>
                
                <!--- Avance Field --->
                <div class="row">
                    <div class="form-group col-sm-4 col-lg-6">
                        {!! Form::label('avance', 'Avance:') !!}
                        {!! Form::text('avance', null, ['class' => 'form-control']) !!}
                    </div>
                <!--- Horas Field --->
                    <div class="form-group col-sm-4 col-lg-6">
                        {!! Form::label('horas', 'Horas:') !!}
                        {!! Form::text('horas', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <!--- Comentario Field --->
                <div class="row">
                    <div class="form-group col-sm-6 col-lg-12">
                        {!! Form::label('comentario', 'Comentario:') !!}
                        {!! Form::textarea('comentario', null, ['class' => 'form-control col-sm-4 col-lg-6', 'size' => '50x5']) !!}
                    </div>
                </div>
                <!--- Id Usuario Field --->
                    {!! Form::hidden('id_usuario', Auth::user()->id) !!} 
                <!--- Id Proyecto Field --->
                    {!! Form::hidden('id_proyecto', $proyecto->id) !!}
                <!--- Id Proyecto Field --->
                    {!! Form::hidden('pathReturn', 'proyecto') !!} 
          </div>
          <div class="modal-footer">
              <!--- Submit Field --->
                <!--<div class="form-group col-sm-12">-->
                <!--    {!! Form::submit('Grabar', ['class' => 'btn btn-primary']) !!}-->
                <!--</div>-->
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Grabar Comentarios</button>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <!-- MODAL ADD-->       
    
    
    <!-- MODAL DELETE -->
    
    <div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"> <p class=></p> <i class="fa fa-trash"></i> Eliminar Comentario:  <strong></strong></h4>
          </div>
          <div class="modal-body"> 
                <!--- Comentario Field --->
                <div class="row">
                    <div class="form-group col-sm-6 col-lg-12">
                        {!! Form::label('comentario', 'Comentario:') !!}
                        {!! Form::textarea('texto_todel', null, ['class' => 'form-control col-sm-4 col-lg-6', 'size' => '50x5', 'id'=>'texto_todel']) !!}
                    </div>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger" id="deleteButton">Eliminar Comentario</button>
          </div>
          {!! Form::hidden('proyecto_id', $proyecto->id, array('id' => 'proyecto_id')) !!}
          {!! Form::hidden('comentario_id_del', '', array('id' => 'comentario_id_del')) !!}
        </div>
      </div>
    </div>
    {!! Form::open(['route' => ['comentarios.destroy', ':COMENTARIO_ID'], 'method' => 'delete', 'id' => 'deleteComment']) !!}
    {!! Form::close() !!}
    <!-- MODAL DELETE--> 
        
@endsection

@section('script')

<script>
$(document).ready(function () {

    $('.btn-danger').click(function (e){
        e.preventDefault();
            var row = $(this).parents('tr');
            var comentario_id = row.data("id");
            texto = $("#comentario_"+comentario_id).text(); // + " || id: "+comentario_id;
           if (confirm('Seguro que desea eliminar el comentario "'+texto+'" ?')) {
            var form = $('#deleteComment');
            var url = form.attr('action').replace(':COMENTARIO_ID', comentario_id);
            var data = form.serialize();
            row.fadeOut();               
            $.post(url, data, function (result) {
               alert(result);
            });
        }
    }); 
});
</script>
@endsection


	
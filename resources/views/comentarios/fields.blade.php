<!--- Avance Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('avance', 'Avance:') !!}
    {!! Form::text('avance', null, ['class' => 'form-control']) !!}
</div>

<!--- Horas Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('horas', 'Horas:') !!}
    {!! Form::text('horas', null, ['class' => 'form-control']) !!}
</div>
<!--- Fecha Field --->
<div class="form-group col-sm-6 col-lg-4">
     {!! Form::label('fecha', 'Fecha (dia-mes-año):') !!}
     <input class="form-control" id="fecha" name="fecha" type="date" 
     value='<?php echo date("Y-m-d", strtotime($comentarios->fecha)); ?>'>
</div>    
<!--- Comentario Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('comentario', 'Comentario:') !!}
    {!! Form::textarea('comentario', null, ['class' => 'form-control', 'size' => '30x5']) !!}
</div>

<!--- Submit Field --->
<div class="form-group col-sm-6">
    {!! Form::submit('Grabar', ['class' => 'btn btn-primary']) !!}
</div>

<div class="form-group col-sm-6">
    <input class="btn btn-danger" type="button" value="Cancelar" id="editBack">
</div>

<!--- Id Usuario Field --->
    {!! Form::hidden('id_usuario', Auth::user()->id) !!} 
    {!! Form::hidden('id_proyecto', Input::old('id_proyecto')) !!}

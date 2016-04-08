@extends('app')

@section('content')
<div class="container">

    @include('common.errors')

    {!! Form::model($comentarios, ['route' => ['comentarios.update', $comentarios->id], 'method' => 'patch']) !!}

        @include('comentarios.fields')

    {!! Form::close() !!}
</div>
@endsection


@section('script')

<script>
$(document).ready(function () {

    $('#editBack').click(function (e){
        e.preventDefault();
        history.back(1);
    }); 
});
</script>
@endsection



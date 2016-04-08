<div class="row-fluid">
    <div class="span12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        
                        <th>Fecha (d/m/a)</th>
                        <th>Horas</th>
                        <th>Avance</th>
                        <th>Profundidad<br>Inicial (pies)</th>
                        <th>Profundidad<br>Final (pies)</th>
                        <th>Comentario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $profundidad_inicial=0;
                        $profundidad_final=0
                    ?>
                    @foreach($comentarios as $comentario)
                    <?php 
                        $profundidad_final=$profundidad_final+$comentario->avance;
                    ?>
                    <tr data-id="{{$comentario->id}}">
                        <td>{{ date('d/m/Y',strtotime($comentario->fecha)) }}</td>
                        <td>{{$comentario->horas}}</td>
                        <td>{{$comentario->avance}}</td>
                        <td>{{$profundidad_inicial}}</td>
                        <td>{{$profundidad_final}}</td>
                        <td id="comentario_{{$comentario->id}}">{{$comentario->comentario}}</td>
                        <td width="100px" style="align:center" >
                            
                                    <a href="/comentarios/{{$comentario->id}}/edit" class="btn btn-warning">
                                        <i class="fa fa-pencil-square-o fa-1x"></i>
                                    </a>
                            
                                    <a id="modalDel" class="btn btn-danger" href="#" style="float:right">
                                        <i class="fa fa-trash fa-1x"></i>
                                    </a>
                            
                        </td>
                    </tr>
                    <?php 
                        $profundidad_inicial=$profundidad_final;
                    ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
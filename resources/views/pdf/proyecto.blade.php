<!DOCTYPE html>
<html>
<head>
	<title>Reporte de proyecto</title>
	<link rel="stylesheet" href="sass/main.css" media="screen" charset="utf-8"/>
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link href="{{ asset('bootstrap/css/pdf.css') }}" rel="stylesheet" type="text/css" />
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta http-equiv="content-type" content="text-html; charset=utf-8">
</head>

<body>
	<header class="clearfix">
		<div class="container">
			<figure>
				<img class="logo" src="" alt="">
			</figure>
			<div class="company-info">
				<h2 class="title">TIERRA SEGURA</h2>
				<span>10 Calle 0-65 zona 14, check Local 9, Guatemala Centroamérica.</span>
				<span class="line"></span>
				<a class="phone" href="tel:602-519-0450">(502) 2366 2956</a>
				<span class="line"></span>
				<a class="email" href="mailto:info@tierrasegura.com">info@tierrasegura.com</a>
			</div>
		</div>
	</header>

	<section>
		<div class="details clearfix">
	        <p class="title-project">PROYECTO: {!! $proyecto->nombre !!}</p>
				
				<table cellpadding="1" cellspacing="1" >
					<tr >
						<td>
							Profundidad: {!! $proyecto->profundidad !!} (pies)
						</td>
						<td>
							Perforado: {!! $proyecto->perforado !!}
						</td>
					</tr>
					<tr >
						<td>
							Máquina: {!! $proyecto->maquina !!}
						</td>
						<td>
							Método: {!! $proyecto->metodo !!}
						</td>
					</tr>
					<tr >
						<td>
							Estado: {!! $proyecto->estado->descripcion !!}
						</td>
						<td>
						</td>
					</tr>
				</table>
				
		</div>
		<div class="container">
			<div>
				<table>
					<tbody class="head">
						<tr>
						    <th colspan=2><div align="left">   Fecha : Comentario</div></th>
							<th width="8%"><div>Horas</div></th>
							<th width="8%"><div>Inicio</div></th>
							<th width="8%"><div>Avance</div></th>
							<th width="8%"><div>Final</div></th>
						</tr>
					</tbody>
					<tbody class="body">
					  <?php
                            $profundidad_inicial=0;
                            $profundidad_final=0
                        ?>
					    @foreach($comentarios as $comentario)
					    <?php 
                            $profundidad_final=$profundidad_final+$comentario->avance;
                        ?>
						<tr>
						    <td colspan=2 class="desc">
						    	<div style="align:left"> 
							    	<div style=" font-weight: 900;align:left">
							    		{{ date('d/m/Y',strtotime($comentario->fecha)) }} : 
							    	</div>
							    	<div style="align:left"> 
							    		{{$comentario->comentario}}
							    	</div>
							    </div>
						    	
						    </td>
							<td class="qty">{{$comentario->horas}}h</td>
							<td class="qty">{{$profundidad_inicial}}'</td>
							<td class="qty">{{$comentario->avance}}'</td>
							<td class="total">{{$profundidad_final}}'</td>
						</tr>
						<?php 
                            $profundidad_inicial=$profundidad_final;
                        ?>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="no-break">
				<table class="grand-total">
					<tbody>
						<tr>
							<td class="grand-total" colspan="5"><div><span> TOTAL:</span>{{$profundidad_final}} (pies)</div></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</section>

	<footer>
		<div class="container">
			<div class="thanks">Gracias!</div>
			<div class="notice">
				<div>NOTA:</div>
				<div>Reporte generado el : <?php echo date('d/m/Y');?></div>
			</div>
			<div class="end">SISTEMA DE PROYECTOS TIERRASEGURA.COM</div>
		</div>
	</footer>

</body>

</html>

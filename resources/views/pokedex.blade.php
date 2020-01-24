@extends('layouts.pokedexLayout')

@section('content')
<!-- SITE WRAP -->
<div class="site-wrap" id="header">
    <!-- NAVBAR MORADA -->
    <nav class="navbar navbar-expand-lg bg-purple">
		<ul class="navbar-nav w-100 justify-content-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mt-4 mb-4">                    
                    </div>
                </div>
            </div>
        </ul>
    </nav>
    <!-- END NAVBAR -->
    <!-- TITULO MODYO POKEDEX -->
    <section class="sectionTitulo">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-12 text-center">
                    <h1 class="mb-2 mt-5">Modyo - Pokedex</h1>
                </div>
            </div>
        </div>
    </section>
    <!-- END TITULO MODYO POKEDEX-->

    <!-- INICIO CONSUMO API POKEAPI-->
    <section class="sectionPokemons">
        <div class="container">
            <div class="row mb-3">
                <!--        
                        CREO UN ARRAY CON LOS TIPOS DE 
                        POKEMONES ESTO FACILITARÁ 
                        EL TRABAJO A LA  HORA DE 
                        ESTABLECER UN BACKGROUND
                        DE ACUERDO AL TIPO DEL 
                        POKEMON
                -->
                <?php
                    $valoresTipo = array(
                        'normal' => 'rgb(168, 168, 120)',
                        'fighting' => 'rgb(192, 48, 40)',
                        'flying' => 'rgb(168, 144, 240)',
                        'poison' => 'rgb(160, 48, 160)',
                        'ground' => 'rgb(224, 192, 104)',
                        'rock' => 'rgb(184, 160, 56)',
                        'bug' => 'rgb(168, 184, 32)',
                        'ghost' => 'rgb(112, 88, 152)',
                        'steel' => 'rgb(184, 184, 208)',
                        'fire' => 'rgb(240, 128, 48)',
                        'water' => 'rgb(104, 144, 240)',
                        'grass' => 'rgb(120, 200, 80)',
                        'electric' => 'rgb(248, 208, 48)',
                        'psychic' => 'rgb(248, 88, 136)',
                        'ice' => 'rgb(152, 216, 216)',
                        'dragon' => 'rgb(112, 56, 248)',
                        'dark' => 'rgb(112, 88, 72)',
                        'fairy' => 'rgb(238, 153, 172)'
                    );
                ?>
                <!-- RECORRO LA DATA OBTENIDA DEL CONTROLLER -->           
                @foreach ($pokeData as $pokemon)
                    <div class="col-sm-3 mb-3">
                        <?php
                            if(count($pokemon->types) <= 1){
                            ?>
                                <!--    
                                        SI POSEE SÓLO UN TIPO, 
                                        SE SETEA SU BACKGROUND 
                                        CORRESPONDIENTE EN LOS
                                        LINEAR GRADIENT
                                -->
                                <div class="card" style="background: rgba(0, 0, 0, 0) linear-gradient(90deg, {{$valoresTipo[ $pokemon->types[0]->type->name ]}} 50%, {{$valoresTipo[ $pokemon->types[0]->type->name ]}} 50%)"
                                    data-clickable="true" data-target="#{{$pokemon->name}}">
                            <?php
                            }
                            else
                            {
                                $algo = null;
                                foreach(array_reverse($pokemon->types) as $tipos)
                                {
                                    if($algo === null)
                                        $algo = 'background: rgba(0, 0, 0, 0) linear-gradient(90deg, '. $valoresTipo[ $tipos->type->name ] .' 50%';
                                    else{
                                        $algo = $algo . ', ' . $valoresTipo[ $tipos->type->name ] .' 50% )'
                                        ?>
                                        <!-- 
                                            SI POSEE MÁS DE UN TIPO,
                                            SE VA CREANDO UNA STRING
                                            CON LOS BACKGROUNDS
                                            CORRESPONDIENTES
                                            PARA CADA TIPO
                                            DEL POKEMON
                                         -->
                                            <div class="card" style="{{$algo}}" data-clickable="true" data-target="#{{$pokemon->name}}">
                                        <?php
                                    }
                                }
                            }
                                
                        ?>
                            <!-- 
                                SE GENERA POR CADA POKEMON
                                UNA CARD CON LA FOTO
                                DE CADA UNO Y SU
                                NOMBRE

                            -->
                            <div class="card-body">
                                <img src="{{ $pokemon->sprites->front_default }}" class="spritePoke mx-auto" alt="100%x320" data-holder-rendered="true">
                            </div>

                            <!-- 
                                COMO HICIMOS QUE LA CARD SEA
                                CLICKEABLE, AL MOMENTO DE
                                HACERLO, EJECTUARÁ EL 
                                MODAL CON TODA SU
                                INFORMACIÓN.

                            -->

                            <div class="card-footer text-center">
                                <a data-toggle="modal" data-target="#{{$pokemon->name}}"><span class="stretched-link itemFooter">{{ $pokemon->name }}</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="{{ $pokemon->name }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-5 align-self-center">
                                            <img src="{{ $pokemon->sprites->front_default }}" class="spritePoke mx-auto" alt="100%x320" data-holder-rendered="true">
                                        </div>
                                        <div class="col-md-7">
                                            @foreach(array_reverse($pokemon->stats) as $estadistica)
                                                <div class="progress mb-2" style="height: 20px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated text-left bg-secondary" role="progressbar" 
                                                    style="width: {{$estadistica->base_stat*0.8}}%; text-transform: capitalize;" 
                                                    aria-valuenow="{{$estadistica->base_stat}}" 
                                                    aria-valuemin="0" 
                                                    aria-valuemax="200">&nbsp&nbsp&nbsp{{$estadistica->stat->name}}: {{$estadistica->base_stat}}</div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-lg-10 mb-2 mt-2">
                                            <?php
                                                $datos = Helper::getPokeData($pokemon->species->url);
                                                foreach($datos->flavor_text_entries as $desc)
                                                {

                                                    if($desc->language->name == 'en'){
                                                        $descripcion = $desc->flavor_text;
                                                        ?>
                                                            <i><blockquote>&ldquo;<span>{{$descripcion}}</span>&ldquo;</blockquote></i>
                                                        <?php
                                                        break;
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mt-2 bg-secondary">
                                            <h4 class="mb-2 mt-2 textDesc" style="color:#ffff;">{{$pokemon->name}}'s Profile</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mt-2">
                                            <span><strong>Types: </strong></span>
                                            @foreach($pokemon->types as $tipos)                                            
                                                <span class="textDesc">{{$tipos->type->name}}</span>
                                            @endforeach
                                            <br>
                                            <span><strong>Height: </strong></span>                                        
                                                <span class="textDesc">{{$pokemon->height/10}} m</span>
                                            <br>
                                            <span><strong>Weight: </strong></span>                                    
                                                <span class="textDesc">{{$pokemon->weight/10}} kg</span>
                                            <br>
                                            <span><strong>Abilities: </strong></span>                                    
                                            @foreach($pokemon->abilities as $ability)                                            
                                                <span class="textDesc">{{$ability->ability->name}}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mt-2 bg-secondary">
                                            <h4 class="mb-2 mt-2 textDesc" style="color:#ffff;">{{$pokemon->name}}'s Evolutions</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mt-2">
                                            <?php
                                                $cadenaEvolucion = Helper::getPokeData($datos->evolution_chain->url);
                                                if(isset($cadenaEvolucion->chain->evolves_to[0])){
                                                    if(isset($cadenaEvolucion->chain->evolves_to[0]->evolves_to[0])){
                                                        ?>
                                                            <span class="textDesc"><strong>
                                                            {{$cadenaEvolucion->chain->species->name}} -> {{$cadenaEvolucion->chain->evolves_to[0]->species->name}} ->
                                                            {{$cadenaEvolucion->chain->evolves_to[0]->evolves_to[0]->species->name}}
                                                            </strong></span>
                                                        <?php
                                                    }else{
                                                        ?>
                                                            <span class="textDesc"><strong>
                                                            {{$cadenaEvolucion->chain->species->name}} -> {{$cadenaEvolucion->chain->evolves_to[0]->species->name}}
                                                            </strong></span>
                                                        <?php
                                                    }                                                  
                                                }else{
                                                ?>
                                                    <span><strong>It has no evolutions</strong></span>
                                                <?php
                                                }
                                            ?>                                         
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div> 
                @endforeach                
            </div>
            <div class="row justify-content-center">
                <div class="col-mg-5">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <!-- BOTÓN RETROCEDER -->
                            <?php
                                if(request()->route('id') == null){
                                    ?>
                                    <!-- Desactivamos el botón si está en el inicio -->
                                    <li class="page-item disabled px-3">                            
                                        <a class="page-link" href="#" aria-disabled=true>
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <?php
                                }else{
                                    $num = (int)request()->route('id');
                                    $num -= 20;
                                    $id = strval($num);
                                    ?>
                                    <!-- Activamos el botón si está en alguna pagina -->
                                        <li class="page-item px-3"> 
                                            <a class="page-link" href="{{ action('Controller@getAllPokemonOffset', $id)}}" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    <?php
                                }
                            ?>
                            <!-- BOTÓN RETROCEDER -->

                            <!-- BOTÓN AVANZAR -->
                            <?php
                                if(request()->route('id') == 960){
                                    ?>
                                    <!-- Desactivamos el botón si está en la ultima página -->
                                        <li class="page-item disabled px-3">                            
                                            <a class="page-link" href="#" aria-disabled=true>
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    <?php
                                }else{
                                    $num = (int)request()->route('id');
                                    $num += 20;
                                    $id = strval($num);
                                    ?>
                                    <!-- Si no está en la última página, lo activamos -->
                                        <li class="page-item px-3">
                                            <a class="page-link" href="{{ action('Controller@getAllPokemonOffset', $id)}}" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    <?php
                                }
                            ?>
                            <!-- BOTÓN AVANZAR --> 
                        </ul>
                    </nav>                
                </div>
            </div>
        </div>
    </section>
    <!-- FOOTER -->
    <section class="sectionFooter mt-3">
        <footer class="page-footer font-small bg-purple pt-4">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <p class="itemFooter text-center">Pokedex Web - Franco Riveros - Desafio Modyo</p>
                    </div>
                </div>
            </div>
            <div class="footer-copyright text-center py-3 itemFooter">&copy 2020 Copyright:
                <a> Nintendo, GameFreak and ThePokemonCompany</a>
            </div>
        </footer>
    </section>
    <!-- FOOTER -->
</div>
<!-- END SITE WRAP -->
@endsection

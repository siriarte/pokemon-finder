<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Buscador de Pokemons</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Scripts for Pokemon Finder -->
        <script src="{{ asset('js/pokemon-finder.js') }}" defer></script>
       
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Styles for Pokemon Finder-->
        <link href="{{ asset('css/pokemon-finder.css') }}" rel="stylesheet">
    </head>
    <body>
		<div class="container ml-5 mr-5">
            <div style="margin-top: 15px; margin-bottom:30px;">
                <h1  class="text-left">Pokemon Finder</h1>
                <h4  class="text-left">El que quiere pokemons que los busque.</h4>
            </div>

            <div>
                <form class="card card-sm">
                    <div class="card-body row no-gutters align-items-center">
                        <div class="col-auto">
                            <i class="fas fa-search h4 text-body"></i>
                        </div>
                        <!--end of col-->
                        <div class="col">
                            <input id="input_search" name="input_search" class="form-control form-control-lg form-control-borderless" type="search" placeholder="Ingrese el nombre a buscar" required>
                        </div>
                        <!--end of col-->
                        <div class="col-auto">
                            <button id="btn_search" class="btn btn-lg btn-success ml-4">Buscar</button>
                        </div>
                        <!--end of col-->
                    </div>
                </form>
            </div>
            <div id="result" style="margin-top: 30px; margin-bottom:100px;">
                <h3 id="table_result_title"></h3>
                <table class="table table-borderless" id="table_result">
                    <thead id="table_result_head"></thead>
                    <tbody id="table_result_body"></tbody>
                </table>
            </div>
        </div>

        <div class="container ml-5 mr-5 footer_personal" id="footer">
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <p>Desarrollado por Santiago Iriarte.</p>
                </div>
                <div class="col-md-6">
                    <button class="link-repo" onClick='window.open("https://github.com/siriarte/pokemon-finder", "_blank");'>Link al repositorio</button>
                </div>
            </div>
        </div>

        <div class="modal" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Espere por favor...</h4>
                    </div>
                    <div class="modal-body">
                        <div class="progress">
                          <div class="progress-bar progress-bar-success progress-bar-striped progress-bar-animated active" role="progressbar"
                          aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%; height: 40px">
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>

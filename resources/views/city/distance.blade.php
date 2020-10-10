@extends('layout.layout')
@section('conteudo')
<div class="col-6 d-flex flex-row justify-content-center">
<div class="card">
    <form class="card-body">
        <div class="form-group">
            <label for="cityName">Cidade Inicial</label>
            <select class="custom-select" id="initialCity">
                @foreach ($cities as $city)
                    <option value="{{$city[0]}}">{{$city[0]}}</option>
                @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="cityLat">Cidade Final</label>
            <select class="custom-select" id="finalCity">
                @foreach ($cities as $city)
                    <option value="{{$city[0]}}">{{$city[0]}}</option>
                @endforeach
            </select>
          </div>
          <button type="button" class="btn btn-primary" id="btnSubmit">Cadastrar</button>
          <button type="reset" class="btn btn-danger" id="btnReset">Limpar</button>
    </form>
    <div class="alert" id="alert"></div>
    <script type="text/javascript">
        $("#btnSubmit").click(sendForm);
        function sendForm(){
            let finalCity = $("#finalCity").val();
            let initialCity = $("#initialCity").val();
            if(!initialCity || !finalCity){alert('Campo Em Branco, Verifique os campos'); return;}
            $.ajax({
                url: "distance",
                method: "POST",
                data: { _token: "{{ csrf_token() }}", initialCity, finalCity},
                beforeSend : function(){
                    $("#alert").html("ENVIANDO...");
                    $("#alert").show();
                }
            }).done(function(resposta) {
                $("#alert").html(resposta.message);
            }).fail(function(jqXHR, textStatus ) {
                if(jqXHR.status == 422){
                    $("#alert").html("Campos Invalidos...");
                } else {
                    $("#alert").html("Um erro ocorreu...");
                }
                $("#alert").hide();
            });
        }
    </script>
</div>
</div>
@endsection

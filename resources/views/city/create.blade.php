@extends('layout.layout')
@section('conteudo')
<div class="col-6 d-flex flex-row justify-content-center">
<div class="card">
    <form class="card-body">
        <div class="form-group">
            <label for="cityName">Nome da Cidade</label>
            <input type="text" class="form-control" id="cityName" required>
          </div>
          <div class="form-group">
            <label for="cityLat">Latitude</label>
            <input type="text" class="form-control" id="cityLat" required>
          </div>
          <div class="form-group">
            <label for="cityLog">Longitude</label>
            <input type="text" class="form-control" id="cityLog" required>
          </div>
          <button type="button" class="btn btn-primary" id="btnSubmit">Cadastrar</button>
          <button type="reset" class="btn btn-danger" id="btnReset">Limpar</button>
    </form>
    <div class="alert" id="alert"></div>
    <script type="text/javascript">
        $("#btnSubmit").click(sendForm);
        function sendForm(){
            let name = $("#cityName").val().trim();
            let lat = $("#cityLat").val().trim();
            let log = $("#cityLog").val().trim();
            if(!name || !lat || !log){alert('Campo Em Branco, Verifique os campos'); return;}
            $.ajax({
                url: "create",
                method: "POST",
                data: { _token: "{{ csrf_token() }}", name, lat, log},
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

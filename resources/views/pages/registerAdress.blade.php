@extends('layouts.master')
@section('content')
    @include('layouts.inc.nav')

    <section class="container-fluid">
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-6 col-md-6">
                    <form class="form-container">

                        @csrf
                        <h2 class="text-center bg-dark p-2 text-white">Cadastrar Endereço</h2>
                        <input type="hidden" name="user_id" id="user_id" value="{{ $id }}">
                        <input type="hidden" id="url" name="url"
                            value="{{ isset($endereco['logradouro']) ? '/update_adress' : '/save_adress' }}">

                        <div class="form-group">
                            <label for="logradouro">Logradouro</label>
                            <input type="text" name="logradouro" class="form-control" id="logradouro"
                                placeholder="Seu Logradouro"
                                value="{{ isset($endereco['logradouro']) ? $endereco['logradouro'] : '' }}">
                        </div>

                        <div class="form-group">
                            <label for="numero">Número</label>
                            <input type="text" name="numero" class="form-control" id="numero" placeholder="Número"
                                value="{{ isset($endereco['numero']) ? $endereco['numero'] : '' }}">
                        </div>

                        <div class="form-group">
                            <label for="bairro">Bairro</label>
                            <input type="text" class="form-control" name="bairro" id="bairro" placeholder="Bairro"
                                value="{{ isset($endereco['bairro']) ? $endereco['bairro'] : '' }}">
                        </div>

                        <div class="form-group">
                            <label for="complemento">Complemento</label>
                            <input type="text" name="complemento" class="form-control" id="complemento"
                                placeholder="Complemento"
                                value="{{ isset($endereco['complemento']) ? $endereco['complemento'] : '' }}">
                        </div>

                        <div class="form-group">
                            <label for="cep">CEP</label>
                            <input type="text" name="cep" class="form-control" id="cep" placeholder="CEP"
                                value="{{ isset($endereco['cep']) ? $endereco['cep'] : '' }}">
                        </div>

                        <button id="save_form" type="submit" class="btn btn-dark btn-block save_btn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('javascript')
    <script>
        $(document).ready(function() {
            $('#save_form').on('click', function(e) {
                e.preventDefault();
                var logradouro = $("#logradouro").val();
                var numero = $("#numero").val();
                var bairro = $("#bairro").val();
                var complemento = $("#complemento").val();
                var cep = $("#cep").val();
                var url = $("#url").val();
                var user_id = $("#user_id").val();

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        '_token': '<?= csrf_token() ?>',
                        logradouro: logradouro,
                        numero: numero,
                        bairro: bairro,
                        complemento: complemento,
                        cep: cep,
                        user_id: user_id
                    },
                    success: function(data) {
                        if (data.exists) {
                            $('#notifDiv').fadeIn();
                            $('#notifDiv').css('background', 'red');
                            $('#notifDiv').text('Email already exists');
                            setTimeout(() => {
                                $('#notifDiv').fadeOut();
                            }, 3000);
                        } else if (data.success) {
                            $('#notifDiv').fadeIn();
                            $('#notifDiv').css('background', 'green');
                            $('#notifDiv').text(data.success);
                            setTimeout(() => {
                                $('#notifDiv').fadeOut();
                            }, 3000);
                            // $('[name="logradouro"]').val('');
                            // $('[name="numero"]').val('');
                            // $('[name="bairro"]').val('');
                            // $('[name="complemento"]').val('');
                            // $('[name="cep"]').val('');
                        } else {
                            $('#notifDiv').fadeIn();
                            $('#notifDiv').css('background', 'red');
                            $('#notifDiv').text('An error occured. Please try later');
                            setTimeout(() => {
                                $('#notifDiv').fadeOut();
                            }, 3000);
                        }
                        $(this).text('Save');
                        $(this).removeAttr('disabled');
                    }.bind($(this))

                });

            });
        });
    </script>
@endpush

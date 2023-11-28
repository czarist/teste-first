@extends('layouts.master')
@section('content')
    @include('layouts.inc.nav')

    <section>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h4 class="text-center">Atualizar Meus Dados</h4>
                        </div>
                        <div class="card-body">
                            <form>
                                @csrf
                                <input type="hidden" name="id" id="id" value="{{ $user['id'] }}">
                                <div class="form-group">
                                    <label for="fname">Primeiro Nome</label>
                                    <input disabled type="text" name="fname" id="fname" class="form-control"
                                        placeholder="{{ isset($user['fname']) ? $user['fname'] : '' }}">
                                </div>

                                <div class="form-group">
                                    <label for="lname">Ultimo Nome</label>
                                    <input disabled type="text" name="lname" id="lname" class="form-control"
                                        placeholder="{{ isset($user['lname']) ? $user['lname'] : '' }}">
                                </div>

                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="E-mail" value="{{ isset($user['email']) ? $user['email'] : '' }}">
                                </div>

                                <div class="form-group">
                                    <label for="email">Telefone</label>
                                    <input type="phone" name="phone" id="phone" class="form-control"
                                        placeholder="Telefone" value="{{ isset($user['phone']) ? $user['phone'] : '' }}">
                                </div>

                                <div class="form-group">
                                    <label for="password">Senha</label>
                                    <input type="password" id="password" name="password" class="form-control"
                                        placeholder="**************************">
                                </div>

                                <button type="submit" class="btn btn-dark btn-block" id="save_form">ATUALIZAR
                                    DADOS</button>
                            </form>
                        </div>
                    </div>
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
                var email = $("#email").val();
                var phone = $("#phone").val();
                var password = $("#password").val();
                var id = $("#id").val()

                $.ajax({
                    type: 'post',
                    url: '/update_register',
                    data: {
                        '_token': '<?= csrf_token() ?>',
                        email: email,
                        phone: phone,
                        password: password,
                        id: id
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
                            // $('[name="email"]').val('');
                            // $('[name="password"]').val('');
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

@extends('layouts.master')
@section('content')
    <section>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h4 class="text-center">Registro de Conta</h4>
                        </div>
                        <div class="card-body">
                            <form>
                                @csrf
                                <div class="form-group">
                                    <label for="fname">Primeiro Nome</label>
                                    <input type="text" name="fname" id="fname" class="form-control"
                                        placeholder="Primeiro Nome">
                                </div>

                                <div class="form-group">
                                    <label for="lname">Ultimo Nome</label>
                                    <input type="text" name="lname" id="lname" class="form-control"
                                        placeholder="Ultimo Nome">
                                </div>

                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="E-mail">
                                </div>

                                <div class="form-group">
                                    <label for="email">Telefone</label>
                                    <input type="phone" name="phone" id="phone" class="form-control"
                                        placeholder="Telefone">
                                </div>

                                <div class="form-group">
                                    <label for="password">Senha</label>
                                    <input type="password" id="password" name="password" class="form-control"
                                        placeholder="Senha">
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar Senha</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-control" placeholder="Confirmar Senha">
                                </div>

                                <button type="submit" class="btn btn-dark btn-block" id="save_form">Registrar</button>
                            </form>
                            <a class="btn btn-dark btn-block mt-5" href="{{ url('login') }}">Já Tenho Cadastro</a>

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
                let csrfToken = $('meta[name="csrf-token"]').attr('content');

                e.preventDefault();
                const fname = $("#fname").val();
                const lname = $("#lname").val();
                const email = $("#email").val();
                const phone = $("#phone").val();
                const password = $("#password").val();
                const password_confirmation = $("#password_confirmation").val();

                if (password !== password_confirmation) {
                    showError('As senhas não coincidem');
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: 'api/save_register',
                    data: {
                        '_token': csrfToken,
                        email: email,
                        fname: fname,
                        lname: lname,
                        phone: phone,
                        password: password
                    },
                    success: function(data) {
                        if (data.errors) {
                            for (const key in data.errors) {
                                showError(data.errors[key][0]);
                            }
                        } else if (data.exists) {
                            showError('Email already exists');
                        } else if (data.success) {
                            showSuccess(data.success);
                            $('[name="fname"]').val('');
                            $('[name="lname"]').val('');
                            $('[name="email"]').val('');
                            $('[name="password"]').val('');
                            $('[name="password_confirmation"]').val('');
                            window.location.replace('/login');
                        } else {
                            showError('An error occurred. Please try later');
                        }
                        $(this).text('Save');
                        $(this).removeAttr('disabled');
                    }.bind($(this))
                });
            });

            function showError(message) {
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                $('#notifDiv').text(message);
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
            }

            function showSuccess(message) {
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'green');
                $('#notifDiv').text(message);
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
            }
        });
    </script>
@endpush

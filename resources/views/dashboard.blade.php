@extends('layouts.master')
@section('content')
    @include('layouts.inc.nav')


    <section class="container-fluid">
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-12 center col-sm-6 col-md-6">
                    <h1>Bem Vindo</h1>
                </div>
                <table class="table mt-5">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Nome</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{ $user['id'] }}</th>
                                <td>{{ $user['fname'] }} {{ $user['lname'] }}</td>
                                <td>{{ $user['email'] }}</td>
                                <td>{{ $user['phone'] }}</td>
                                <td>
                                    @if (Auth::user()->toArray()['role'] == 4)
                                        <button type="button" class="btn btn-primary"
                                            onclick="window.location.replace('{{ url('dados') }}/{{ $user['id'] }}');">
                                            <i class="fas fa-edit white"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger deletUser" value="{{ $user['id'] }}">
                                            <i class="fa fa-trash white" aria-hidden="true"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirmação de Exclusão</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Tem certeza de que deseja excluir este usuário?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Excluir</button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
@endsection

@push('javascript')
    <script>
        window.addEventListener('load', function() {
            function delete_user(id) {
                $('#confirmDeleteModal').modal('show');

                $('#confirmDeleteButton').on('click', function() {
                    $.ajax({
                        type: 'delete',
                        url: 'delete_user',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            id: id,
                        },
                        success: function(data) {
                            if (data.error) {
                                $('#notifDiv').fadeIn();
                                $('#notifDiv').css('background', 'red');
                                $('#notifDiv').text('Erro ao excluir');
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
                                location.reload();
                            } else {
                                $('#notifDiv').fadeIn();
                                $('#notifDiv').css('background', 'red');
                                $('#notifDiv').text('An error occurred. Please try later');
                                setTimeout(() => {
                                    $('#notifDiv').fadeOut();
                                }, 3000);
                            }
                            $(this).text('Save');
                            $(this).removeAttr('disabled');
                        }.bind($(this))
                    });
                });
            };

            let deletUser = document.getElementsByClassName('deletUser')

            for (let i = 0; i < deletUser.length; ++i) {
                deletUser[i].onclick = function() {
                    delete_user(this.value);
                }
            }
        });
    </script>
@endpush

@extends('layout')
@section('title', 'User Manajemen - Family Bakery')
@section('content')
    <div class="container py-3">
        <div class="row">
            <div class="col-lg-12 ">
                <div class="pull-right mb-3">
                    @can('user-create')
                        <a class="btn btn-sm btn-primary" href="/users/create"> <i class="fa fa-plus" aria-hidden="true"></i> Create
                            New User</a>
                    @endcan
                </div>
            </div>
        </div>


        <table class="table table-hover table-striped" id="dataTable">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Jabatan</th>
                    <th>Tanggal ditambahkan</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>

                        <td>
                            @if (!empty($user->getRoleNames()))
                                @foreach ($user->getRoleNames() as $v)
                                    <label class="badge-md badge-success text-dark">{{ $v }}</label>
                                @endforeach
                            @endif
                        </td>
                        <td>{{$user->created_at->isoFormat('dddd, D MMMM Y')}}</td>
                        <td>

                            @can('user-edit')
                                <a class="btn btn-md btn-primary" href="/users/{{ $user->id }}/edit">Edit</a>
                            @endcan
                            @can('user-delete')
                                <form action="/users/{{ $user->id }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-md btn-danger">Delete</button>
                                </form>
                            @endcan

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@endsection
@include('partials.scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            language: {
                paginate: {
                    previous: '<span class="fa fa-chevron-left"></span>',
                    next: '<span class="fa fa-chevron-right"></span>' // or '→'

                }
            }
        });
    });
</script>

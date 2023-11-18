@extends('layout')
@section('title', 'Role Manajemen - Family Bakery')
@section('content')
    <div class="container p-4">
        <div class="row">
            <div class="col-lg-12 my-3">

                <div class="pull-right">
                    @can('role-create')
                        <a class="btn btn-sm btn-primary py-2" href="{{ route('roles.create') }}"> <i class="fa fa-plus"
                                aria-hidden="true"></i> Create New Role</a>
                    @endcan
                </div>
            </div>
        </div>



        <table class="table table-striped table-hovered table-bordered" id="dataTable">
            <thead class="table-dark">
                <th>No</th>
                <th>Name</th>
                <th width="280px">Action</th>

            </thead>
            <tbody>
                @foreach ($roles as $key => $role)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div style="font-weight: 900;">{{ $role->name }} </div>
                        </td>
                        <td>
                            @can('role-edit')
                                <a class="btn btn-sm btn-primary" href="{{ route('roles.edit', $role->id) }}"> <i
                                        class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                            @endcan
                            @can('role-delete')
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
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

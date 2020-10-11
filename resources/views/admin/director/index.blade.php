@extends('admin.app')

@section('title')
{{-- Getting $pageTitle from BaseController setPageTitle()--}}
{{ $pageTitle }}
@endsection

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-podcast"></i>&nbsp;{{ $pageTitle }}</h1>
        <p>{{ $subTitle }}</p>
    </div>
    <a href="{{ route('admin.board.directors.create') }}" class="btn btn-primary pull-right">Add Directors</a>
</div>
@include('admin.partials.flash')
<div class="row">
    <div class="col-md-12 mx-auto">
        <div class="tile">
            <div class="tile-body">
                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr>
                            <th class="text-center"> # </th>
                            <th class="text-center"> Name </th>
                            <th class="text-center"> Phone </th>
                            <th class="text-center"> Email</th>
                            <th class="text-center"> Position</th>
                            <th class="text-center"> Discount Slab (%)</th>
                            <th style="min-width: 50px;" class="text-center text-danger"><i class="fa fa-bolt"> </i>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($directors as $director)
                        <tr>
                            <td class="text-center">{{ $loop->index + 1  }}</td>
                            <td class="text-center">{{ $director->name }}</td>
                            <td class="text-center">{{ $director->mobile }}</td>
                            <td class="text-center">{{ $director->email }}</td>
                            <td class="text-center">{{ $director->designation }}</td>
                            <td class="text-center">{{ $director->discount_slab_percentage }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Second group">
                                    <a href="{{ route('admin.board.directors.edit', $director->id) }}"
                                        class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <a href="{{ route('admin.board.directors.delete', $director->id) }}"
                                        class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
{{-- we need to add  @stack('scripts') in the app.blade.php for the following scripts --}}
@push('scripts')
<script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript">
    $('#sampleTable').DataTable();
    // to disable anchor link.
    a.disabled {
        pointer-events: none;
        cursor: default;
    }
</script>
@endpush
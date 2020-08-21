@extends('admin.app')
@section('title'){{ $pageTitle }}@endsection
@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-th"></i> {{ $pageTitle }} - {{ $subTitle }}</h1>
    </div>
</div>
@include('admin.partials.flash')
<div class="row user">
    <div class="col-md-3">
        <div class="tile p-0">
            @include('admin.ingredients.includes.sidebar')
        </div>
    </div>
    <div class="col-md-9">
        <div class="tile">
            <div>
                <h3>Edit the damage ingredient details</h3>
            </div>
            <hr>
            <div class="tile-body mt-5">
                <form action="{{ route('admin.ingredient.damage.update') }}" method="POST" role="form">
                    @csrf
                    <div class="tile-body">
                        <input type="hidden" name="damage_id" value="{{ $damage->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">Ingredient Name</label>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text"
                                        placeholder="Enter Ingredient name" id="name" name="name"
                                        value="{{ old('name', $damage->name) }}" />
                                    <div class="invalid-feedback active">
                                        <i class="fa fa-exclamation-circle fa-fw"></i> @error('name')
                                        <span>{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="quantity">Quantity</label>
                                    <input class="form-control @error('quantity') is-invalid @enderror" type="text"
                                        placeholder="Enter Quantity" id="quantity" name="quantity"
                                        value="{{ old('quantity',  $damage->quantity) }}" />
                                    <div class="invalid-feedback active">
                                        <i class="fa fa-exclamation-circle fa-fw"></i> @error('quantity')
                                        <span>{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pb-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="unit">Measurement Unit</label>
                                    <select name="unit" id="unit" class="form-control">
                                        <option></option>
                                        @if($ingredient->measurement_unit == $ingredient->smallest_unit)
                                        <option value={{ $ingredient->measurement_unit }} selected>
                                            {{ $ingredient->measurement_unit }}</option>
                                        @elseif($ingredient->smallest_unit == $damage->unit)
                                        <option value={{ $ingredient->smallest_unit }} selected>
                                            {{ $ingredient->smallest_unit }}</option>
                                        <option value={{ $ingredient->measurement_unit }}>
                                            {{ $ingredient->measurement_unit }}
                                            @elseif($ingredient->measurement_unit == $damage->unit)
                                        <option value={{ $ingredient->measurement_unit }} selected>
                                            {{ $ingredient->measurement_unit }}</option>
                                        <option value={{ $ingredient->smallest_unit }}>{{ $ingredient->smallest_unit }}
                                        </option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="reported_date">Report Date</label>
                                    <input type="text" class="form-control datetimepicker" name="reported_date"
                                        value="{{ \Carbon\Carbon::parse($damage->reported_date)->format('d-m-Y') }}"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tile-footer">
                        <div class="row d-print-none mt-2">
                            <div class="col-12 text-right">
                                <button class="btn btn-success" type="submit"><i
                                        class="fa fa-fw fa-lg fa-check-circle"></i>Update
                                    Damage Ingredient</button>
                                <a class="btn btn-danger"
                                    href="{{ route('admin.ingredient.damage.index', $ingredient->id) }}"><i
                                        class="fa fa-fw fa-lg fa-arrow-left"></i>Go Back</a>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
    $('.datetimepicker').datetimepicker({
        timepicker:false,
        datepicker:true,        
        format: 'd-m-Y',              
    });
    $(".datetimepicker").attr("autocomplete", "off");

    $('#unit').select2({
                placeholder: "Select an measurement Unit",              
                multiple: false, 
                minimumResultsForSearch: -1,                        
             });

    });
</script>
@endpush
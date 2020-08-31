@extends('admin.app')
@section('title'){{ $pageTitle }}@endsection
@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-modx"></i> {{ $pageTitle }} - {{ $subTitle }}</h1>
    </div>
</div>
@include('admin.partials.flash')
<div class="row user">
    <div class="col-md-3">
        <div class="tile p-0">
            @include('admin.recipes.includes.sidebar')
        </div>
    </div>
    <div class="col-md-9">
        <div class="tile">
            <h3 class="tile-title">Edit Ingredient : {{ $recipe->product->name }}</h3>
            <hr>
            <form action="{{ route('admin.recipe.ingredient.update') }}" method="POST" role="form">
                @csrf
                <div class="tile-body">
                    <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">
                    <input type="hidden" name="recipeIngredient_id" value="{{ $recipeIngredient->id }}">
                    <div class="row">
                        <div class="col-md-7 mx-auto">
                            <div class="form-group">
                                <label class="control-label" for="ingredient_name">Ingredient Name</label>
                                <select name="ingredient_name" id="ingredient_id"
                                    class="form-control @error('ingredient_name') is-invalid @enderror">
                                    <option></option>
                                    @foreach(App\Models\Ingredient::all() as $ingredient)
                                    <option value={{ $ingredient->id }}
                                        {{ $ingredient->id == $recipeIngredient->ingredient_id ? 'selected' : ''}}>
                                        {{ $ingredient->name }}</option>
                                    @endforeach
                                </select>
                                @error('ingredient_name') {{ $message }}@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7 mx-auto">
                            <div class="form-group">
                                <label class="control-label" for="measurement_unit">Measurement Unit</label>
                                <select name="measurement_unit" id="measure_unit"
                                    class="form-control @error('measurement_unit') is-invalid @enderror">
                                    <option></option>
                                    @foreach(App\Models\Unit::select('smallest_measurement_unit')->distinct()->get() as
                                    $unit)
                                    <option value={{ $unit->smallest_measurement_unit }}
                                        {{ $unit->smallest_measurement_unit == $recipeIngredient->measure_unit ? 'selected' : ''}}>
                                        {{ $unit->smallest_measurement_unit }}</option>
                                    @endforeach
                                </select>
                                @error('measurement_unit') {{ $message }}@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7 mx-auto">
                            <div class="form-group">
                                <label class="control-label" for="quantity">Quantity</label>
                                <input class="form-control @error('quantity') is-invalid @enderror" type="text"
                                    placeholder="Enter Quantity" id="quantity" name="quantity"
                                    value="{{ old('quantity', $recipeIngredient->quantity) }}" />
                                <div class="invalid-feedback active">
                                    <i class="fa fa-exclamation-circle fa-fw"></i> @error('quantity')
                                    <span>{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tile-footer">
                    <div class="row d-print-none mt-2">
                        <div class="col-12 text-right">
                            <button class="btn btn-success" type="submit"><i
                                    class="fa fa-fw fa-lg fa-check-circle"></i>Update Ingredient</button>
                            <a class="btn btn-danger"
                                href="{{ route('admin.recipe.ingredient.index', $recipe->id) }}"><i
                                    class="fa fa-fw fa-lg fa-arrow-left"></i>Go Back</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
            $('#ingredient_id').select2({
                placeholder: "Select an ingredient",              
                multiple: false, 
                //minimumResultsForSearch: -1,                        
             });

             $('#measure_unit').select2({
                placeholder: "Select an ingredient",              
                multiple: false, 
                minimumResultsForSearch: -1,                        
             });

    });


</script>

@endpush
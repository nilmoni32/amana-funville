<div class="tile">
    <form action="{{ route('admin.settings.update') }}" method="POST" role = "form" >
        {{-- CSRF: Cross-site request forgery --}}
        @csrf
        <h3 class="tile-title">Payment Settings via SSLCommerz for Cards/Net Banking</h3>
        <hr>
        <div class="tile-body">        
            <div class="form-group">
                <label class="control-label" for = "store_id">Store Id</label>
                <input class="form-control" type="text" placeholder="Enter SSLCommerz store id"  name = "store_id" id = "store_id" value = "{{ config('settings.store_id') }}">
            </div>
            <div class="form-group">
                <label class="control-label" for = "store_passwd">Store Password</label>
                <input class="form-control" type="text" placeholder="Enter SSLCommerz store password"  name = "store_passwd" id = "store_passwd" value = "{{ config('settings.store_passwd') }}">
            </div>
        </div>
        <div class="tile-footer">
            <div class="row d-print-none mt-2">
                <div class="col-12 text-right">
                    <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Settings</button>
                </div>
            </div>
        </div>
    </form>
</div>
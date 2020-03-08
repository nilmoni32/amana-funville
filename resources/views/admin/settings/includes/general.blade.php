<div class="tile">
    <form action="{{ route('admin.settings.update') }}" method="POST" role = "form" >
        {{-- CSRF: Cross-site request forgery --}}
        @csrf
        <h3 class="tile-title">General Settings</h3>
        <hr>
        <div class="tile-body">        
            <div class="form-group">
                <label class="control-label" for = "site_name">Site Name</label>
                <input class="form-control" type="text" placeholder="Enter Site name"  name = "site_name" id = "site_name" value = "{{ config('settings.site_name') }}">
            </div>
            <div class="form-group">
                <label class="control-label" for = "site_title">Site Title</label>
                <input class="form-control" type="text" placeholder="Enter Site title"  name = "site_title" id = "site_title" value = "{{ config('settings.site_title') }}">
            </div>
            <div class="form-group">
                <label class="control-label" for = "default_email_address">Default Email Address</label>
                <input class="form-control" type="text" placeholder="Enter email address"  name = "default_email_address" id = "default_email_address" value = "{{ config('settings.default_email_address') }}">
            </div>
            <div class="form-group">
                <label class="control-label" for = "currency_code">Currency Code</label>
                <input class="form-control" type="text" placeholder="Enter currency code"  name = "currency_code" id = "currency_code" value = "{{ config('settings.currency_code') }}">
            </div>
            <div class="form-group">
                <label class="control-label" for = "currency_symbol">Currency Symbol</label>
                <input class="form-control" type="text" placeholder="Enter currency Symbol"  name = "currency_symbol" id = "currency_symbol" value = "{{ config('settings.currency_symbol') }}">
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
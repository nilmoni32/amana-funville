<div class="tile">
    <form action="{{ route('admin.settings.update') }}" method="POST" role="form">
        {{-- CSRF: Cross-site request forgery --}}
        @csrf
        <h3 class="tile-title">POS Printer Settings</h3>
        <hr>
        <div class="tile-body">
            <div class="form-group">
                <label class="control-label" for="protocol">Connection protocol</label>
                <input class="form-control" type="text" placeholder="Enter protocol such as cups, network, windows"
                    name="protocol" id="protocol" value="{{ config('settings.protocol') }}">
            </div>
            <div class="form-group">
                <label class="control-label" for="printer_name">Printer Name</label>
                <input class="form-control" type="text" placeholder="Enter POS Printer Name without any space"
                    name="printer_name" id="printer_name" value="{{ config('settings.printer_name') }}">
            </div>
        </div>
        <div class="tile-footer">
            <div class="row d-print-none mt-2">
                <div class="col-12 text-right">
                    <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update
                        Settings</button>
                </div>
            </div>
        </div>
    </form>
</div>
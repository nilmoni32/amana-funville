<div class="modal fade" id="customerPrintModal{{ $order->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center border-bottom-0 pb-0">
                <h5 class="modal-title text-right mt-3" id="exampleModalLabel"><i class="fa fa-shopping-basket"></i>
                    Customer Print Receipt
                </h5>
            </div>
            <div class="modal-body text-center">
                <div class="text-center">
                    <label class="checkbox">
                        <input type="checkbox" id="useDefaultPrinter" /> <strong>Print to
                            Default
                            printer</strong>
                    </label>
                    <br>
                    <div id="installedPrinters">
                        <label for="installedPrinterName">or Select an installed Printer:</label><br>
                        <select name="installedPrinterName" id="installedPrinterName"
                            class="form-control mt-1 mb-2"></select>
                    </div>
                    <button type="button" onclick="print();"
                        class="btn btn-primary text-center text-uppercase"
                        style="display:block; width:100%;">Print
                        Receipt</button>
                </div>
            </div>
            <div class=" modal-footer border-top-0">
                <button type="button" class="btn bg-gradient-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


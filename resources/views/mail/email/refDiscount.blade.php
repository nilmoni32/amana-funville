<!DOCTYPE html>
<html lang="en">

<body>
    <h3>Funville POS Reference Discount Deatils:</h3>
    
    <p>Dear Funville Admin,</p>    
    <p>Please have the details info regarding reference discount: <br/><br />
        <span style="font-weight: bold; line-height: 1.5;">Order No            : </span>{{ $reference_discount['order_no'] }} <br />
        <span style="font-weight: bold; line-height: 1.5;">Order Date          : </span>{{ $reference_discount['date'] }} <br />
        <span style="font-weight: bold; line-height: 1.5;">Name                : </span>{{ $reference_discount['name'] }} <br />
        <span style="font-weight: bold; line-height: 1.5;">Reference Type      : </span>{{ $reference_discount['type'] }} <br />
        <span style="font-weight: bold; line-height: 1.5;">Discount Received   : </span>{{ $reference_discount['discount'] }} {{ config('settings.currency_symbol') }}<br />
        <span style="font-weight: bold; line-height: 1.5;">Discount Upper Limit: </span>{{ round($reference_discount['discount_limit'],0) }} {{ config('settings.currency_symbol') }}<br /><br />
    </p>
    <p>This is for your kind information</p>
    <p>Thank & Regards, <br/>
    {{ auth()->user()->name }} </p>


</body>

</html>
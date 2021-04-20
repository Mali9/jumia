<form action="{{url('test')}}" id="payform" method="post">
    @csrf
    <span id="paymentErrors"></span>
    <div class="row">
        <label>Card Number</label>
        <input type="text" data-paylib="number" name="number" size="20">
    </div>
    <div class="row">
        <label>Expiry Date (MM/YYYY)</label>
        <input type="text" data-paylib="expmonth" name="expmonth" size="2">
        <input type="text" data-paylib="expyear" name="expyear" size="4">
    </div>
    <div class="row">
        <label>Security Code</label>
        <input type="text" data-paylib="cvv" name="cvv" size="4">
    </div>
    <input type="submit" value="Place order">
</form>
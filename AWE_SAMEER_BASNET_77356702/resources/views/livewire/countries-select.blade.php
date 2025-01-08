<div class="form-row">
    <div class="form-group col-lg-12">
        <div class="custom_select">
            <select class="form-control select-active" name="country" id="country">
                <option value="">Choose a option...</option>
                <option value="1" {{$billingDetails && $billingDetails->country == '1' ? 'selected' : ''}}>Province No. 1</option>
                <option value="2" {{$billingDetails && $billingDetails->country == '2' ? 'selected' : ''}}>Madhesh Province</option>
                <option value="3" {{$billingDetails && $billingDetails->country == '3' ? 'selected' : ''}}>Bagmati Province</option>
                <option value="4" {{$billingDetails && $billingDetails->country == '4' ? 'selected' : ''}}>Gandaki Province</option>
                <option value="5" {{$billingDetails && $billingDetails->country == '5' ? 'selected' : ''}}>Lumbini Province</option>
                <option value="6" {{$billingDetails && $billingDetails->country == '6' ? 'selected' : ''}}>Karnali Province</option>
                <option value="7" {{$billingDetails && $billingDetails->country == '7' ? 'selected' : ''}}>Sudurpashchim Province</option>
            </select>
        </div>
    </div>
</div>
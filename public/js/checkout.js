$(document).ready(function () {
    $('.payonline-btn').click(function (e) { //payonline-btn
        e.preventDefault();

        let fname = $('.fname').val();
        let lname = $('.lname').val();
        let email = $('.email').val();
        let phone = $('.phone').val();
        let address = $('.address').val();
        let pincode = $('.pincode').val();
        let city = $('.city').val();
        let state = $('.state').val();


        if(!fname)
        {
            fname_error = "first name required";
            $('#fname').html('');
            $('#fname').html(fname_error);
        }else{
            fname_error = "";
            $('#fname').html('');
        }
        if(!lname)
        {
            lname_error = "last name required";
            $('#lname').html('');
            $('#lname').html(lname_error);
        }else{
            lname_error = "";
            $('#lname').html('');
        }
        if(!email)
        {
            email_error = "email required";
            $('#email').html('');
            $('#email').html(email_error);
        }else{
            email_error = "";
            $('#email').html('');
        }
        if(!phone)
        {
            phone_error = "phone number required";
            $('#phone').html('');
            $('#phone').html(phone_error);
        }else{
            phone_error = "";
            $('#phone').html('');
        }
        if(!address)
        {
            address_error = "address required";
            $('#address').html('');
            $('#address').html(address_error);
        }else{
            address_error = "";
            $('#address').html('');
        }
        if(!pincode)
        {
            pincode_error = "pincode required";
            $('#pincode').html('');
            $('#pincode').html(pincode_error);
        }else{
            pincode_error = "";
            $('#pincode').html('');
        }
        if(!city)
        {
            city_error = "city required";
            $('#city').html('');
            $('#city').html(city_error);
        }else{
            city_error = "";
            $('#city').html('');
        }
        if(!state)
        {
            state_error = "state required";
            $('#state').html('');
            $('#state').html(state_error);
        }else{
            state_error = "";
            $('#state').html('');
        }

        if (fname_error !='' || lname_error !='' || email_error !='' || phone_error !='' || address_error !='' ||pincode_error !='' || city_error !='' || state_error !=''){
            return false;
        }else{

            const data = {
                fname : fname,
                lname : lname,
                email : email,
                phone : phone,
                address: address,
                pincode: pincode,
                city: city,
                state : state
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "post",
                url: "/razorpay-payment",
                data: data,
                success: function (response) {
                    console.log(response);
                }
            });
        }
    });
});

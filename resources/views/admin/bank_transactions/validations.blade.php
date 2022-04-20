<script>
    $("#paymentForm").validate({
        errorClass: "my-error-class",
        validClass: "my-valid-class",
            rules : {
                normalizer: function (value) {
                  return $.trim(value);
                },
                customer_account_id : {required : true},
                amount : {required : true,min:1},
                final_total : {required : true,equalTo : "#total"},
                total : {required : true},
            },
            messages : {
                customer_account_id : { required : "ACCOUNT NUMBER SHOULD BE SELECTED"},
                amount : { required : "ENTER TRANSFER AMOUNT"},
                final_total : { equalTo : "DENOMINATION NOT MATCHING"},
            }, 
        });
      </script>
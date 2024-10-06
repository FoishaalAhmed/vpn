<?php include('session.php'); ?>
<?php $selectedMenu = "addserver"; ?>
<?php include('templates/common/menubar.php'); ?>
<script src="assets/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.validate.min.js"></script>
<script type="text/javascript">

    (function($,W,D) {
        var JQUERY4U = {};
        JQUERY4U.UTIL = {
            setupFormValidation: function() {
                //form validation rules
                $("#form-validation").validate({
                    rules: {
                        serverName  : "required",
                        ovpnConfig  : "required",
                        username    : "required",
                        password    : "required"
                    },

                    messages: {
                        serverName  : "Please fill out this field!",
                        ovpnConfig  : "Please fill out this field!",
                        username    : "Please fill out this field!",
                        password    : "Please fill out this field!"

                    },
                    errorElement : 'div',
                    submitHandler: function(form) {
                        form.submit();
                    }

                });
            }
        }

        //when the dom has loaded setup form validation rules
        $(D).ready(function($) {
            JQUERY4U.UTIL.setupFormValidation();
        });

    })(jQuery, window, document);

</script>
<?php include('templates/add_server_form.php'); ?>
<?php include('templates/common/footer.php'); ?>
<script>
    $("#country_selector").countrySelect({
        // defaultCountry: "jp",
        // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
        responsiveDropdown: true,
        preferredCountries: ['in', 'us']
    });
</script>
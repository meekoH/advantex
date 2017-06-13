// Form Functionality
$('#currentlyUseFinancing').change(function(){
    var optionSelected = $(this).val();

    if(optionSelected == 'true') {
        $('.advance').css({ 'height':'100%', 'opacity':'1'});
        $('.advance .not-required').removeClass('not-required').addClass('required');
    } else {
        $('.advance').css({ 'height':'0', 'opacity':'0'});
        $('.advance .required').addClass('not-required').removeClass('required');
    }
});

$('#leaseProperty').change(function(){
    var optionSelected = $(this).val();

    if(optionSelected == 'true') {
        $('.months-remaining').css({ 'opacity':'1', 'height':'100%'});
        $('.months-remaining .not-required').removeClass('not-required').addClass('required');
    } else {
        $('.months-remaining').css({ 'opacity':'0', 'height':'0'});
        $('.months-remaining .required').addClass('not-required').removeClass('required');
    }
});

function formValidation() {
    $('.highlight').removeClass('highlight');
    var $fields = $('#apply_form').find('select,input:not([type="submit"])');
    for (var i = 0; i < $fields.length; i++) {
        var $field = $($fields.get(i));
        if ($field.hasClass('not-required')) {
            continue;
        }
        if ($field.val() == '' || $field.val() == null || $field.val() == undefined) {
            $field.addClass('highlight');
            $field.focus();
            var fieldname = $('label[for="' + $field.attr('id') + '"]').text().replace(' *','');
            alert('Please fill out required field: ' + fieldname);
            return false;
        } else {
            // If field is not empty, validate its type and length
            var valid_data = true;
            if ($field.hasClass('decimal')) {
                // Ignore whitespace, dollar signs, and commas
                var value = $field.val();
                value = value.replace(/\s/gi,'');
                value = value.replace(/\$/gi,'');
                value = value.replace(/,/gi,'');
                var a = value.split('.');
                // Cannot have more than one decimal point
                if (a.length > 2) {
                    valid_data = false;
                // Cannot have more than two decimal places
                } else if (a.length > 1 && a[1].length > 2) {
                    valid_data = false;
                // Cannot be greater than 9,999,999.99
                } else if (a[0].length > 7) {
                    valid_data = false;
                    $field.addClass('highlight');
                    $field.focus();
                    var fieldname = $('label[for="' + $field.attr('id') + '"]').text().replace(' *','');
                    alert(fieldname + ' cannot be greater than 9,999,999.99');
                    return false;
                }
                value = value.replace(/\./gi,'');
                // Cannot contain non-numeric characters
                var numbers = '1234567890';
                while (value.length > 0) {
                    if (numbers.indexOf(value.charAt(0)) == -1) {
                        valid_data = false;
                        break;
                    }
                    value = value.substr(1);
                }
                if (!valid_data) {
                    $field.addClass('highlight');
                    $field.focus();
                    var fieldname = $('label[for="' + $field.attr('id') + '"]').text().replace(' *','');
                    alert('Please enter a valid amount for the field: ' + fieldname + ' (eg. 12800.85)');
                    return false;
                } else {
                    var filtered_value = $field.val();
                    filtered_value = filtered_value.replace(/\s/gi,'');
                    filtered_value = filtered_value.replace(/\$/gi,'');
                    filtered_value = filtered_value.replace(/,/gi,'');
                    $field.val(filtered_value);
                }
            } else if ($field.hasClass('long')) {
                var value = $field.val();
                // Ignore whitespace, dollar signs, and commas
                value = value.replace(/\s/gi,'');
                value = value.replace(/\$/gi,'');
                value = value.replace(/,/gi,'');
                var numbers = '1234567890';
                while (value.length > 0) {
                    if (numbers.indexOf(value.charAt(0)) == -1) {
                        valid_data = false;
                        break;
                    }
                    value = value.substr(1);
                }
                if (!valid_data) {
                    $field.addClass('highlight');
                    $field.focus();
                    var fieldname = $('label[for="' + $field.attr('id') + '"]').text().replace(' *','');
                    alert('Please enter a valid amount for the field: ' + fieldname + ' (eg. 10)');
                    return false;
                } else {
                    var filtered_value = $field.val();
                    filtered_value = filtered_value.replace(/\s/gi,'');
                    filtered_value = filtered_value.replace(/\$/gi,'');
                    filtered_value = filtered_value.replace(/,/gi,'');
                    $field.val(filtered_value);
                }
            } else if ($field.hasClass('phone')) {
                var value = $field.val();
                // Requires at least 10 numeric characters
                var numbers = '1234567890';
                var count = 0;
                while (value.length > 0) {
                    if (numbers.indexOf(value.charAt(0)) != -1) {
                        count++;
                    }
                    value = value.substr(1);
                }
                if (count < 7) {
                    valid_data = false;
                }
                if (!valid_data) {
                    $field.addClass('highlight');
                    $field.focus();
                    var fieldname = $('label[for="' + $field.attr('id') + '"]').text().replace(' *','');
                    alert('Please enter a valid number for: ' + fieldname + ' (eg. 877-522-2741)');
                    return false;
                }
            } else if ($field.data('maxlength')) {
                if ($field.val().length > $field.data('maxlength')) {
                    $field.addClass('highlight');
                    $field.focus();
                    var fieldname = $('label[for="' + $field.attr('id') + '"]').text().replace(' *','');
                    alert(fieldname + ' cannot be longer than ' +  $field.data('maxlength')+ ' characters.');
                    return false;
                }
            }
        }
    }
    return true;
}
function randomString(length) {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < length; i++) {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }

    return text;
}

function submitApplication() {
    if ($('#externalRequestID').val() == '') {
        $('#externalRequestID').val(randomString(16));
    }
    var data = {};
    $('#apply_form').serializeArray().map(function(x){data[x.name] = x.value;}); 
    $.ajax({
        type: "POST",
        url: "submitApplication.php",
        data: { "data": JSON.stringify(data) },
        success: function(response) {
            if (typeof(response) == typeof('string')) {
                try {
                    response = JSON.parse(response);
                } catch(e) {
                    alert('There was an error submitting your application. Please try again later.');
                }
            }
            if (response.result == 'success') {
                $('#apply_form').hide();
                $('.apply-box h1').text('Thank You');
                $('.apply-box').append('<div style="color: #000">' + response.message + '</div>');
                $('.apply-box').append('<div class="form-section" style="text-align:center;"><input type="submit" value="Return Home" class="btn btn-8 btn-8f" onclick="window.location=\'index.html\'" style="padding: 5px 40px !important;"></div>');
            } else if (response.code == '98') {
                // Ignore duplicate request
                alert('Error: Your application was already submited.');
            } else {
                alert('There was an error submitting your application. Please try again later.');
            }
        },
        error: function() {
            alert('There was an error submitting your application. Please try again later.');
        }
    });
}
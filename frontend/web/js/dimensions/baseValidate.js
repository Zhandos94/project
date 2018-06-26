/**
 * Created by BADI on 29.12.2016.
 */

function initNum(numParams) {
    $(numParams).each(function () {
        var autoNumParams = {};
        autoNumParams.aSep = ' ';
        autoNumParams.aPad = false;
        if (this.vMax != null) {
            autoNumParams.vMax = this.vMax;
        }
        $('#' + this.id).autoNumeric('init', autoNumParams);

    });
}

function initString(stringParams) {
    $(stringParams).each(function () {
        if (this.max_length != null) {
            $('#' + this.id).attr('maxlength', this.max_length);
        }
    });
}

function validateRequires() {
    var result = true;
    $('#dynamic_form .required-dim').each(function () {
        if ($(this).val() == '') {
            var id = $(this).attr('id');
            var label = getLabel(id);
            var message = _t("{label} cannot be blank", label);
            addError(id, message);
            result = false;
        }
    });
    return result;
}

function validateString(stringParams) {
    var checked = true;
    $(stringParams).each(function () {
        var minLength = this.min_length,
            maxLength = this.max_length,
            maxMsg = this.maxMsg,
            minMsg = this.minMsg,
            curlength = $('#' + this.id).val().trim().length,
            elem = $('#' + this.id);
        if (curlength < minLength) {
            addError(this.id, minMsg);
            checked = false;
        }
        if (maxLength) {
            if (curlength > maxLength) {
                addError(this.id, maxMsg);
                checked = false;
            }
        }
    });
    return checked;
}

function validateDate(dateParams) {
    var checked = true;
    $(dateParams).each(function () {

        var elem = $('#' + this.id);
        var val = elem.val().trim();
        var curlength = val.length;
        if (curlength > 0) {
            var regex = new RegExp(this.regex);
            if (regex.test(val) == false) {
                addError(this.id, this.message);
                checked = false;
            }

        }
    });
    return checked;
}

function addError(id, message) {
    var item = $('#' + id);
    var parent = item.parent();
    if (item.hasClass('datetime-attr')) {
        item = item.parent();
        parent = parent.parent();
    }
    item.siblings('p').html(message);
    parent.addClass('has-error');
}

function getLabel(id) {
    var item = $('#' + id);
    if (item.hasClass('datetime-attr')) {
        item = item.parent();
    }
    return item.siblings('label').html();
}
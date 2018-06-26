/**
 * Created by BADI on 10.01.2017.
 */

function display(parent, show) {
    var child = getChild(parent);
    if (child !== null) {
        var elem = $('#' + child);
        parent = $('#' + parent);
        if (
            elem.html().trim() === ''
            || elem.children('option').length <= 1
            || parent.html().trim() === ''
            || parent.parent().hasClass('has-error')
            || parent.parent().css('display') === 'none'
            || parent.val() === ''
        ) {
            elem.parent().hide();
            // $(child).html('');
        } else {
            if (show === true) {
                var prompt = document.createElement('option');
                prompt.text = elem.attr('data-prompt');
                prompt.setAttribute('selected', '');
                prompt.setAttribute('value', '');
                elem.prepend(prompt);
                elem.parent().show();
            }
        }
        display(child, show);
    }
}

function createOptions(list, child) {
    var elem = $('#' + child);
    elem.html('');
    var child_option = null;
    for (var key in list) {
        child_option = document.createElement('option');
        child_option.text = list[key];
        child_option.setAttribute('value', key);
        elem.append(child_option);
    }
}

function relationListenInit(array) {
    for (var key in array) {
        var item = array[key],
            child = item.child,
            parent = item.parent;
        addListener(parent);
        display(parent, false);
    }
}

function addListener(parent) {
    $('#' + parent).bind("change", function () {
        var child = getChild(parent),
            val = $(this).val(),
            parentName = $('#' + parent).data('name'),
            childName = $('#' + child).data('name'),
            data = {parentVal: val, parent: parentName, child: childName};
        request(parent, data);
    });
}

function request(parent, data) {
    $.ajax({
        type: 'post',
        data: data,
        url: '/get-attr/get-dep-drop',
        success: function (response) {
            var list = JSON.parse(response),
                child = getChild(parent);
            createOptions(list, child);
            display(parent, true);
        }
    });
}

function getChild(elem) {
    var result = null;
    for (var key in relParams) {
        var item = relParams[key],
            child = item.child,
            parent = item.parent;
        if (parent == elem) {
            result = child;
        }
    }
    return result;
}


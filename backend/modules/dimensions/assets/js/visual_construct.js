(function (lot_dimensions, lot_type_id) {
    var dragMovedElement = null,
        dataApply = {},
        rootElementID = '#visiual_construct',
        conf;

        // CN - class name for jq,
        // ID - name for jq,
        // AN - attr name,
        conf = {
            'rowAddBetween_CN': '.vc-row-add-between',
            'rowAdd_ID': '#add-row',
            'rowRemove_CN': '.vc-row-remove',
            'rowNumPre_ID': '#row-num-',
            'row_CN': '.vc-row',
            'colAdd_CN': '.add-col',
            'colRemove_CN': '.vc-col-remove',
            'ready_CN': '.vc-ready',
            'readyPre_ID': '#vc-ready-',
            'save_ID': '#vc-save',
            'apply_ID': '#vc-apply',
            'notActiveDimensions_ID': '#not_active_dimensions',
            'notActiveToggle_ID': '#not_active_toggle',
            'col_CN': '.vc-col',
            'dynamicForm_ID': '#dynamic_form',
            'drop_CN': '.vc-drop',
            'lotDimPre_ID': '#lot-dim-',
            'colSize_AN': 'data-col-size',
            'colMdPre_AN': 'col-md-',
            'orderInRow_AN': 'data-order-in-row',
            'rowNum_AN': 'data-row-num'
        };

    renderConstructor(lot_dimensions);

    /***************************************/
    /*                 EVENT               */
    /***************************************/

    $(conf.rowAdd_ID).on('click',  addRow);

    $(rootElementID).delegate(conf.rowAddBetween_CN, 'click', addRowBetween);

    $(rootElementID).delegate(conf.rowRemove_CN, 'click', removeRow);

    $(rootElementID).delegate(conf.colAdd_CN, 'click', addCol);

    $(rootElementID).delegate(conf.colRemove_CN, 'click', removeCol);

    $(rootElementID).delegate('.vc-col-size>i', 'click', function (e) {
        e.preventDefault(); e.stopPropagation();
        plusMinusSize(this);
    });

    $(conf.apply_ID).click(function (e) {
        e.preventDefault();
        var data = {};
        if ($(rootElementID).find(conf.ready_CN).length != 0) {
            $(this).prop('disabled', true);
            $(conf.save_ID).prop('disabled', false);
            $(rootElementID).find('input').toArray().forEach(function (item) {
                data[$(item).val()] = {
                    'row_num': $(item).closest(conf.row_CN).attr(conf.rowNum_AN),
                    'col_count': $(item).closest(conf.col_CN).attr(conf.colSize_AN),
                    'order_in_row': $(item).closest(conf.col_CN).attr(conf.orderInRow_AN)
                };
            });
            dataApply = {
                'dimensions': data,
                'lotTypeId': lot_type_id
            };
        }
    });

    $(conf.save_ID).click(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: '/dimensions/dim-data/visual-edit',
            data: dataApply,
            success: function (response) {
                if (response == true) {
                    location.reload();
                } else {
                    $(conf.rowAdd_ID).after('<div class="alert alert-danger vc-danger-message" role="alert">' + response + '</div>');
                }
            },
            error: function (response) {
                // console.log(response);
            }
        });
    });

    if ($(conf.notActiveDimensions_ID).find('li').length != 0) {
        $(conf.notActiveToggle_ID).click(function () {
            $(conf.notActiveDimensions_ID).toggle('slow');
        });
    }

    /////// drag events

    $(conf.dynamicForm_ID).find('.form-group').livequery(function () {
        var label, data;
        label = $(this).find('label').text();
        data = $(this).find('select, input').attr('id').replace('lot-dim-', '');
        dragMovedElement = {
            'movedElement': htmlVcReady(data, label),
            'operation': 'add',
            'idElement': data
        };
        $(this).draggable({
            helper: 'clone',
            opacity: 1,
            revert: 'invalid'
        });
    });

    $(rootElementID).find(conf.ready_CN).livequery(function () {
        var label, data;
        label = $(this).find('label').text();
        data = $(this).find('input').val();
        dragMovedElement = {
            'movedElement': htmlVcReady(data, label),
            'operation': 'replace',
            'idElement': data
        };
        $(this).draggable({
            helper: 'clone',
            opacity: 1,
            revert: 'invalid'
        });
    });

    $(conf.col_CN).livequery(function () {
        $(this).droppable({
            drop: function() {
                var elemDropap, dynamicFormDimElementID;
                elemDropap = $(this).find(conf.drop_CN);
                dynamicFormDimElementID = conf.lotDimPre_ID + dragMovedElement.idElement;
                if ($(elemDropap).find(conf.ready_CN).length != 0) {
                    if (dragMovedElement.operation === 'replace') {
                        var label, data, thatElement, thisElement;
                        label = $(elemDropap).find('label').text();
                        data = $(elemDropap).find('input').val();
                        if ($(elemDropap).find(conf.ready_CN).attr('id') != 'vc-ready-' + dragMovedElement.idElement) {
                            thatElement = $(conf.readyPre_ID + dragMovedElement.idElement);
                            thisElement = htmlVcReady(data, label);
                            $(elemDropap).find(conf.ready_CN).replaceWith(dragMovedElement.movedElement);
                            $(thatElement).replaceWith(thisElement);
                        }
                    } else if (dragMovedElement.operation === 'add') {
                        $(conf.lotDimPre_ID + $(elemDropap).find('input').val()).closest('.form-group').removeClass('vc-moved');
                        $(elemDropap).find(conf.ready_CN).replaceWith(dragMovedElement.movedElement);
                        $(dynamicFormDimElementID).closest('.form-group').addClass('vc-moved');
                    }
                    $(this).removeClass('vc-over');
                } else {
                    if (dragMovedElement.operation === 'replace') {
                        $('#' + dragMovedElement.idElement).closest(conf.ready_CN).remove();
                        $(elemDropap).append(dragMovedElement.movedElement);
                    } else {
                        $(elemDropap).append(dragMovedElement.movedElement);
                        $(dynamicFormDimElementID).closest('.form-group').addClass('vc-moved');
                    }
                }
                dragMovedElement = null;
                returnApply();
            },
            activate: function() {
                $(this).addClass('vc-goal');
            },
            deactivate: function() {
                $(this).removeClass('vc-goal');
            },
            over: function() {
                $(this).addClass('vc-over');
            },
            out: function() {
                $(this).removeClass('vc-over');
            }
        });
    });

    /***************************************/
    /*               FUNCTION              */
    /***************************************/

    function renderConstructor(lot_dimensions) {
        /*lot_dimensions.sort(compareOrderInRow);
        lot_dimensions.sort(compareRowNum);*/
        lot_dimensions.forEach(function (itemDim) {
            var code, label, rowNum, colCount, orderInRow, isActive,
                currRowID, elVcRow, elVcCol, elVcReady,
                rowSize, elVcRowRemove, elVcBeetwenRowAdd;
            label = itemDim.label;
            rowNum = itemDim.row_num;
            isActive = itemDim.is_active;

            if (isActive) {
                if (rowNum) {
                    code = itemDim.code;
                    colCount = itemDim.col_count;
                    orderInRow = itemDim.order_in_row;
                    currRowID = conf.rowNumPre_ID + rowNum;
                    elVcRow = htmlVcRow();
                    elVcCol = htmlVcCol(colCount, orderInRow);
                    elVcReady = htmlVcReady(code, label);
                    elVcRowRemove = htmlVcRowRemove(rowNum);
                    elVcBeetwenRowAdd = htmlVcBetweenRowAdd(rowNum);
                    $(conf.lotDimPre_ID + code).closest('.form-group').addClass('vc-moved');
                    // first iteration
                    if ($(conf.row_CN).length == 0) {
                        $(rootElementID).append($(elVcRow).attr(conf.rowNum_AN, '1').attr('id', 'row-num-1').after(elVcRowRemove));
                    }

                    if ($(conf.rowNumPre_ID + rowNum).length == 0) {
                        $(rootElementID).append($(elVcRow).attr(conf.rowNum_AN, rowNum).attr('id', 'row-num-' + rowNum));
                    }

                    $(currRowID).append(elVcCol);
                    $(currRowID).find(conf.col_CN + '[' + conf.orderInRow_AN + '="' + orderInRow + '"]').find(conf.drop_CN).append(elVcReady);

                    if ($(currRowID).next(conf.rowRemove_CN).length  == 0) {
                        $(currRowID).after(elVcRowRemove); // button remove row
                        $(currRowID).before(elVcBeetwenRowAdd); // button add row
                    }
                    rowSize = getRowDatas(currRowID).size;
                    showAddColButton(rowSize, currRowID);
                }
            } else {
                $(conf.notActiveDimensions_ID).find('ul').append('<li>Label - <b>' + label + '</b></li>');
            }
        });


    }

    function addRow() {
        var rowNum, currRowID, elVcRow;
        rowNum = parseInt($(rootElementID).find(conf.row_CN).last().attr(conf.rowNum_AN), 10) + 1;
        currRowID = conf.rowNumPre_ID + rowNum;
        elVcRow = htmlVcRow();
        $(elVcRow).attr(conf.rowNum_AN, rowNum).attr('id', 'row-num-' + rowNum);
        $(rootElementID).append(elVcRow);
        $(currRowID).before(htmlVcBetweenRowAdd(rowNum));
        $(currRowID).after(htmlVcRowRemove(rowNum));
        $(currRowID).append(htmlVcCol(6, 1));
        resetRowNum();
    }

    function addRowBetween() {
        var elVcRow, rowNum, currRowID, vcBetweenClassName, nextRow;
        rowNum = $(this).attr(conf.rowNum_AN);
        currRowID = conf.rowNumPre_ID + rowNum;
        vcBetweenClassName = 'vc-row-between';
        nextRow = $(this).next(conf.row_CN);
        elVcRow = htmlVcRow();
        $(elVcRow).attr(conf.rowNum_AN, rowNum).attr('id', 'row-num-' + rowNum).addClass(vcBetweenClassName);
        $(this).after(elVcRow);
        $('.' + vcBetweenClassName).after(htmlVcRowRemove(rowNum));
        $(nextRow).before(htmlVcBetweenRowAdd(parseInt(rowNum, 10) + 1));
        resetRowNum();
        $(currRowID).removeClass(vcBetweenClassName);
        $(currRowID).append(htmlVcCol(6, 1));
    }

    function removeRow() {
        var rowNum, currRowID, currRowAllCol;
        if ($(rootElementID).find(conf.row_CN).length > 1) {
            rowNum = parseInt($(this).attr(conf.rowNum_AN), 10);
            currRowID = conf.rowNumPre_ID + rowNum;
            currRowAllCol = $(currRowID).find(conf.col_CN);
            $(currRowAllCol).toArray().forEach(function (item) {
                $(conf.lotDimPre_ID + $(item).find('input').val()).closest('.form-group').removeClass('vc-moved');
            });
            $(currRowID).remove();
            $(this).prev(conf.rowAddBetween_CN).remove();
            $(this).remove();
            resetRowNum();
            returnApply();
        }
    }

    function addCol() {
        var currRowElement, elVcCol, rowColCount, rowSize, addSize, currRowID, rowDatas;

        currRowElement = $(this).closest(conf.row_CN);
        currRowID = conf.rowNumPre_ID + $(currRowElement).attr(conf.rowNum_AN);
        rowDatas = getRowDatas(currRowID);
        rowColCount = rowDatas.colCount;
        rowSize = rowDatas.size;
        addSize = 12 - rowSize;

        elVcCol = htmlVcCol(addSize, rowColCount + 1);
        $(currRowElement).append(elVcCol);
        showAddColButton((rowSize + addSize), currRowID);
    }

    function removeCol() {
        var currRowElement, currColElement, currRowID, dynamicFormDimElementID, rowSize;
        currRowElement = $(this).closest(conf.row_CN);
        currColElement = $(this).closest(conf.col_CN);
        currRowID = conf.rowNumPre_ID + $(currRowElement).attr(conf.rowNum_AN);
        dynamicFormDimElementID = conf.lotDimPre_ID + $(currColElement).find('input').val();
        $(dynamicFormDimElementID).closest('.form-group').removeClass('vc-moved');
        if ($(currRowElement).find(conf.col_CN).length > 1) {
            $(currColElement).remove();
            rowSize = getRowDatas(currRowID).size;
            showAddColButton(rowSize, currRowID);
            returnApply();
        } else {
            if ($(currColElement).find(conf.ready_CN).length != 0) {
                $(currColElement).find(conf.ready_CN).remove();
                returnApply();
            }
        }
    }

    function plusMinusSize(currentElement) {
        var currColElement, currColSize, currRowElement, newSize, rowSize, currRowID;
        currRowElement = $(currentElement).closest(conf.row_CN);
        currColElement = $(currentElement).closest(conf.col_CN);
        currColSize = parseInt($(currColElement).attr(conf.colSize_AN), 10);
        currRowID = conf.rowNumPre_ID + $(currRowElement).attr(conf.rowNum_AN);
        rowSize = getRowDatas(currRowID).size;
        if ($(currentElement).hasClass('vc-col-size-plus')) {
            newSize = currColSize + 1;
            if (newSize < 13 && rowSize < 12) {
                $(currColElement).removeClass('col-md-' + currColSize).addClass('col-md-' + newSize).attr(conf.colSize_AN, newSize);
            }
            showAddColButton(rowSize + 1, currRowID);
        }

        if ($(currentElement).hasClass('vc-col-size-min')) {
            if (currColSize > 1) {
                newSize = currColSize - 1;
                if (newSize > 0) {
                    $(currColElement).removeClass('col-md-' + currColSize).addClass('col-md-' + newSize).attr(conf.colSize_AN, newSize);
                }
                showAddColButton(rowSize - 1, currRowID);
            }
        }
        if ($(currColElement).find(conf.ready_CN).length != 0) {
            returnApply();
        }
    }

    function showAddColButton(size, currRowID) {
        if (size > 11) {
            $(currRowID).find(conf.colAdd_CN).hide();
        } else {
            if (!$(currRowID).find(conf.colAdd_CN).is(':visible')) {
                $(currRowID).find(conf.colAdd_CN).show();
            }
        }
    }

    /*function compareRowNum(dimA, dimB) {
        return dimA.row_num - dimB.row_num;
    }

    function compareOrderInRow(dimA, dimB) {
        return dimA.order_in_row - dimB.order_in_row;
    }*/

    function getRowDatas(rowID) {
        var rowSize = 0, colCount = 0;
        $(rowID).find(conf.col_CN).toArray().forEach(function (item, i) {
            $(item).attr(conf.orderInRow_AN, i + 1);
            colCount = i + 1;
            rowSize = rowSize + parseInt($(item).attr(conf.colSize_AN), 10);
        });
        return {
            size: rowSize,
            colCount: colCount
        };
    }

    function resetRowNum() {
        var allRow, allRowRemoveButtons, allRowAddButtons;

        allRow = $(rootElementID).find(conf.row_CN);
        allRowRemoveButtons = $(rootElementID).find(conf.rowRemove_CN);
        allRowAddButtons = $(rootElementID).find(conf.rowAddBetween_CN);

        if ($(allRow).length != 0) {
            $(allRow).toArray().forEach(function (item, i) {
                $(item).attr(conf.rowNum_AN, i + 1).attr('id', 'row-num-' + (i + 1));
            });
            $(allRowRemoveButtons).toArray().forEach(function (item, i) {
                $(item).attr(conf.rowNum_AN, i + 1);
            });
            $(allRowAddButtons).toArray().forEach(function (item, i) {
                $(item).attr(conf.rowNum_AN, i + 1);
            });
        }
    }

    function returnApply() {
        if ($(conf.apply_ID + ':disabled')) {
            $(conf.apply_ID).prop('disabled', false);
        }
        $(conf.save_ID).prop('disabled', true);
    }

    /***************************************/
    /*                 HTML                */
    /***************************************/

    function htmlVcRow() {
        return $('' +
            '<div class="row vc-row">' +
                '<i class="fa fa-plus add-col" aria-hidden="true"></i>' +
            '</div>'
        );
    }

    function htmlVcCol(size, orderInRow) {
        var vcCol = $('<div class="vc-col"></div>');
        $(vcCol)
            .addClass(conf.colMdPre_AN + size)
            .attr(conf.colSize_AN, size)
            .attr(conf.orderInRow_AN, orderInRow)
            .append(htmlVcColSizeRegulator())
            .append(htmlVcDrop())
            .append(htmlVcColRemove());
        return vcCol;
    }

    function htmlVcColSizeRegulator() {
        return $('' +
            '<span class="vc-col-size">' +
                '<i class="fa fa-sort-asc vc-col-size-plus" aria-hidden="true"></i>' +
                '<i class="fa fa-sort-desc vc-col-size-min" aria-hidden="true"></i>' +
            '</span>'
        );
    }

    function htmlVcDrop() {
        return $('<div class="vc-drop"></div>');
    }

    function htmlVcColRemove() {
        return $('<i class="fa fa-times vc-col-remove" aria-hidden="true"></i>');
    }

    function htmlVcReady(code, label) {
        return $('' +
            '<div class="vc-ready" id="vc-ready-' + code + '">' +
                '<label for="' + code + '">' + label + '</label>' +
                '<input type="hidden" id="' + code + '" value="' + code + '">' +
            '</div>');
    }

    function htmlVcRowRemove(rowNum) {
        return $('<i class="fa fa-minus-circle vc-row-remove" aria-hidden="true" ' + conf.rowNum_AN + '="' + rowNum + '"></i>');
    }

    function htmlVcBetweenRowAdd(rowNum) {
        return $('<i class="fa fa-plus-circle vc-row-add-between" aria-hidden="true" ' + conf.rowNum_AN + '="' + rowNum + '"></i>');
    }
}(lot_dimensions, lot_type_id));


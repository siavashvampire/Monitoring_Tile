var temIndexForPersianData = 0 ;
$(document)
    .ajaxStart(function () {
        $('.PaymentCMSLoading').show();
    })
    .ajaxStop(function () {
        dataToPersian();
        $('.selectpicker').selectpicker('refresh');
        $('.PaymentCMSLoading').hide();
    });
$(document).ready(function() {
    dataToPersian();
    $('.selectpicker').selectpicker('refresh');
    $('.PaymentCMSLoading').hide();
});
function tooltip(massage) {
    $.notify(
        {
            icon: "help",
            message: massage
        }, {
            type: "info",
            placement: {
                from: "top",
                align: "left"
            }
        }
    );
}




function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function eraseCookie(name) {
    document.cookie = name+'=; Max-Age=-99999999;';
}


function dataToPersian(){
    $('input[type="date"]').each(function( index ) {
        $(this).attr( "autocomplete", "off" );
        $(this).attr( "type", "text" );
        var elName = $(this).attr( "name" );
        var elVal = $(this).attr('value');
        //$(this).removeAttr( "name" );
        //$( this ).after( "<input type='hidden' name='"+elName+"' class='persianDatepicker-alt-"+temIndexForPersianData+"'> " );
        var justTime = $( this ).data( "onlytime" );
        if ( justTime === undefined )
            justTime=false;
        else
            justTime = true ;
        var time = $( this ).data( "time" );
        if ( time === undefined )
            time=false;
        else
            time = true ;
        var pd = $(this).persianDatepicker({
            initialValueType: 'persian',
            observer: true,
            format: justTime ? 'HH:mm' : ( time ? 'YYYY/MM/DD HH:mm' : 'YYYY/MM/DD' ),
            onlyTimePicker: justTime,
            autoClose: true,
            timePicker: {
                enabled: time,
                meridiem: {
                    enabled: true
                },
                second : {
                    enabled: false
                }
            },
            // altField: '.persianDatepicker-alt-'+temIndexForPersianData
        });
        if (parseInt(elVal) > 1000 )
            pd.setDate(parseInt(elVal));
        else
            $(".persianDatepicker-alt-" + temIndexForPersianData).val('');
        $(this).attr('value' , '');
        // $(".persianDatepicker-alt-"+temIndexForPersianData).val(elVal);
        temIndexForPersianData++;
    });
    $(".persianJustDatePicker").persianDatepicker({
        persianDigit: false ,
        initialValue: false,
        minDate : null,
        format: 'YYYY/MM/DD',
        timePicker: {
            enabled: false,
            meridiem: {
                enabled: false
            },
            second : {
                enabled: false
            },
            minute : {
                enabled: false
            }
        },
        autoClose: true,
    });
    let to_persianDatepicker, from_persianDatepicker;
    let to1, from1;
    let persianNumber1 = ["۰","۱","۲","۳","۴","۵","۶","۷","۸","۹"] ;
    to1 = $(".persianJustDatePicker-to").persianDatepicker({
        altField: '.persianJustDatePicker-to-alt',
        persianDigit: false ,
        format: 'YYYY/MM/DD',
        title:'ss',
        initialValue: false,
        autoClose: true,
        timePicker: {
            enabled: false,
            meridiem: {
                enabled: false
            },
            second : {
                enabled: false
            },
            minute : {
                enabled: false
            }
        },
        onSelect: function (unix) {
            to1.touched = true;
            if (from1 && from1.options && from1.options.maxDate != unix  ) {
                let cachedValue = from1.getState().selected.unixDate;
                from1.options = {maxDate: unix  };
                if (from1.touched) {
                    from1.setDate(cachedValue);
                }
            }
        }
    });
    from1 = $(".persianJustDatePicker-from").persianDatepicker({
        altField: '.persianJustDatePicker-from-alt',
        persianDigit: false ,
        format: 'YYYY/MM/DD',
        title:'ss',
        initialValue: false,
        autoClose: true,
        timePicker: {
            enabled: false,
            meridiem: {
                enabled: false
            },
            second : {
                enabled: false
            },
            minute : {
                enabled: false
            }
        },
        onSelect: function (unix) {
            from1.touched = true;
            if (to1 && to1.options && to1.options.minDate != unix ) {
                let cachedValue = to1.getState().selected.unixDate;
                to1.options = {minDate: unix};
                if (to1.touched) {
                    to1.setDate(cachedValue);
                }
            }
        }
    });
}


function ajaxThisForm(formIdentity, ResultIdentity , ResetOnSuccess , toggleForm , callFun) {
    let link = $( formIdentity ).attr('action');
    let data = $( formIdentity ).serializeArray();
    $(ResultIdentity+'Success').hide();
    $(ResultIdentity+'Danger').hide();
    $.ajax({
        url: link,
        type: 'post',
        dataType: 'json',
        data: data ,
        success: function (result) {
            if (result['status']) {
                $(ResultIdentity+'Success').show();
                $(ResultIdentity+'SuccessText').html(result['message']);
                if ( toggleForm  === true ){
                    $( formIdentity ).toggle('slow');
                }
                if ( ResetOnSuccess  === true ){
                    $(formIdentity).trigger("reset");
                }
                if ( callFun !== '' ){
                    window[callFun]();
                }
                return false;
            }
            else {
                $(ResultIdentity+'Danger').show();
                $(ResultIdentity+'DangerText').html(result['message']);
                return false;
            }
        }
    });
    return false;
}

function ajaxThisFormGetHtml(formIdentity, ResultIdentity , ResetOnSuccess , toggleForm , callFun) {
    var link = $( formIdentity ).attr('action');
    var data = $( formIdentity ).serializeArray();
    $.ajax({
        url: link,
        type: 'post',
        dataType: 'html',
        data: data ,
        success: function (html) {
            if (html) {
                var result = $('<div />').append(html).find(ResultIdentity).html();
                $(ResultIdentity).html(result);
                if ( toggleForm  === true ){
                    $( formIdentity ).toggle('slow');
                }
                if ( ResetOnSuccess  === true ){
                    $(formIdentity).trigger("reset");
                }
                if ( callFun !== '' ){
                    window[callFun]();
                }
                return false;
            }
            else {
                return false;
            }
        }
    });
    return false;
}

function ajaxRunUrlHtml(link, ResultIdentity  , callFun) {
    $.ajax({
        url: link,
        type: 'post',
        dataType: 'html',
        success: function (html) {
            if (html) {
                var result = $('<div />').append(html).find(ResultIdentity).html();
                $(ResultIdentity).html(result);
                if ( callFun !== '' ){
                    window[callFun]();
                }
                return true;
            }
            else {
                return false;
            }
        }
    });
    return false;
}


$(document).ready(function() {
    var to_persianDatepicker, from_persianDatepicker;
    var to1, from1,to2, from2,to3, from3;
    var persianNumber1 = ["۰","۱","۲","۳","۴","۵","۶","۷","۸","۹"] ;
    to1 = $(".persianDatepicker-to").persianDatepicker({
        altField: '.persianDatepicker-to-alt',
        persianDigit: false ,
        format: 'YYYY/MM/DD ساعت HH:mm',
        title:'ss',
        initialValue: false,
        maxDate: new persianDate().valueOf(),
        autoClose: true,
        timePicker: {
            enabled: true,
            meridiem: {
                enabled: false
            },
            second : {
                enabled: false
            },
            minute : {
                enabled: true
            }
        },
        onSelect: function (unix) {
            to1.touched = true;
            if (from1 && from1.options && from1.options.maxDate != unix  ) {
                var cachedValue = from1.getState().selected.unixDate;
                from1.options = {maxDate: unix  };
                if (from1.touched) {
                    from1.setDate(cachedValue);
                }
            }
        }
    });
    from1 = $(".persianDatepicker-from").persianDatepicker({
        altField: '.persianDatepicker-from-alt',
        persianDigit: false ,
        initialValue: false,
        minDate : null,
        maxDate: new persianDate().valueOf(),
        format: 'YYYY/MM/DD ساعت HH:mm',
        timePicker: {
            enabled: true,
            meridiem: {
                enabled: false
            },
            second : {
                enabled: false
            },
            minute : {
                enabled: true
            }
        },
        autoClose: true,
        onSelect: function (unix) {
            from1.touched = true;
            if (to1 && to1.options && to1.options.minDate != unix ) {
                var cachedValue = to1.getState().selected.unixDate;
                to1.options = {minDate: unix};
                if (to1.touched) {
                    to1.setDate(cachedValue);
                }
            }
        }
    });

    to2 = $(".persianJustDatepicker-to").persianDatepicker({
        altField: '.persianJustDatepicker-to-alt',
        persianDigit: false ,
        format: 'YYYY/MM/DD',
        title:'ss',
        initialValue: false,
        autoClose: true,
        timePicker: {
            enabled: true,
            meridiem: {
                enabled: false
            },
            second : {
                enabled: false
            },
            minute : {
                enabled: true
            }
        },
        onSelect: function (unix) {
            to2.touched = true;
            if (from2 && from2.options && from2.options.maxDate != unix  ) {
                var cachedValue = from2.getState().selected.unixDate;
                from2.options = {maxDate: unix  };
                if (from2.touched) {
                    from2.setDate(cachedValue);
                }
            }
        }
    });
    from2 = $(".persianJustDatepicker-from").persianDatepicker({
        altField: '.persianDatepicker-from-alt',
        persianDigit: false ,
        initialValue: false,
        minDate : null,
        format: 'YYYY/MM/DD',
        timePicker: {
            enabled: true,
            meridiem: {
                enabled: false
            },
            second : {
                enabled: false
            },
            minute : {
                enabled: true
            }
        },
        autoClose: true,
        onSelect: function (unix) {
            from2.touched = true;
            if (to2 && to2.options && to2.options.minDate != unix ) {
                var cachedValue = to2.getState().selected.unixDate;
                to2.options = {minDate: unix};
                if (to2.touched) {
                    to2.setDate(cachedValue);
                }
            }
        }
    });


    to3 = $(".persianJustDatepicker-to2").persianDatepicker({
        altField: '.persianJustDatepicker-to-alt2',
        persianDigit: false ,
        format: 'YYYY/MM/DD',
        title:'ss',
        initialValue: false,
        autoClose: true,
        timePicker: {
            enabled: true,
            meridiem: {
                enabled: false
            },
            second : {
                enabled: false
            },
            minute : {
                enabled: true
            }
        },
        onSelect: function (unix) {
            to3.touched = true;
            if (from3 && from3.options && from3.options.maxDate != unix  ) {
                var cachedValue = from3.getState().selected.unixDate;
                from3.options = {maxDate: unix  };
                if (from3.touched) {
                    from3.setDate(cachedValue);
                }
            }
        }
    });
    from3 = $(".persianJustDatepicker-from2").persianDatepicker({
        altField: '.persianDatepicker-from-alt2',
        persianDigit: false ,
        initialValue: false,
        minDate : null,
        format: 'YYYY/MM/DD',
        timePicker: {
            enabled: true,
            meridiem: {
                enabled: false
            },
            second : {
                enabled: false
            },
            minute : {
                enabled: true
            }
        },
        autoClose: true,
        onSelect: function (unix) {
            from3.touched = true;
            if (to3 && to3.options && to3.options.minDate != unix ) {
                var cachedValue = to3.getState().selected.unixDate;
                to3.options = {minDate: unix};
                if (to3.touched) {
                    to3.setDate(cachedValue);
                }
            }
        }
    });


    $(".persianTimePicker").persianDatepicker({
        persianDigit: false ,
        initialValue: false,
        format: 'HH:mm',
        timePicker: {
            enabled: true,
            meridiem: {
                enabled: false
            },
            second : {
                enabled: false
            },
            minute : {
                enabled: true
            }
        },
        autoClose: true,
        onlyTimePicker: true
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
    $(".persianJustDatePickerDay").persianDatepicker({
        persianDigit: false,
        initialValueType: 'persian',
        minDate: null,
        maxDate: new persianDate().valueOf(),
        format: 'YYYY/MM/DD',
        timePicker: {
            enabled: false,
            meridiem: {
                enabled: false
            },
            second: {
                enabled: false
            },
            minute: {
                enabled: false
            }
        },
        autoClose: true,
    });
});
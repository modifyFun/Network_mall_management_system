layui.use("table",function(){
    let $ = layui.jquery;
    clock($);
    getData($);


    $(document).ready(function() {
        $(function() {
            $("#clock").MyDigitClock({
                fontSize: 36,
                fontFamily: "Century gothic",
                fontColor: "#000",
                fontWeight: "bold",
                bAmPm: true,
                background: '#fff',
                bShowHeartBeat: true
            });
        });
    });
})

function getData($)
{
    $.ajax({
        type: 'GET',
        url: '/php/api/adhome/v1.api.home.php',
        dataType: 'json'
    }).done(data=>{
        console.log(data);
        renderData(data.data,$);
    }).fail(data=>{
        console.log(123);
    })
}

function renderData(data,$)
{
    $("#goods").text(data[0]);
    $("#user").text(data[3]);
    $("#money").text(data[2]);
    $("#orders").text(data[1]);
}


function clock ($) {
    var _options = {};
    var _container = {};
    $.fn.MyDigitClock = function(options) {
        var id = $(this).get(0).id;
        _options[id] = $.extend({}, $.fn.MyDigitClock.defaults, options);
        return this.each(function() {
            _container[id] = $(this);
            showClock(id);
        });
        function showClock(id) {
            var d = new Date;
            var h = d.getHours();
            var m = d.getMinutes();
            var s = d.getSeconds();
            var ampm = "";
            if (_options[id].bAmPm) {
                if (h > 12) {
                    h = h - 12;
                    ampm = " PM";
                } else {
                    ampm = " AM";
                }
            }
            var templateStr = _options[id].timeFormat + ampm;
            templateStr = templateStr.replace("{HH}", getDD(h));
            templateStr = templateStr.replace("{MM}", getDD(m));
            templateStr = templateStr.replace("{SS}", getDD(s));
            var obj = $("#" + id);
            obj.css("fontSize", _options[id].fontSize);
            obj.css("fontFamily", _options[id].fontFamily);
            obj.css("color", _options[id].fontColor);
            obj.css("background", _options[id].background);
            obj.css("fontWeight", _options[id].fontWeight);
            //change reading
            obj.html(templateStr)
            //toggle hands
            if (_options[id].bShowHeartBeat) {
                obj.find("#ch1").fadeTo(800, 0.1);
                obj.find("#ch2").fadeTo(800, 0.1);
            }
            setTimeout(function() {
                showClock(id)
            }, 1000);
        }

        function getDD(num) {
            return (num >= 10) ? num : "0" + num;
        }

        function refreshClock() {
            setupClock();
        }
    }
    //default values
    $.fn.MyDigitClock.defaults = {
        fontSize: '50px',
        fontFamily: 'Microsoft JhengHei, Century gothic, Arial',
        fontColor: '#ff2200',
        fontWeight: 'bold',
        background: '#fff',
        timeFormat: '{HH}<span id="ch1">:</span>{MM}<span id="ch2">:</span>{SS}',
        bShowHeartBeat: false,
        bAmPm: false
    };
};

var d = new DateJs({
    inputEl: '#date',
    el: '#date'
})
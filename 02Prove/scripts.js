$(document).ready(function () {
    $("#hexText").mouseenter(function () {

        var e = $("#hexText");

        var n = Math.floor((Math.random() * 20) + 1);
        $(e).text(n);

    });
});
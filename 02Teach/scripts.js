/********************
 * clicked()
 * when a button is clicked, alert
 */
function clicked() {
    alert("Clicked!");
}

/********************
 * jquery
 * when a button is clicked, change the color of the first .div background
 */
$(document).ready(function () {
    $("#button1").click(function () {
        var e = $("#div1Color");
        var v = e.val();
        var d = $(".divs")[0];
        $(d).css("background-color", v);
    });
});

/********************
 * changeColor()
 * when a button is clicked, change the corresponding .div background color
 */
function changeColor(num) {

    /*var e = document.getElementById("div" + num + "Color");
    var v = e.value;

    var d = document.getElementsByClassName("divs")[num-1];
    d.style.backgroundColor = v;*/

}

/********************
 * jquery
 * when a button is clicked, change the color of the first .div background
 */
$(document).ready(function () {
    $("#button3").click(function () {
        var d = $(".divs")[2];
        if($(d).is(":visible")){
            $(d).fadeOut();
        }
        else{
            $(d).fadeIn();
        }
    });
});
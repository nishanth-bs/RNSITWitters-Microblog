<!DOCTYPE html>
<html>
<head>
    <title></title>

    <script src="jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
/*$("myDiv").click(function() {
    var divHtml = $(this).html(); // notice "this" instead of a specific #myDiv
    var editableText = $("<textarea />");
    editableText.val(divHtml);
    $(this).replaceWith(editableText);
    editableText.focus();
});*/
$(function () {
    $("*").dblclick(function (e) {
        e.stopPropagation();
        var currentEle = $(this);
        var value = $(this).html();
        updateVal(currentEle, value);
    });
});

function updateVal(currentEle, value) {
    $(currentEle).html('<input class="thVal" type="text" value="' + value + '" />');
    $(".thVal").focus();
    $(".thVal").keyup(function (event) {
        if (event.keyCode == 13 ) {
            $(currentEle).html($(".thVal").val().trim());
        }
        $("*").dblclick(function(e){
        e.preventDefault();
    });

        
    });

}
</script>
</head>
<body>
    <div class="inner">1</div>
<div class="inner">1</div>
<div class="inner">1</div>
<div id="div">
    <table>
        <th>asdf</th>
        <tr><td>asd</td></tr>

        <tr><td>asd</td></tr>

        <tr><td>asd</td></tr>

        <tr><td>asd</td></tr>
    </table>
</div>

</body>
</html>
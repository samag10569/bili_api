function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            alert(e.target.result);
            $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}


function chngText(id) {
    $("#" + id).change(function () {
        $('a.' + id).text(document.getElementById(id).value);
    });

}
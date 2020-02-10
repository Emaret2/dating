$("#phone").on("keyup", function(){
    formatPhone("#phone");
});

function formatPhone(id) {
    // formats phone number
    let str = $(id).val();
    str = str.replace(/\D/g, "");

    if (str.length < 4) {
        // do nothing
    } else if (str.length < 7) {
        str = "(" + str.substring(0, 3) + ") " + str.substring(3, 6);
    } else {
        str = "(" + str.substring(0, 3) + ") " + str.substring(3, 6) + "-" + str.substring(6, 10);
    }

    $(id).val(str);
}
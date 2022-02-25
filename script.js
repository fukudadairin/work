$(function () {
    $(".start_btn").click(function () {
        const now = new Date();
        const hour = now.getHours().toString().padStart(2, "0");
        const minuit = now.getMinutes().toString().padStart(2, "0");
        $("#modal_start_time").val(hour + ":" + minuit);
    });

    $(".end_btn").click(function () {
        const now = new Date();
        const hour = now.getHours().toString().padStart(2, "0");
        const minuit = now.getMinutes().toString().padStart(2, "0");
        $("#modal_end_time").val(hour + ":" + minuit);
    });


});

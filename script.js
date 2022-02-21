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

    $("#inputModal").on("show.bs.modal", function(event) {
        // show.bs.modal：モーダル・ダイアログを開くshowメソッドを呼び出した時のイベント。
        var button = $(event.relatedTarget);
        var target_day = button.data("day");
        var day = button.closest("tr").children("th")[0].innerText;
        var start_time = button.closest("tr").children("td")[0].innerText
        var end_time = button.closest("tr").children("td")[1].innerText
        var break_time = button.closest("tr").children("td")[2].innerText
        var comment = button.closest("tr").children("td")[3].innerText
  
        $("#modal_day").text(day)
        $("#modal_start_time").val(start_time)
        $("#modal_end_time").val(end_time)
        $("#modal_break_time").val(break_time)
        $("#modal_comment").val(comment)
        $("#target_date").val(target_day)
  
        // $("#modal_start_time").removeClass("is-invalid")
        // $("#modal_end_time").removeClass("is-invalid")
        // $("#modal_break_time").removeClass("is-invalid")
        // $("#modal_comment").removeClass("is-invalid")
  
      });
  
});

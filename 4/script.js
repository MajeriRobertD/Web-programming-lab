$(document).ready(function () {
  var p = $("p");
  p.css({
    cursor: "pointer",
  });

  p.dblclick(function (e) {
    //create selection
    var range =
      window.getSelection() ||
      document.getSelection() ||
      document.selection.createRange();

    //transform selection to string
    var word = $.trim(range.toString());

    //check if the selection is a string
    if (word.length !== 0) {
      $("p").each(function () {
        //Handle special characters used in regex
        var searchregexp = new RegExp(
          word.replace(/[.*+?^${}()|[\]\\]/g, "\\$&"),
          "gi"
        );

        //$& will maintain uppercase and lowercase characters.
        $(this).html(
          $(this)
            .html()
            .replace(searchregexp, "<span class = 'highlight'>$&</span>")
        );
      });
    }

    range.collapse(this);
  });

  //function to reset the highlighting
  $("p").click(function () {
    $(".highlight").removeClass("hightlight").addClass("main");
  });
});

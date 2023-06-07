$(function () {

  // Convert Password Field To Text Field On Hover

  var passField = $(".password");

  $(".show-pass").hover(
    function () {
      passField.attr("type", "text");
    },
    function () {
      passField.attr("type", "password");
    }
  );

  // Confirmation Message On Button

  $(".confirm").click(function () {
    return confirm("Are You Sure?");
  });

  // Category View Option

  $(".cat h3").click(function () {
    $(this).next(".full-view").fadeToggle(200);
  });

  $(".option span").click(function () {
    $(this).addClass("active").siblings("span").removeClass("active");

    if ($(this).data("view") === "full") {
      $(".cat .full-view").fadeIn(200);
    } else {
      $(".cat .full-view").fadeOut(200);
    }
  });

  // Show Delete Button On Child Cats

  $(".child-link").hover(
    function () {
      $(this).find(".show-delete").fadeIn(400);
    },
    function () {
      $(this).find(".show-delete").fadeOut(400);
    }
  );
});

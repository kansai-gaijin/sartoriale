import $ from "jquery";
import LocomotiveScroll from "locomotive-scroll";

$(function () {
  const navToggles = $(".mobile-nav-button");
  const mobileMenu = $(".mobile-nav");
  const body = $("body");

  navToggles.on("click", function (e) {
    e.preventDefault();
    body.toggleClass("nav-open");
  });

  var elements = document.getElementsByTagName("a");

  for (var i = 0, len = elements.length; i < len; i++) {
    if (elements[i].target !== "_blank" && !elements[i].href.includes("#")) {
      const url = elements[i];
      elements[i].onclick = function (e) {
        $(".show").removeClass("show");
        setTimeout(function () {
          body.removeClass("loaded");
        }, 200);
        setTimeout(function () {
          window.location.href = url;
        }, 100);
      };
    }
  }

  setTimeout(() => {
    body.addClass("loaded");
    const scroll = new LocomotiveScroll({
      el: document.querySelector("[data-scroll-container]"),
      smooth: false,
      offset: ["10%", 0],
      class: "show",
    });
    scroll.on("call", (func) => {
      $(document).trigger({
        type: func[0],
        nodeObj: func[1],
      });
    });
  }, 1000);

  $(document).on("STATUS_EVENT", function (event) {
    const node = $(event.nodeObj + " .dot");
    const calcLeft = (multiplyer) => {
      let left = 0;
      if (multiplyer === 0) {
      } else {
        left = 50.6 * multiplyer - 8;
      }
      if (multiplyer === 5) {
        left = left - 5;
      }
      return left + "px";
    };
    node.each(function () {
      const value = $(this).data("value");
      $(this).css({
        "-webkit-transform": "translate(" + calcLeft(value) + ",-50%)",
      });
    });
  });
});

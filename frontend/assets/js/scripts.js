let getSliderChildren = (arrow) => {
  let slider = document.querySelector(`.slider#${arrow.getAttribute("id")}`);
  let container = slider.querySelector(".slider__container");
  return container.children
}


let prevArrows = document.querySelectorAll(".slider__arrow_left");

for (let prevArrow of prevArrows) {
    prevArrow.addEventListener('click', function() {
      let children = getSliderChildren(prevArrow)
      children[0].before(children[children.length - 1])
    });
};

let nextArrows = document.querySelectorAll(".slider__arrow_right");

for (let nextArrow of nextArrows) {
    nextArrow.addEventListener('click', function() {
      let children = getSliderChildren(nextArrow)
      children[children.length - 1].after(children[0])
    });
};
function setCookie(name, value, days) {
  var expiry = new Date();
  expiry.setTime(expiry.getTime() + (days * 24 * 60 * 60 * 1000));
  var expires = "expires=" + expiry.toUTCString();
  document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

function getCookie(name) {
  var cookieName = name + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var cookieArray = decodedCookie.split(';');
  for (var i = 0; i < cookieArray.length; i++) {
    var cookie = cookieArray[i];
    while (cookie.charAt(0) === ' ') {
      cookie = cookie.substring(1);
    }
    if (cookie.indexOf(cookieName) === 0) {
      return cookie.substring(cookieName.length, cookie.length);
    }
  }
  return "";
}

function updateCookie(name, value) {
  setCookie(name, value, 365);
}

document.getElementById('countryForm').addEventListener('change', function(event) {
  if (event.target.tagName === 'SELECT') {
    var selectedCountry = event.target.value;
    updateCookie('selectedCountry', selectedCountry);
    document.getElementById('country').value = selectedCountry;
    if (document.getElementById('checkbox-filter-input')) {
      document.getElementById('checkbox-filter-input').value = selectedCountry;
    }
	  window.location.reload();
  }
});

// document.addEventListener('DOMContentLoaded', function() {
//   var storedCountry = getCookie('selectedCountry');
//   if (storedCountry) {
//     document.getElementById('country').value = storedCountry;
//   }
// });
(function ($) {
  $(document).ready(function () {
    $('.car-img').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      asNavFor: '.car-gallery'
    });
    $('.car-gallery').slick({
      slidesToShow: 8,
      slidesToScroll: 1,
      asNavFor: '.car-img',
      arrows: false,
      dots: false,
		  focusOnSelect: true
    });
  });
	$('form#filter :checkbox').on('change', function() {
  var checkbox = $(this);
  var name = checkbox.prop('name');
  if (checkbox.is(':checked')) {
    $(':checkbox[name="' + name + '"]').not($(this)).prop({
      'checked': false,
      'required': false
    });
  }
});
}(jQuery));
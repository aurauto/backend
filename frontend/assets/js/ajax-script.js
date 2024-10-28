document.addEventListener('DOMContentLoaded', function () {
  jQuery(function ($) {
    $('.favorit-add').click(function (e) {
      e.preventDefault();
      let btnLike = $(this);
      if (!btnLike.hasClass('added')) {
        $.ajax({
          url: true_obj.ajaxurl, // обработчик
          data: {
            id: btnLike.attr('data-id'),
            action: 'likeauto'
          }, // данные
          type: 'POST', // тип запроса
          beforeSend: function (xhr) {},
          success: function (data) {
            if (data == 'Поле обновлено') {
              btnLike.addClass('added');
              btnLike.text('Удалить из избранного');
            }
          }
        });
      } else {
        $.ajax({
          url: true_obj.ajaxurl, // обработчик
          data: {
            id: btnLike.attr('data-id'),
            action: 'unlikeauto'
          }, // данные
          type: 'POST', // тип запроса
          beforeSend: function (xhr) {},
          success: function (data) {
            if (data == 'Значение удалено') {
              btnLike.removeClass('added');
              btnLike.text('Добавить в избранное');
            }
          }
        });
      }
      return false;
    });

    function likeBlock() {
      $('.like-block').click(function (e) {
        e.preventDefault();
        let btnLike = $(this);
        if (!btnLike.hasClass('added')) {
          $.ajax({
            url: true_obj.ajaxurl, // обработчик
            data: {
              id: btnLike.attr('data-id'),
              action: 'likeauto'
            }, // данные
            type: 'POST', // тип запроса
            beforeSend: function (xhr) {},
            success: function (data) {
              if (data == 'Поле обновлено') {
                btnLike.addClass('added');
              }
            }
          });
        } else {
          $.ajax({
            url: true_obj.ajaxurl, // обработчик
            data: {
              id: btnLike.attr('data-id'),
              action: 'unlikeauto'
            }, // данные
            type: 'POST', // тип запроса
            beforeSend: function (xhr) {},
            success: function (data) {
              if (data == 'Значение удалено') {
                btnLike.removeClass('added');
              }
            }
          });
        }
        return false;
      });
    }
    likeBlock();
    $('input[name="brand"]').on('change', function () {
      let inputModel = $(this);
      $.ajax({
        url: true_obj.ajaxurl, // обработчик
        data: {
          marka: inputModel.val(),
          action: 'modelfilter'
        }, // данные
        type: 'POST', // тип запроса
        beforeSend: function (xhr) {},
        success: function (data) {
          $('#models').empty();
          $('#models').html(data);
        }
      });
    });
  $('input[name="cars_type"]').on('change', function () {
      let inputModel = $(this);
      $.ajax({
        url: true_obj.ajaxurl, // обработчик
        data: {
          marka: inputModel.val(),
          action: 'carstypefilter'
        }, // данные
        type: 'POST', // тип запроса
        beforeSend: function (xhr) {},
        success: function (data) {
          $('#cars_type_list').html(data);
        }
      });
    });
    $('select[name="brand"]').on('change', function () {
      let inputModel = $(this);
      $.ajax({
        url: true_obj.ajaxurl, // обработчик
        data: {
          marka: inputModel.val(),
          action: 'modelfilter'
        }, // данные
        type: 'POST', // тип запроса
        beforeSend: function (xhr) {},
        success: function (data) {
          $('#models').empty();
          $('#models').append(data);
        }
      });
    });
    function echoProductformUrl(pageNumber = 1) {
      const currentUrl = window.location.href;
      const url = new URL(currentUrl);
      var params = new URLSearchParams(url.search);
      params.set( 'page', pageNumber );
	params.set( 'action', 'myfilter' );
      var queryString = params.toString();
      console.log(queryString);

      $.ajax({
        url: true_obj.ajaxurl, // обработчик
        data: queryString, // данные
        type: 'POST', // тип запроса
        beforeSend: function (xhr) {},
        success: function (data) {
          $('.cars-offers-block.catalog').html(data);
          if ($('input[name="new-brand"]').val()) {
            $('.auto-belarus').html($('input[name="new-brand"]').val());
          }
          $('.auto-belarus__total').html($('input[name="new-count"]').val());
          likeBlock();
          pagination();
        }
      });
      return false;
    }
    function pagination() {
      $('.pagination-number').click(function(){
        const page = $(this).text();
        console.log(page);
        echoProductformUrl(page);
      });
    }
    pagination();
    function echoProduct(page = 1, brand) {
      var filter = $('#filter');
      let filterData = filter.serialize();
      var formData = filter.serializeArray();
      var params = new URLSearchParams();
      formData.forEach(function (field) {
        if (field.value.trim() !== '') {
          params.append(field.name, field.value);
        }
      });
      params.append('page', page);
      if (brand) {
        if(!params.has('brand')){
          params.append('brand', brand);
        } else {
          searchParams.delete("brand");
          params.append('brand', brand);
        } 
      }
      console.log('Success:', queryString);
      var queryString = params.toString();
      var stateObj = {
        action: 'submitForm',
        queryString: queryString
      };
      history.pushState(stateObj, 'Submit Form', '?' + queryString);
      console.log(queryString);
      $.ajax({
        url: true_obj.ajaxurl, // обработчик
        data: queryString, // данные
        type: 'POST', // тип запроса
        beforeSend: function (xhr) {
          filter.find('button.call').text('Загружаю...'); // изменяем текст кнопки
        },
        success: function (data) {
          filter.find('button.call').text('Применить'); // возвращаеи текст кнопки
          $('.cars-offers-block').html(data);
          $('.cars-offers-block').scroll();
          if ($('input[name="new-brand"]').val()) {
            $('.auto-belarus').html($('input[name="new-brand"]').val());
          }
          $('.auto-belarus__total').html($('input[name="new-count"]').val());
          likeBlock();
          pagination();
        }
      });
      return false;
    }
    window.addEventListener('popstate', function (event) {
      if (event.state && event.state.action === 'submitForm') {
        console.log('Back to previous state:', event.state.queryString);
        // Использование функции
        // const url = new URL(document.location);
        // const searchParams = url.searchParams;
        // searchParams.delete('action');
        // window.history.pushState({}, '', url.toString());
        // history.pushState(null, null, event.state.queryString);
        echoProductformUrl();
      }
    });
    echoProductformUrl();
    $('#filter').submit(function (event) {
      event.preventDefault();
      echoProduct();
    });
    $('.brand-auto__link').click(function(event){
      event.preventDefault();
      const brand = $(this).attr('data-brand');
      echoProduct(1, brand);
    });
    $('.save-block').click(function (event) {
      event.preventDefault();
      var queryString = location.search.substring(1);
      var params = new URLSearchParams(queryString);

      var getParams = {};
      params.forEach(function (value, key) {
        getParams[key] = value;
      });

      $.ajax({
        url: true_obj.ajaxurl, // обработчик
        data: {
          params: getParams,
          action: 'saveSelection'
        }, // данные
        type: 'POST', // тип запроса
        beforeSend: function (xhr) {},
        success: function (data) {
          console.log(data);
          if (data == 'Сохранено') {
            alert('Подборка сохранена');
          }
        }
      });
    });
    $('#checkbox-filter-input').click(function () {
      if ($(this).prop('checked')) {
        let currentCountry = $(this).val();
        $('input[name="country"][value="' + currentCountry + '"]').prop('checked', true);
        $('#filter button.call').click();
      }
    });

    $('#money-choose').on('change', function () {
      let currency = $(this);
      $.ajax({
        url: true_obj.ajaxurl, // обработчик
        data: {
          currency: currency.val(),
          price: currency.attr('data-price'),
          action: 'currencychange'
        }, // данные
        type: 'POST', // тип запроса
        beforeSend: function (xhr) {},
        success: function (data) {
          console.log(data);
          $('.auto-belarus__total').text(data);
        }
      });
    });
    $('.contact-seller.write').click(function () {
      var buttonId = 'two';
      const linkAnnouncement = $(this).attr('data-link');
      $('#modal-container').removeAttr('class').addClass(buttonId);
      $('body').addClass('modal-active');
      $('.modal .send-message').attr('href', linkAnnouncement);
    })

    $('#modal-container').click(function (event) {
      if (!$(event.target).closest(".modal,.js-open-modal").length) {
        $(this).addClass('out');
        $('body').removeClass('modal-active');
      }
    });
    $('.modal-close').click(function (event) {
        $(this).parents('#modal-container').addClass('out');
        $('body').removeClass('modal-active');
    });
  });
});
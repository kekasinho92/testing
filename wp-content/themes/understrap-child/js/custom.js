var swiper = new Swiper('.swiper-container', {
	//loop: true,
	slidesPerView: 'auto',
    spaceBetween: 30,
    lazy: true,
    pagination: {
        el: '.swiper-pagination',
        type: 'progressbar',
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
  	}
});

jQuery("#add-img-btn").click(function(evt) {
    evt.preventDefault();
    var inputs = jQuery("#add-post-form input[type=file]");
    for (var i = 0; i < inputs.length; i ++) {
        var parent = jQuery(inputs[i]).parent(".form-group-file");
        if (jQuery(parent).is(":hidden")) {
            jQuery(parent).slideDown();
            if (i == inputs.length - 1) {
                jQuery("#add-img-btn").fadeOut();
            }
            break;
        }  
    }
});

// Описываем общие установки для всех ajax-запросов
jQuery.ajaxSetup({
    type: 'POST', // метод передачи данных
    dataType: 'json', // тип ожидаемых данных в ответе
    beforeSend: function(){ // Функция вызывается перед отправкой запроса
        console.debug('Запрос отправлен. Ждите ответа.');
        jQuery("#add-post-btn").text('Добавление...');
    },
    error: function(req, text, error){ 
        console.error('Упс! Ошибочка: ' + text + ' | ' + error);
    },
    complete: function(json) {
        console.log(json.responseText); 
        console.debug('Запрос полностью завершен!');
        jQuery("#add-post-form").fadeOut();
        jQuery("p.success-message").fadeIn();
    }
});

var files; // переменная. будет содержать данные файлов

// заполняем переменную данными, при изменении значения поля file 
// jQuery('input[type=file]').on('change', function(){
//     files.push(this.files);
//     //files = this.files;
// });

var files1, files2, files3, files4, files5, files6, files7, files8, files9, files10;
jQuery('input#formImg1').on('change', function(){
    files1 = this.files;
});
jQuery('input#formImg2').on('change', function(){
    files2 = this.files;
});
jQuery('input#formImg3').on('change', function(){
    files3 = this.files;
});
jQuery('input#formImg4').on('change', function(){
    files4 = this.files;
});
jQuery('input#formImg5').on('change', function(){
    files5 = this.files;
});
jQuery('input#formImg6').on('change', function(){
    files6 = this.files;
});
jQuery('input#formImg7').on('change', function(){
    files7 = this.files;
});
jQuery('input#formImg8').on('change', function(){
    files8 = this.files;
});
jQuery('input#formImg9').on('change', function(){
    files9 = this.files;
});
jQuery('input#formImg10').on('change', function(){
    files10 = this.files;
});





jQuery("#add-post-form").on("submit", function(evt){
    evt.preventDefault();
    var formUrl = jQuery(this).attr('action');

    // создадим объект данных формы
    var data = new FormData();

    //заполняем объект данных файлами в подходящем для отправки формате
    jQuery.each( files1, function( key, value ){
        data.append( 'img1', value );
    });
    jQuery.each( files2, function( key, value ){
        data.append( 'img2', value );
    });
    jQuery.each( files3, function( key, value ){
        data.append( 'img3', value );
    });
    jQuery.each( files4, function( key, value ){
        data.append( 'img4', value );
    });
    jQuery.each( files5, function( key, value ){
        data.append( 'img5', value );
    });
    jQuery.each( files6, function( key, value ){
        data.append( 'img6', value );
    });
    jQuery.each( files7, function( key, value ){
        data.append( 'img7', value );
    });
    jQuery.each( files8, function( key, value ){
        data.append( 'img8', value );
    });
    jQuery.each( files9, function( key, value ){
        data.append( 'img9', value );
    });
    jQuery.each( files10, function( key, value ){
        data.append( 'img10', value );
    });

    data.append('title', jQuery('input#formTitle').val());
    data.append('city', jQuery('select#formCity').val());
    data.append('address', jQuery('input#formAddress').val());
    data.append('ac_type', jQuery('select#formType').val());
    data.append('area', jQuery('input#formArea').val());
    data.append('livingArea', jQuery('input#formLivingArea').val());
    data.append('floor', jQuery('input#formFloor').val());
    data.append('price', jQuery('input#formPrice').val());
    data.append('description', jQuery('textarea#formContent').val());
    data.append('sended', '1');
    // добавим переменную для идентификации запроса
    data.append('uploaded_files', 1 );

    console.log(data);

    jQuery.ajax({
        contentType: false,
        processData: false,
        url: formUrl,
        method: 'post',
        dataType: 'json',
        data: data
    });
});

function afterAjax(json) {
    //jQuery("#add-post-form").fadeOut();
    //jQuey(".success-message").text(data);
    //jQuey(".success-message").fadeIn();
    //console.log(json);
    //jQuery(".add-post").append(json);
}
jQuery(document).ready(function(){
  addButtonConsultar();
  appendLinkSendByMail();
  languageStock();
  changeReadMoreBtnBlog();
  menuCategories();
  changeTexts();
});

function addButtonConsultar(){
  jQuery('.woocommerce-product-details__short-description + .stock').after('<a class="btn-consultar" href="#" onclick="openBoxConsultar(); return false;">Consultar</a>');
}

function appendLinkSendByMail(){
  var link = window.location.href;
  jQuery('.smarket-single-product-socials').after('<a class="link-send-mail" href="mailto:?subject=Mirá este producto!&body=Hola, te invito a visitar este producto:'+link+'">Enviar por mail &#62;</a>');
}

function languageStock(){
  jQuery('.entry-summary .block-stock .title').text('ESTADO: ');
}

function changeReadMoreBtnBlog(){
  if(jQuery('body').hasClass('blog')){
    jQuery('.post-item .post-item-info .button .text').text('Leer más');
    jQuery('.simple-theme.wp-posts-carousel .wp-posts-carousel-buttons a').text('Ver más');
  }
}

function menuCategories(){
  console.log(jQuery('body').attr('data-url'));
  console.log(window.location.href);
  if(jQuery('body').attr('data-url') == window.location.href){
    var flag = false;
    jQuery(window).scroll(function(){
      if(jQuery(window).scrollTop() > 133){

        jQuery(".block-nav-categori .block-title").on("click",function(){
          jQuery(this).toggleClass("active");
          jQuery(this).parent().toggleClass("has-open");
          jQuery("body").toggleClass("categori-open")
        });

        if(flag == false){
          flag = true;
          jQuery(".block-nav-categori .block-title").toggleClass("active");
          jQuery(".block-nav-categori .block-title").parent().toggleClass("has-open");
          jQuery("body").toggleClass("categori-open");
        }

      }else{

        if(flag == true){
          flag = false;
          jQuery(".block-nav-categori .block-title").toggleClass("active");
          jQuery(".block-nav-categori .block-title").parent().toggleClass("has-open");
          jQuery("body").toggleClass("categori-open");
        }

      }
    })
  }else {

    jQuery(".block-nav-categori .block-title").removeClass("active");
    jQuery(".block-nav-categori .block-title").parent().removeClass("has-open");
    jQuery("body").removeClass("categori-open");

    jQuery(".block-nav-categori .block-title").on("click",function(){
      jQuery(this).toggleClass("active");
      jQuery(this).parent().toggleClass("has-open");
      jQuery("body").toggleClass("categori-open")
    });
  }

}

function changeTexts(){
  jQuery('.form-search .input').attr('placeholder', 'Ingrese su búsqueda');
  jQuery('.onnew span').text('Nuevo');
}

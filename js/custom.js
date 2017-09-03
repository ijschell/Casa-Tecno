jQuery(document).ready(function(){
  addButtonConsultar();
  appendLinkSendByMail();
  languageStock();
  changeReadMoreBtnBlog();
})

function addButtonConsultar(){
  jQuery('.woocommerce-product-details__short-description + .stock').after('<a class="btn-consultar" href="#" onclick="openBoxConsultar(); return false;">Consultar</a>');
}

function appendLinkSendByMail(){
  var link = window.location.href;
  console.log(link);
  jQuery('.smarket-single-product-socials').after('<a class="link-send-mail" href="mailto:?subject=Mirá este producto!&body=Hola, te invito a visitar este producto:'+link+'">Enviar por mail &#62;</a>');
}

function languageStock(){
  jQuery('.entry-summary .block-stock .title').text('ESTADO: ');
}

function changeReadMoreBtnBlog(){
  if(jQuery('body').hasClass('blog')){
    jQuery('.post-item .post-item-info .button .text').text('Leer más');
  }
}

$(document).ready(function () {
  $('[data-toggle="offcanvas"]').click(function () {
    $('.row-offcanvas').toggleClass('active')
  });
});

//Акордіон меню категорій статтей
$('#article-category').dcAccordion({
    speed: 300,
    disableLink: false,
    //showCount : true,
});


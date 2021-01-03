$(document).change(function(){
    $('.slider').slick({
        arrows:true,
        dots:true,
        slidesToShow:1,
        autoplay:true,
        speed:1000,
        autoplaySpeed:5000,
        responsive:[
            {
                breakpoint: 768,
                settings: {
                    slidesToShow:2
                }
            },
            {
                breakpoint: 550,
                settings: {
                    slidesToShow:1
                }
            }
        ]
    });
});
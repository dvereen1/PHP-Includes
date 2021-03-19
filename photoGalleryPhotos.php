<?php




//Array which contains the photos and their information

$photoGalleryArray = [
    [
        "imgs/P1010430.jpg",
        "Shoe Image",
    ],
    [
        "imgs/P1010327.jpg",
        "Shoe Image",
    ],
    [
        "imgs/P1010415.jpg",
        "Shoe Image",
    ],
    [
        "imgs/P1010428.jpg",
        "Shoe Image",
    ],
    [
        "imgs/P1010425.jpg",
        "Shoe Image",
    ],
    [
        "imgs/P1010436.jpg",
        "Shoe Image",
    ],
    [
        "imgs/P1010324.jpg",
        "Shoe Image",
    ],
];


/*
    The HTML layout of the photo gallery page to prevent repitition
 */

 
  /* 
    Creates the image card of the photo gallery
    @param $cardImgSrc - the path of the image
    @param $cardImgAlt - the alternate text of the image;
  */



function createImgCard($cardImgSrc, $cardImgAlt, $count){

    $imgCard = "<div class = \"photo djv-col-r\">
                    <img src = $cardImgSrc alt = $cardImgAlt draggable = 'false' data_num = '$count'>  
                    <div class = \"expand-img\">
                        <button class = \"expand-img-btn\"><i class=\"fas fa-expand-arrows-alt\"></i></button>
                    </div>
                </div>";
  
    echo $imgCard;

}


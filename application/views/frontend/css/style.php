 <?php 
// error_reporting(E_ALL);
// ini_set("display_errors", '1');

// $primaryColor= "#000";
// $secondaryColor= "#9F0C10";
// $lightPrimary= "#ff774b";
// $lightColor= "#fff";
// $borderColor= "#006598";
// $borderColor= "#006598";
// $borderColor2= "#9F0C10"; 

// error_reporting(E_ALL);
// ini_set("display_errors",1);

if($_SERVER['SERVER_NAME']=='development.launchestore.com'){   
    $primaryColor= "#0685c5";
    $secondaryColor= "#04527A";
    $lightColor= "#fff";
    $borderColor= "#006598";
    $darkHeaderBackground = "#e1eaf4";
    $navbarColor = "#FFF";
    $cartBtnBackground = "#9f0c10";
    $cartBtnColor = "#fff";
    $loginBtnBackground = "#9f0c10";
    $loginBtnColor = "#fff";
    $loginBtnborder = "#fff";
    $logoWidth = "150px";
    $abtImgWidth = "350px";
    $hvrClr = "#04527A";
}

elseif($_SERVER['SERVER_NAME']=='development.launchestore.com'){
  
    $primaryColor= "#0685c5";
    $secondaryColor= "#04527A";
    $lightColor= "#fff";
    $borderColor= "#006598";
    $darkHeaderBackground = "#e1eaf4";
    $navbarColor = "#FFF";
    $cartBtnBackground = "#9f0c10";
    $cartBtnColor = "#fff";
    $loginBtnBackground = "#9f0c10";
    $loginBtnColor = "#fff";
    $loginBtnborder = "#fff";
    $logoWidth = "150px";
    $hvrClr = "#04527A";
}
elseif($_SERVER['SERVER_NAME']=='anandgarden.com' || $_SERVER['SERVER_NAME']=='www.anandgarden.com' ){
  
    $primaryColor= "#507b14";
    $secondaryColor= "#507b14";
    $lightColor= "#fff";
    $borderColor= "#35520c";
    $darkHeaderBackground = "#fff";
    $navbarColor = "#FFF";
    $cartBtnBackground = "#58821f";
    $cartBtnColor = "#fff";
    $loginBtnBackground = "#58821f";
    $loginBtnColor = "#fff";
    $loginBtnborder = "#35520c";
    $logoWidth = "250px";
    $hvrClr = "#04527A";
}


elseif($_SERVER['SERVER_NAME']=='mehtaenterpriseonline.com' || $_SERVER['SERVER_NAME']=='www.mehtaenterpriseonline.com'){  
    $primaryColor= "#0685c5";
    $secondaryColor= "#04527A";
    $lightPrimary= "#ff774b";
    $lightColor= "#fff";
    $borderColor= "#006598";
    $borderColor2= "#00314a";
    $darkHeaderBackground = "#e1eaf4";
    $navbarColor = "#818181";
    $cartBtnBackground = "#04527a";
    $cartBtnColor = "#fff";
    $loginBtnBackground = "#04527a";
    $loginBtnColor = "#fff";
    $loginBtnborder = "#00314a";
    $logoWidth = "150px";
    $hvrClr = "#04527A";
}

elseif($_SERVER['SERVER_NAME']=='mehta.launchestore.com' ){
    $primaryColor= "#0685c5";
    $secondaryColor= "#04527A";
    $lightPrimary= "#ff774b";
    $lightColor= "#fff";
    $borderColor= "#006598";
    $borderColor2= "#9F0C10";
    $darkHeaderBackground = "#e1eaf4";
    $navbarColor = "#818181";
    $cartBtnBackground = "#9f0c10";
    $cartBtnColor = "#fff";
    $loginBtnBackground = "#9f0c10";
    $loginBtnColor = "#fff";
    $loginBtnborder = "#00314a";
     $logoWidth = "150px";
     $hvrClr = "#04527A";

}

elseif($_SERVER['SERVER_NAME']=='bmart.launchestore.com'){
    $primaryColor= "#e30016";
    $secondaryColor= "#373854";
    $lightPrimary= "#ff774b";
    $lightColor= "#fff";
    $borderColor= "#e30016";
    $borderColor2= "#121328";
    $darkHeaderBackground = "#e30016";
    $navbarColor = "#FFF";
    $cartBtnBackground = "#fff";
    $cartBtnColor = "#373854";
    $loginBtnBackground = "#ffffff";
    $loginBtnColor = "#373854";
    $loginBtnborder = "#fff";
    // $lightHeaderColor = "fff"; 
 	$logoWidth = "150px";
 	$hvrClr = "#373854";
}

elseif($_SERVER['SERVER_NAME']=='bmartsupermarket.in' || $_SERVER['SERVER_NAME']=='www.bmartsupermarket.in'){
    $primaryColor= "#e30016";
    $secondaryColor= "#373854";
    $lightPrimary= "#ff774b";
    $lightColor= "#fff";
    $borderColor= "#e30016";
    $borderColor2= "#121328";
    $darkHeaderBackground = "#e30016";
    $navbarColor = "#FFF";
    $cartBtnBackground = "#fff";
    $cartBtnColor = "#373854";
    $loginBtnBackground = "#ffffff";    
    $loginBtnColor = "#373854";
    $loginBtnborder = "#fff";
    // $lightHeaderColor = "fff"; 
    $logoWidth = "150px";
    $hvrClr = "#373854";
}

elseif($_SERVER['SERVER_NAME']=='bigbucket.launchestore.com'|| $_SERVER['SERVER_NAME']=='thebigbucket.in' || $_SERVER['SERVER_NAME']=='www.thebigbucket.in'){
    $primaryColor= "#8dc342";
    $secondaryColor= "#000";
    $lightPrimary= "#ff774b";
    $lightColor= "#fff";
    $borderColor= "#599900";
    $borderColor2= "#121328";
    $darkHeaderBackground = "#e1eaf4";
    $navbarColor = "#818181";
    $cartBtnBackground = "#000";
    $cartBtnColor = "#fff";
    $loginBtnBackground = "#000";
    $loginBtnColor = "#fff";
    $loginBtnborder = "#000";
    // $lightHeaderColor = "fff"; 
    $logoWidth = "150px";
    $hvrClr = "#000";
    $cartNum = "#000";
}


elseif($_SERVER['SERVER_NAME']=='shukantea.com' || $_SERVER['SERVER_NAME']=='www.shukantea.com'){
    $primaryColor= "#000";
    $secondaryColor= "#9F0C10";
    $lightPrimary= "#ff774b";
    $lightColor= "#fff";
    $borderColor= "#000";
    $borderColor2= "#000"; 
    $darkHeaderBackground = "#e1eaf4";
    $navbarColor = "#818181";
    $cartBtnBackground = "#9f0c10";
    $cartBtnColor = "#fff";
    $loginBtnBackground = "#9f0c10";
    $loginBtnColor = "#fff";
    $loginBtnborder = "#540002";
    $logoWidth = "150px";
    $abtImgWidth = "450px";
    $hvrClr = "#9F0C10";
}

elseif($_SERVER['SERVER_NAME']=='magnus.launchestore.com'){
    $primaryColor= "#fd4f00";
    $secondaryColor= "#006c68";
    $lightPrimary= "#ff774b";
    $lightColor= "#fff";
    $borderColor= "#c73d00";
    $borderColor2= "#004846";
    $darkHeaderBackground = "#e1eaf4";
    $navbarColor = "#818181";
    $cartBtnBackground = "#006c68";
    $cartBtnColor = "#fff";
    $loginBtnBackground = "#006c68";
    $loginBtnColor = "#fff";
    $loginBtnborder = "#004846";
    $logoWidth = "150px";
    $hvrClr = "#006c68";


// $primaryColor= "#000";
// $secondaryColor= "#9F0C10";
// $lightPrimary= "#ff774b";
// $lightColor= "#fff";
// $borderColor= "#006598";
// $borderColor= "#006598";
// $borderColor2= "#9F0C10"; 

}elseif($_SERVER['SERVER_NAME']=='laxmiraj.launchestore.com' || $_SERVER['SERVER_NAME'] == 'laxmirajdryfruit.com' || $_SERVER['SERVER_NAME'] == 'www.laxmirajdryfruit.com'){
    $primaryColor= "#004A99";
    $secondaryColor= "#002042";
    $lightPrimary= "#ff774b";
    $lightColor= "#fff";
    $borderColor= "#002247";
    $borderColor2= "#043d79";
    $darkHeaderBackground = "#fff";
    $navbarColor = "#818181";
    $cartBtnBackground = "#0c65c5";
    $cartBtnColor = "#fff";
    $loginBtnBackground = "#0c65c5";
    $loginBtnColor = "#fff";
    $loginBtnborder = "#043d79";
    $logoWidth = "150px";
    $hvrClr = "#0c65c5";


// $primaryColor= "#000";
// $secondaryColor= "#9F0C10";
// $lightPrimary= "#ff774b";
// $lightColor= "#fff";
// $borderColor= "#006598";
// $borderColor= "#006598";
// $borderColor2= "#9F0C10"; 
 

}

//#2ebc41
//#0f8b1f
elseif($_SERVER['SERVER_NAME']=='ogworld.launchestore.com'){

    $primaryColor= "#2ebc41";
    $secondaryColor= "#000";
    $lightPrimary= "#ff774b";
    $lightColor= "#fff";
    $borderColor= "#0f8b1f";
    $borderColor2= "#043d79";
    $darkHeaderBackground = "#e1eaf4";  
    // $headerBackground = "#fff";
    $navbarColor = "#818181";
    $cartBtnBackground = "#2ebc41";
    $cartBtnColor = "#fff";
    $loginBtnBackground = "#2ebc41";
    $loginBtnColor = "#fff";
    $loginBtnborder = "#0f8b1f";
    $logoWidth = "150px";
    $hvrClr = "#0c65c5";
}elseif($_SERVER['SERVER_NAME']=='unibest.in' || $_SERVER['SERVER_NAME'] == 'www.unibest.in'){

    $primaryColor= "#C41E49";
    $secondaryColor= "#000";
    $lightPrimary= "#ff774b";
    $lightColor= "#fff";
    $borderColor= "#C41E49";
    $borderColor2= "#043d79";
    $darkHeaderBackground = "#e1eaf4";  
    // $headerBackground = "#fff";
    $navbarColor = "#818181";
    $cartBtnBackground = "#C41E49";
    $cartBtnColor = "#fff";
    $loginBtnBackground = "#C41E49";
    $loginBtnColor = "#fff";
    $loginBtnborder = "#C41E49";
    $logoWidth = "100px";
    $hvrClr = "#294695";
    $cartpopColor = "#000";
}

elseif($_SERVER['SERVER_NAME']=='iwingzy.launchestore.com'){
    $primaryColor= "#ed1c24";
    $secondaryColor= "#000";
    $lightPrimary= "#ff774b";
    $lightColor= "#fff";
    $borderColor= "#c73d00";
    $borderColor2= "#004846";
    $darkHeaderBackground = "#f3f3f3";
    $navbarColor = "#818181";
    $cartBtnBackground = "#ed1c24";
    $cartBtnColor = "#fff";
    $loginBtnBackground = "#ed1c24";
    $loginBtnColor = "#fff";
    $loginBtnborder = "#ed1c24";
    $logoWidth = "150px";
    $hvrClr = "#ed1c24";


// $primaryColor= "#000";
// $secondaryColor= "#9F0C10";
// $lightPrimary= "#ff774b";
// $lightColor= "#fff";
// $borderColor= "#006598";
// $borderColor= "#006598";
// $borderColor2= "#9F0C10"; 

}


elseif($_SERVER['SERVER_NAME']=='www.iwingzy.in' || $_SERVER['SERVER_NAME']=='iwingzy.in'){
    $primaryColor= "#ed1c24";
    $secondaryColor= "#000";
    $lightPrimary= "#ff774b";
    $lightColor= "#fff";
    $borderColor= "#c73d00";
    $borderColor2= "#004846";
    $darkHeaderBackground = "#f3f3f3";
    $navbarColor = "#818181";
    $cartBtnBackground = "#ed1c24";
    $cartBtnColor = "#fff";
    $loginBtnBackground = "#ed1c24";
    $loginBtnColor = "#fff";
    $loginBtnborder = "#ed1c24";
    $logoWidth = "150px";
    $hvrClr = "#ed1c24";



}

elseif($_SERVER['SERVER_NAME']=='www.dpdecor.launchestore.com'){
    $primaryColor= "#16aa9c";
    $secondaryColor= "#000";
    $lightPrimary= "#ff774b";
    $lightColor= "#fff";
    $borderColor= "#c73d00";
    $borderColor2= "#004846";
    $darkHeaderBackground = "#f3f3f3";
    $navbarColor = "#818181";
    $cartBtnBackground = "#16aa9c";
    $cartBtnColor = "#fff";
    $loginBtnBackground = "#16aa9c";
    $loginBtnColor = "#fff";
    $loginBtnborder = "#ed1c24";
    $logoWidth = "150px";
    $hvrClr = "#ed1c24";

}




elseif($_SERVER['SERVER_NAME']=='ori.launchestore.com' || $_SERVER['SERVER_NAME'] == 'ugiftonline.com' || $_SERVER['SERVER_NAME'] == 'www.ugiftonline.com'){
 
    $primaryColor= "#E50914";
    $secondaryColor= "#000";
    $lightPrimary= "#ff774b";
    $lightColor= "#fff";
    $borderColor= "#710006";
    $borderColor2= "#004846";
    $darkHeaderBackground = "#222";
    $navbarColor = "#818181";
    $cartBtnBackground = "#E50914";
    $cartBtnColor = "#fff";
    $loginBtnBackground = "#E50914";
    $loginBtnColor = "#fff";
    $loginBtnborder = "#b50009";
    $logoWidth = "90px";
    $abtImgWidth = "350px";
    $hvrClr = "#fff";
}

else{
    $primaryColor= "#E50914";
    $secondaryColor= "#000";
    $lightPrimary= "#ff774b";
    $lightColor= "#fff";
    $borderColor= "#710006";
    $borderColor2= "#004846";
    $darkHeaderBackground = "#222";
    $navbarColor = "#818181";
    $cartBtnBackground = "#E50914";
    $cartBtnColor = "#fff";
    $loginBtnBackground = "#E50914";
    $loginBtnColor = "#fff";
    $loginBtnborder = "#b50009";
    $logoWidth = "75px";
	$abtImgWidth = "350px";
	$hvrClr = "#fff";
    $cartNum = "#000";
}

// else{
//     $primaryColor= "#000";
//     $secondaryColor= "#9F0C10";
//     $lightPrimary= "#ff774b";
//     $lightColor= "#fff";
//     $borderColor= "#006598";
//     $borderColor= "#006598";
//     $borderColor2= "#9F0C10"; 
//     $darkHeaderBackground = "#373854";
//     $navbarColor = "#FFF";
//     $cartBtnBackground = "#9f0c10";
//     $cartBtnColor = "#fff";
//     $loginBtnBackground = "#9f0c10";
//     $loginBtnColor = "#fff";
//     $loginBtnborder = "#000";
//     $logoWidth = "150px";
//     $cartNum = "green";
// }   

?>




<style type="text/css">
/*:root {
  --primary-color: #000;
  --secondary-color: #9F0C10;
  --light-color: #fff;
  --border-color: #000;
  --border-color2: #9F0C10;
  --lightPrimary: #ff774b;
    }*/



/* <?php if ($_SERVER['SERVER_NAME']=='ori.launchestore.com') { ?>
.sec_navbar ul li a:hover {
    color: var(--hvrClr) !important;
    }
<?php   } ?>

*/

:root {
  --primary-color: <?=$primaryColor?>;
  --secondary-color: <?=$secondaryColor?>;
  --light-color:  <?=$lightColor?>;
  --border-color: <?=$borderColor?>;
  --border-color2: <?=$borderColor2?>;
  --lightPrimary: <?=$lightPrimary?>;
  --headerBackground : <?=$darkHeaderBackground?>;
  --navbarColor : <?=$navbarColor?>;
  --cartBtnBackground: <?=$cartBtnBackground?>;
  --cartBtnColor:<?=$cartBtnColor?>;
  --loginBtnBackground:<?=$loginBtnBackground?>; 
  --loginBtnColor:<?=$loginBtnColor?>;
  --loginBtnborder:<?=$loginBtnborder?>;
  --logoWidth : <?=$logoWidth?>;
  --abtImgWidth: <?=$abtImgWidth?>;
  --hvrClr: <?=$hvrClr?>;
  --cartNum:  <?=$cartNum?>;
}

/*
.feature-bottom-wrap .quantity-wrap.transparent-wrap{
    position:relative;
    width:100% !important;
    height: 100% !important;
    z-index: 2;

}

.feature-bottom-wrap .quantity-wrap.transparent-wrap::before{
    content:"";
    position:absolute;
    width:100%;
    height: 100%;
    background: transparent;
    z-index: 5000000009999999;
    left: 0;
    top: 0;
}*/

    @font-face {
    font-family: 'OpenSans-Light';
    src: url('../../../public/frontend/assets/fonts/OpenSans-Light.eot');
    src: url('../../../public/frontend/assets/fonts/OpenSans-Light.eot?#iefix') format('embedded-opentype'),
        url('../../../public/frontend/assets/fonts/OpenSans-Light.woff2') format('woff2'),
        url('../../../public/frontend/assets/fonts/OpenSans-Light.woff') format('woff'),
        url('../../../public/frontend/assets/fonts/OpenSans-Light.ttf') format('truetype');
    font-weight: 300;
    font-style: normal;
    font-display: swap;
}

@font-face {
    font-family: 'OpenSans-SemiBold';
    src: url('../../../public/frontend/assets/fonts/OpenSans-SemiBold.eot');
    src: url('../../../public/frontend/assets/fonts/OpenSans-SemiBold.eot?#iefix') format('embedded-opentype'),
        url('../../../public/frontend/assets/fonts/OpenSans-SemiBold.woff2') format('woff2'),
        url('../../../public/frontend/assets/fonts/OpenSans-SemiBold.woff') format('woff'),
        url('../../../public/frontend/assets/fonts/OpenSans-SemiBold.ttf') format('truetype');
    font-weight: 600;
    font-style: normal;
    font-display: swap;
}

@font-face {
    font-family: 'OpenSans-Regular';
    src: url('../../../public/frontend/assets/fonts/OpenSans-Regular.eot');
    src: url('../../../public/frontend/assets/fonts/OpenSans-Regular.eot?#iefix') format('embedded-opentype'),
        url('../../../public/frontend/assets/fonts/OpenSans-Regular.woff2') format('woff2'),
        url('../../../public/frontend/assets/fonts/OpenSans-Regular.woff') format('woff'),
        url('../../../public/frontend/assets/fonts/OpenSans-Regular.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
    font-display: swap;
}

@font-face {
    font-family: 'OpenSans-Bold';
    src: url('../../../public/frontend/assets/fonts/OpenSans-Bold.eot');
    src: url('../../../public/frontend/assets/fonts/OpenSans-Bold.eot?#iefix') format('embedded-opentype'),
        url('../../../public/frontend/assets/fonts/OpenSans-Bold.woff2') format('woff2'),
        url('../../../public/frontend/assets/fonts/OpenSans-Bold.woff') format('woff'),
        url('../../../public/frontend/assets/fonts/OpenSans-Bold.ttf') format('truetype');
    font-weight: bold;
    font-style: normal;
    font-display: swap;
}

@font-face {
    font-family: 'OpenSans-ExtraBold';
    src: url('../../../public/frontend/assets/fonts/OpenSans-ExtraBold.eot');
    src: url('../../../public/frontend/assets/fonts/OpenSans-ExtraBold.eot?#iefix') format('embedded-opentype'),
        url('../../../public/frontend/assets/fonts/OpenSans-ExtraBold.woff2') format('woff2'),
        url('../../../public/frontend/assets/fonts/OpenSans-ExtraBold.woff') format('woff'),
        url('../../../public/frontend/assets/fonts/OpenSans-ExtraBold.ttf') format('truetype');
    font-weight: 800;
    font-style: normal;
    font-display: swap;
}

/*==============================*/
     /*-----2. COMMON CSS-----*/
/*==============================*/

/*body::-webkit-scrollbar {
  width:7px;
}
body::-webkit-scrollbar-track {
  background: #e1eaf4;
  height: 5px;
}
body::-webkit-scrollbar-thumb {
  background-color: var(--secondary-color);
  border-radius: 10px;

    }
*/
.error.profileimage {
    display: block;
    text-align: center;
}

*{
    padding: 0px;
    margin: 0px;
    box-sizing: border-box;
}

body{
     font-family: 'OpenSans-Regular';
}

.   error{
    display: none;
}

input:-webkit-autofill,
input:-webkit-autofill:hover, 
input:-webkit-autofill:focus, 
input:-webkit-autofill:active  {
  transition: background-color 5000s;
  background:  transparent !important;
  -webkit-background:  transparent !important;
    text-fill-color: #666 !important;
   -webkit-text-fill-color: #666 !important;
}


textarea:-webkit-autofill,
textarea:-webkit-autofill:hover, 
textarea:-webkit-autofill:focus, 
textarea:-webkit-autofill:active  {
  transition: background-color 5000s;
  background:  transparent !important;
  -webkit-background:  transparent !important;
  text-fill-color: #666 !important;
   -webkit-text-fill-color: #666 !important;
}

textarea {
    resize: none;
}
.backdrop{
    position: absolute;
    width: 100%;
    height: 100%;
    background-color: rgb(0 0 0 / 50%);
    z-index: 0;
    top: 0;
    left: 0;
}

.backdrop_bg{
    position: fixed;
    width: 100%;
    height: 100%;
    background-color: rgb(0 0 0 / 50%);
    z-index: 1;
    top: 0;
    left: 0;
}

a:hover{
    text-decoration: none;
}
.btn.focus, .btn:focus {
    outline: 0;
    box-shadow: none;
}
button:focus{
    border: 0px;
    box-shadow: none;
    outline: 0px; 
}

input:focus{
    border: 0px;
    box-shadow: none;
    outline: 0px; 
}

textarea:focus{
    border: 0px;
    box-shadow: none;
    outline: 0px; 
}
.form-control[readonly] {
    background-color: transparent;
    opacity: 1;
}

.btn{
    width: 155px;
    height: 50px;
    background-color: var(--primary-color);
    border: 1px solid var(--border-color);
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
    text-transform: capitalize;
    font-family: 'OpenSans-Bold';
    transition: 0.5s;
    box-shadow: 0px 0px 14px 2px rgb(11 51 67 / 15%);
}

/*.btn-orange{
    background-color: #f55d2c;
    border: 1px solid #f55d2c;
}*/

/*.btn-orange:hover{
    background-color: #fff;
    color: #f55d2c !important;
}*/

.btn:hover{
    background-color: #fff;
    color: var(--primary-color);
    border-color: var(--border-color);
}

.p-100{
    padding: 100px 0px;
}

.p-50 {
    padding: 50px 0px; 
}

.bg-light-blue{
     background-color:#e1eaf4;
}

.bg-cream{
    background-color:#f7f7f7;
}

.bg-white{
    background-color: #fff;
}

.bg-blue{
    background-color: var(--primary-color);
}

.form-control:focus{
    border: 0px;
    box-shadow: none;
}

.page-title h1{
    color: var(--secondary-color);
    font-size: 48px;
    text-transform: capitalize;
    font-family: 'OpenSans-ExtraBold';
    text-align: center;
}

.section-title-wrapper{
    margin-bottom: 70px;
}
.section-title h1{
    font-size: 36px;
    line-height: 26px;
    font-family: 'OpenSans-SemiBold';
    text-transform: uppercase;
    color: var(--secondary-color);
    margin-bottom: 0px;
}

.see-all-wrap{
    text-align: right;
}
.see-all-wrap a{
    font-size: 20px;
    line-height: 26px;
    color: #999999;
    font-family: 'OpenSans-Bold';
    text-transform: capitalize;
    transition: 0.5s linear;
}
.see-all-wrap a:hover{
    color: var(--secondary-color);
}
.mobile-see-all{
    display: none;
    text-align: center;
}
.mobile-see-all a{
    font-size: 20px;
    line-height: 26px;
    color: #999999;
    font-family: 'OpenSans-Bold';
    text-transform: capitalize;
}

 .owl-nav{
  display: block !important;
 }

.owl-nav button{
    background-color: #fff !important;
    color: var(--secondary-color);
    width: 25px;
    height: 25px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0px 0px 14px 2px rgba(0,0,0,0.14);
    -webkit-box-shadow: 0px 0px 14px 2px rgba(0,0,0,0.14);
    -moz-box-shadow: 0px 0px 14px 2px rgba(0,0,0,0.14);
  }

.owl-nav button span{
        font-size: 24px;
    /* line-height: 12px; */
    position: relative;
    top: -3px;
    font-weight: bold;
  }

.owl-prev{
  position: absolute;
  left: -12px;
  top: 53%;
  transform: translate(0%,-53%);
  }
  .owl-next{
  position: absolute;
  right: 0;
  top: 53%;
  transform: translate(0%,-53%);
  }
.rotate-open{
    transform:rotate(-180deg);
}


::-webkit-scrollbar {
  width: 5px;
  height: 30px;
}
/* Track */
::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey; 
  border-radius: 2px;
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: var(--primary-color); 
  border-radius: 10px;
}

.btn-orange{
    background-color: var(--primary-color) !important;
    border: 1px solid var(--border-color) !important;
}

.btn-orange:hover{
    background-color: transparent !important;
    color: var(--primary-color) !important;
    border: 1px solid var(--border-color) !important;
}



/*=====BREADCRUMB======*/
.breadcrumb-menu{
    background-image: url(../../../public/frontend/assets/images/breadcrumb.jpg);
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    position: relative;
    padding: 60px 0px;
}
.breadcrumb-menu.breadcrumb-cart{
     background-image: url(../../../public/frontend/assets/images/breadcrumb-cart.png);
}
.breadcrumb-menu.breadcrumb-vendor{
     background-image: url(../../../public/frontend/assets/images/breadcrumb-vendor.png);
}
.breadcrumb-menu.breadcrumb-about{
     background: url(../../../public/frontend/assets/images/breadcrumb-about-2.jpg) center center no-repeat;
     background-size: cover;

}
.breadcrumb-menu.breadcrumb-contact{
     background-image: url(../../../public/frontend/assets/images/breadcrumb-contact.png);
}
.breadcrumb-menu::after{
    content: "";
    position: absolute;
    width: 100%;
    height:100%;
    top:0px;
    left: 0px;
    background-color: rgba(0,0,0,0.5);
    z-index: 0;
}
.breadcrumb{
   position: relative;
   z-index:2;
   background-color: transparent; 
}

.breadcrumb .breadcrumb-item{
    font-size:30px;
    text-transform: uppercase;
    color: #fff;
   font-family: 'OpenSans-Bold';
}

.breadcrumb-item+.breadcrumb-item::before{
    color: #fff;
}

.breadcrumb .breadcrumb-item a{
    font-family: 'OpenSans-Regular';
    color: #fff;
}

.quantity-wrap{
    display: flex;
    align-items: center;
    justify-content: center;
    height: auto;
}
.quantity-wrap button{
    background-color: var(--secondary-color);
    border: 0px;
    width: 35px;
    height: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: var(--light-color);
    font-size: 13px;
}
.quantity-wrap button .minus{
    position: relative;
}
.quantity-wrap input{
    border: 0px;
    height: 30px;
    width: 30px;
    border-top: 1px solid var(--secondary-color);
    border-bottom: 1px solid var(--secondary-color);
    color: #999;
    font-family: 'OpenSans-Bold';
    text-align: center;
}


/*==============================*/
     /*-----3.HEADER-----*/
/*==============================*/


header{
    background: var(--headerBackground);
}
header .header-top-nav{
    background-color: var(--secondary-color);
    padding:15px 0px; 
}

header .header-top-nav .welcome-title p {
    color: white;
    margin-bottom: 0px;
    font-size: 14px;

}

header .header-top-nav ul {
    list-style: none;
    padding: 0px;
    margin-bottom: 0px;
    text-align: right;
}

header .header-top-nav ul li {
    display: inline-block;
    padding: 0px 15px;
    border-right: 1px solid #1ebcb7;
}
header .header-top-nav ul li:last-child{
    padding-right: 0px;
    border-right: 0px;
}

header .lang-wrapper{
    display: flex;
    align-items: center;
    position: relative;
    background: var(--secondary-color);
    padding: 0 12px;
    border-radius: 3px;
    box-shadow: 0px 0px 14px 0px rgba(0 ,0 ,0 , 22%);
    width: 100%;
    max-width: 100px;
}

.lang-flag{
    margin-right: 4px;
}

header .lang-wrapper select{
    background:transparent;
    border:0px;
    color: white;
    font-size: 14px;
    -webkit-appearance: none;
    -moz-appearance: none;
    position: relative;
}

header .lang-wrapper select::-ms-expand {
    display: none;
}

header .lang-wrapper::after{
    content: "\f0dd";
    font-size: 15px;
    position: absolute;
    right: 10px;
    font-family: 'Font Awesome 5 Free';
    z-index: 3;
    color: #fff;
    font-weight: 700;
}

header .lang-wrapper select option{
    background:var(--secondary-color);
    border:transparent;
    color: white;
    font-size: 14px;
}


header .header-top-nav ul li a{
    color: white;
    font-size: 14px;
}

header .header-top-nav ul li a span.home{
    color: var(--primary-color);
}

.navigation-bar{
    padding: 15px 0px;
}
.navigation-bar .container{
    max-width: 100% ;
}


.menu-bar{
    display: flex;
    align-items: center;
    justify-content: flex-end;
}
.menu-bar div{
    margin: 0px 5px;
}
.menu-bar div:last-child{
    margin: 0px;
   
}

.location-wrap{
    display: flex;
    align-items:center; 
    background: #fff;
    
    width: 100%;
    max-width: 150px;
    box-sizing: border-box;
    height: 50px;
    border-radius: 3px;
    /*box-shadow: 0px 0px 14px 0px rgb(0 0 0 / 7%);*/
    position: relative;
}
.location-wrap select {
    border: 0px;
    color: var(--secondary-color);
    font-weight: bold;
    padding: 0px;
    -webkit-appearance: none;
    -moz-appearance: none;
    position: relative;
    box-shadow: none;
    position: absolute;
    left: 0;
    padding: 0px 10px;
    z-index:1;
    background:transparent;
}
.location-wrap select::-ms-expand {
    display: none;
}
.location-wrap select:focus{
    background:transparent;
}

.location-wrap::after {

    content: "\f078";
    right: 15px;
    top: 15px;
    font-family: 'Font Awesome 5 Free';
    z-index: 3;
    width: 25px;
    height: 25px;
    color: #333;
    /* top: -50%; */
    position: absolute;
    /* transform: translate(50%); */
    font-weight: 700;
    right: 0px;
    z-index: 0;

}

.search-wrap{
    display: flex ;
    background: #fff;
    align-items: center;
    padding: 0px 10px;
    width: 100%;
    max-width: 600px;
    box-sizing: border-box;
    height: 50px;
    border-radius: 3px;
     box-shadow: 0px 0px 14px 0px rgb(0 0 0 / 7%);
     border:1px solid #ccc;

}
.search-wrap input{
    background: transparent;
    border: 0;
    padding: 0px;
}
.search-wrap span{
    color: var(--secondary-color);
}

.search-wrap-2{
    display: flex ;
    background: #fff;
    align-items: center;
    padding: 0px 10px;
    width: 100%; 
    box-sizing: border-box;
    height: 50px;
    border-radius: 3px;
}
.search-wrap-2 input{
    background: transparent;
    border: 0;
    padding: 0px;
}
.search-wrap-2 span{
    color: var(--secondary-color);
}

.mobile-search{
display: none;
margin-top: 20px;
}

.mobile-location{
   display: none;
}
.mobile-location .location-wrap-2{
    display: flex;
    align-items:center; 
    background: #fff;
    padding: 0px 10px;
    box-sizing: border-box;
    height: 50px;
    border-radius: 3px;
     width: 100%;
    max-width: 100%;
    margin-top: 20px;
}

.mobile-location .location-wrap-2 select {
    border: 0px;
    color: var(--secondary-color);
    font-weight: bold;
    padding: 0px;
}

.cart_outter_wrap{
    position: relative;
}

.cart-wrap{
    display: flex !important;
    background: var(--cartBtnBackground);
    align-items: center;
    padding: 0px 10px;
    width: 50px;
    max-width: 50px;
    color: var(--cartBtnColor);
    box-sizing: border-box;
    height: 50px;
    border-radius: 3px;
    font-size: 22px;
    justify-content: center;
    position: relative;
    cursor: pointer;
    box-shadow: 0px 0px 14px 0px rgb(0 0 0 / 22%);
    transition:0.5s linear;
    margin: 0px !important;
}

.cart-wrap:hover {
    background-color: #fff;
    color: var(--primary-color);
    border: 1px solid var(--primary-color);
}


.cart-wrap:hover span.qnty-num{
color: #fff;
}

.cart-wrap span.qnty-num {
    position: absolute;
    right: 4px;
    top: 7px;
    background-color: var(--cartNum);
    font-size: 10px;
    font-weight: bold;
    border-radius: 50%;
    text-align: center;
    display: flex;
    width: 17px;
    height: 17px;
    justify-content: center;
    align-items: center;
    transition:0.5s linear;

}
.cart-view-wrap{
    position: absolute;
    right: 0px;
    width: 350px;
    background: white;
    top: 55px;
    z-index: 22;
    margin: 0px !important;
    display: none;
    animation-name: animate-top;
    animation-duration: 0.5s;

}
@keyframes animate-top {
    from{
        top: -50px;
        opacity: 0;
    }
    to{
        top: 55px;
        opacity: 1;
    }
}
.cart-visible{
    display: block;
}
.cart-view-wrap .cart-view-header{
    background-color: var(--secondary-color);
    margin: 0px !important;
    padding: 10px 10px 10px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
} 

.cart-view-wrap .cart-view-header h6{
    color: #fff;
    text-transform: capitalize;
    margin-bottom: 0px;
    font-size: 20px;
}

.cart-view-wrap .cart-view-header h6 span.title-cart{
position: relative;
color: var(--primary-color);
font-size: 18px;
margin-right: 15px
}
.cart-view-wrap .cart-view-header  span.closing{
    color: #f55d2c;
    font-size: 14px;
    margin-right: 5px;  
    cursor:pointer;
}
.cart-view-wrap .cart-view-content{
    margin: 0px !important;
    padding: 0px 5px;
}
.cart-view-wrap .cart-view-content ul{
    list-style: none;
    padding: 0px;
    margin: 0px;
    height: 230px;
    overflow-x: auto;
    overflow-y: scroll;
    /* width */
    
}
.cart-view-wrap .cart-view-content ul::-webkit-scrollbar {
  width: 5px;
  height: 30px;
}
/* Track */
.cart-view-wrap .cart-view-content ul::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey; 
  border-radius: 2px;
}
 
/* Handle */
.cart-view-wrap .cart-view-content ul::-webkit-scrollbar-thumb {
  background: #1ebcb7; 
  border-radius: 10px;
}




.cart-view-wrap .cart-view-content ul li {
    display: block;
    padding: 20px 25px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #ccc;
}
/*.cart-view-wrap .cart-view-content ul li:last-child{
 border-bottom: 0px;   
}*/
.cart-view-wrap .cart-view-content ul li .cart-img-wrap{
width: 75px;
height: 75px;
background-color: #e1eaf4;
display: flex;
align-items: center;
justify-content: center;
}
 
.cart-view-wrap .cart-view-content ul li .cart-img-wrap img
{
width: 100%;
/*max-width: 70px;*/
height: 100%;
object-fit: contain;
} 
.cart-view-wrap .cart-view-content ul li .cart-detail-wrap h6{
color: var(--secondary-color);
font-size: 18px;
font-family: 'OpenSans-SemiBold';
text-transform: capitalize;
margin-bottom: 0px;
}
.cart-view-wrap .cart-view-content ul li .cart-detail-wrap p{
 color: #999;
font-size: 16px;
font-family: 'OpenSans-SemiBold';
text-transform: capitalize; 
margin-bottom: 0px;  
text-align: left;
}
.cart-view-wrap .cart-view-content ul li .cart-delete i {
    color: var(--secondary-color);
    font-size: 14px;
}
.cart-view-wrap .subtotal-wrap{
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    padding: 20px 25px;
    border-bottom: 1px solid #ccc;
}

.cart-view-wrap .subtotal-wrap h6{
color: var(--secondary-color);
font-size: 18px;
font-family: 'OpenSans-SemiBold';
text-transform: capitalize;
margin-bottom: 0px;
}

.cart-view-wrap .subtotal-wrap p{
  color: var(--primary-color);
font-size: 16px;
font-family: 'OpenSans-SemiBold';
text-transform: capitalize; 
margin-bottom: 0px;     
}

.cart-view-wrap .view-cart-btn-wrapper{
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 10px;
    margin: 0px !important;
}
.cart-view-wrap .view-cart-btn-wrapper a:last-child{
border-color:var(--border-color) !important;
background-color: var(--secondary-color) !important;  
}

.cart-view-wrap p {
    font-size: 16px;
    color: #f55d2c;
    text-align: center;
}

.mobile-login{
display: none;
}
.mobile-login-user{
    display: flex !important;
    background: var(--primary-color);
    align-items: center;
    padding: 0px 10px;
    width: 100%;
    max-width: 45px;
    color: #fff;
    box-sizing: border-box;
    height: 50px;
    border-radius: 3px;
    font-size: 22px;
    justify-content: center;
    position: relative;
    cursor: pointer;
     box-shadow: 0px 0px 14px 0px rgb(0 0 0 / 22%);
         transition:0.5s linear;
}
.mobile-login-user:hover{
    color: #fff;
    background-color: transparent;
    border-color: 1px solid var(--primary-color);
}

/*
.mobile-login-user:hover span.qnty-num{
color: #fff;
}*/


.login-btn-wrap a{
width: 100px;
height: 50px;
background-color: var(--loginBtnBackground);
border:1px solid var(--loginBtnborder); 
display: flex;
justify-content: center;
align-items: center;
color: var(--loginBtnColor);
border-radius: 3px;
box-shadow: 0px 0px 14px 0px rgb(0 0 0 / 12%);
transition: 0.5s linear;
font-weight:800;
}

.login-btn-wrap a:hover{
    background-color: #fff;
    color: var(--primary-color);
    border: 1px solid var(--primary-color);
}



.user-logged{
    position: relative;
}
.user-logged button{
    width: 155px;
    height: 50px;
    background-color: #eaf2f2;
    border: 1px solid #d4dfdf;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    color: var(--secondary-color);
    text-transform: capitalize;
    padding: 0px 10px;
    font-family: 'OpenSans-SemiBold';
    position: relative;
}

.user-logged button span.profile{
    width: 35px;
    height: 35px;
    background: #eaf2f2;
    border-radius: 50%;
    border: 1px solid var(--secondary-color);
        margin-right: 10px;
        overflow: hidden;
}

.user-logged button span.profile img{
    width: 35px;
    height: 35px;
}

.user-logged button span.down-arrow{
    position: absolute;
    right: 10px;
    transition: 0.5s linear;
}
.user-logged button span.down-arrow.rotate-open{
    transform:rotate(-180deg);
}


.user-profile{
    position: absolute;
    right: 0px;
    width: 350px;
    background: white;
    top: 55px;
    z-index: 22;
    margin: 0px !important;
    display: none;
    animation-name: animate-top;
    animation-duration: 0.5s;

}
@keyframes animate-top {
    from{
        top: -50px;
        opacity: 0;
    }
    to{
        top: 55px;
        opacity: 1;
    }
}
.user-profile-visible{
    display: block;
}
.user-profile .user-profile-header{
    background-color: var(--secondary-color);
    margin: 0px !important;
    padding: 10px 10px 10px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
} 

.user-profile .user-profile-header h6{
color: #fff;
text-transform: capitalize;
margin-bottom: 0px;
font-size: 20px;
}

.user-profile .user-profile-header h6 span.title-cart{
position: relative;
color: #fff;
font-size: 18px;
margin-right: 15px;
transform:rotate(0);

}




.user-profile .user-profile-header  span.closing{
color: #fff;
font-size: 14px;
margin-right: 5px; 
cursor: pointer;
}
.user-profile .user-profile-content{
    margin: 0px !important;
    padding: 0px 5px;
}
.user-profile .user-profile-content ul{
    list-style: none;
    padding: 0px;
    margin: 0px;
}

.user-profile .user-profile-content ul li {
    display: block;
    
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #ccc;

}
.user-profile .user-profile-content ul li a{
    color: var(--secondary-color);
    font-size: 18px;
    font-family: 'OpenSans-SemiBold';
    text-transform: capitalize;
        padding: 20px 25px;
    width: 100%;
    display: block;
        cursor: pointer;
}
.user-profile .user-profile-content ul li a span{
    color: var(--primary-color);
    margin-right: 15px;
}

header .navbrand a img {
    max-width: var(--logoWidth);
    width: 100%;
}


/*==============================*/
     /*-----4.BANNER SLIDER-----*/
/*==============================*/


.carousel {
  position: relative;

}

/* #carousel .carousel-item.boat {
  background-image: url("../../../public/frontend/assets/images/home/banner-1.png");
}

#carousel .carousel-item.sea {
  background-image: url("../../../public/frontend/assets/images/home/banner-1.png");
}

#carousel .carousel-item.river {
  background-image: url("../../../public/frontend/assets/images/home/banner-1.png");
} */

.banner-image {
    position: absolute;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

#carousel .carousel-item {
  height: 90vh;
  width: 100%;
  min-height: 350px;
  background: no-repeat center center scroll;
  background-size: cover;

}


.carousel::after {
  content: "";
  position: absolute;
  width: 0px;
  height: 0px;
  background: var(--secondary-color);
  top: 0px;
  left: 0px;
  z-index: 1;
  width: 100%;
  height: 100%;
  opacity: 0.4;
}

.caption {position: relative;z-index: 2;}
.caption h2{
    font-size: 72px;
    color: #fff;
    text-transform: uppercase;
    font-family: 'OpenSans-Bold';
    margin-bottom: 0px;
        text-shadow: 2px -1px 3px rgb(0 0 0 / 72%);
}

.caption p{
    font-size: 36px;
    color: #fff;
    text-transform: uppercase;
    font-family: 'OpenSans-Bold';
    margin-bottom: 0px;
        text-shadow: 2px -1px 3px rgb(0 0 0 / 72%);
}
.caption .btn{
    margin-top: 25px;
}

.carousel-indicators li {
    width: 9px;
    height: 9px;
    border-radius: 50%; 
}

.carousel-indicators li.active {
    width: 10px;
    height: 10px;
    /*border-radius: 50%;*/
}

/*==============================*/
     /*-----5.CATEGORY-----*/
/*==============================*/

 .category-slider .owl-nav{
  display: block !important;
 }
.category-slider .owl-nav button{
    background-color: #fff !important;
    color: var(--secondary-color);
    width: 25px;
    height: 25px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0px 0px 14px 2px rgba(0,0,0,0.14);
-webkit-box-shadow: 0px 0px 14px 2px rgba(0,0,0,0.14);
-moz-box-shadow: 0px 0px 14px 2px rgba(0,0,0,0.14);
  }
.category-slider .owl-nav button span{
        font-size: 24px;
    /* line-height: 12px; */
    position: relative;
    top: -3px;
    font-weight: bold;

  }
.category-slider .owl-prev{
  position: absolute;
  left: -12px;
  top: 53%;
  transform: translate(0%,-53%);
  }
  .category-slider .owl-next{
  position: absolute;
  right: 0;
  top: 53%;
  transform: translate(0%,-53%);
  }

.category-wrapper{
    width: 210px;
    height: 240px;
    background-color: #fff;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    /*justify-content: center;*/
    border-radius: 6px;
    padding: 10px 0;
}
.category-wrapper .category-img{
    width: 100%;
    text-align: center;
    height: 141px;
    padding: 0 10px;
}

.category-wrapper .category-img img{
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.category-name h6 {
    font-size: 18px;
    line-height: 26px;
    font-family: 'OpenSans-SemiBold';
    color: var(--secondary-color);
    text-transform: capitalize;
    margin-bottom: 0px;
    margin-top: 17px;
}

.category-list .category-wrapper{
    width: 100%;
    margin-bottom: 15px;
}

.dropdown-subcategories .dropbtn {
    color: white;
    background-color: transparent;
    padding: 5px 7px;
    font-size: 16px;
    border: none;
    cursor: pointer;
    font-family: 'OpenSans-SemiBold';
    color: #fff;
    background-color: var(--primary-color);
}
/*   
.dropdown-subcategories .dropbtn:hover, .dropbtn:focus {
    background-color: #2980B9;
} */

.category-menu .dropdown .btn {
    width:auto !important;
}

.category-menu.sub-cat-wrapper{
    background-color: #e1eaf4;
}

.sub-cat-menu .dropdown {
    position: relative;
    display: inline-block;
}
  
.sub-cat-menu .dropdown-content {
    display: none;
    width: 100%;
    position: absolute;
    background-color: #f1f1f1;
    max-width: 1200px;
    box-shadow: 0px 8px 16px 0px rgb(0 0 0 / 20%);
    z-index: 1;
    left: 0;
}
  
.sub-cat-menu .dropdown-content a {
    color: black;
    padding: 12px 5px;
    text-decoration: none;
    display: block;
}

  
.sub-cat-menu .dropdown-content a:hover {background-color: #ddd}
  
.sub-cat-menu .show {display:block;}

/*==============================*/
     /*-----6.TOP FEATURED-----*/
/*==============================*/
.top-feature-slider .item{
    margin: 0px 10px;
}
.top-feature-slider .owl-prev{
    left: -5px;
}

.product-wrapper{
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    position: relative;
}
.product-wrapper .wishlist-wrapper{
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
}
.product-wrapper .wishlist-wrapper .offer-wrap{
    background-color: var(--primary-color);
    border-radius:3px;
    height: 22px;
    width: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: 10px;
    left: 25px;
}
.product-wrapper .wishlist-wrapper .offer-wrap p {
    color: #fff;
    margin-bottom: 0px;
    font-size: 12px;
    font-family: 'OpenSans-Bold';
}
.product-wrapper .wishlist-wrapper .wishlist-icon{
    background-color: #fdead6;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
}

.product-wrapper .wishlist-wrapper .wishlist-icon i{
    color: #f55d2c;
}

.product-wrapper .feat-img{
    text-align: center;
    margin-top: 20px;
    height: 160px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}
.out-stock{
    position: absolute;
    text-transform: capitalize;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    background-color: rgba(255,255,255,0.8);
    z-index: 222;
    cursor: no-drop;
    left: 0;
    top: 0;
  }
  .out-stock{
    position: absolute;
    text-transform: capitalize;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    background-color: rgba(255,255,255,0.8);
    z-index: 20;
    cursor: no-drop;
    left: 0;
    top: 0;
  }
  span.out-heading{
    display: inline-block;
    color: #393939;
    font-size: 16px;
    transform: rotate(0deg);
    border: 1px solid black;
    padding: 5px 10px;
    border-radius: 5px;
  }
.product-wrapper .feat-img img{
    width: 100%;
    height: 100%;
    object-fit: contain;
    margin: 0 auto;
}

.product-wrapper .feature-detail{
    text-align: center;
      margin-top: 20px;
}
.product-wrapper .feature-detail h5{
    font-size: 16px;
    line-height: 24px;
    color: var(--secondary-color);
    font-family: 'OpenSans-SemiBold';
    text-transform: capitalize;
    margin-bottom: 0px;
    height: 50px;
    white-space: normal !important;
    overflow: hidden;
}

.product-wrapper .feature-detail h6{
    font-size:18px;
    line-height: 26px;
    color: var(--primary-color);
    font-family: 'OpenSans-Bold';
    text-transform: capitalize;
    margin-bottom: 0px;
}
.product-wrapper .feature-detail p{
     font-size:14px;
    line-height: 26px;
    color: #999999;
    font-family: 'OpenSans-Regular';
    text-transform: capitalize;
     margin-bottom: 0px;
}

.feature-bottom-wrap{
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    height: 50px;

}

.feature-bottom-wrap .cart{
     background-color: var(--secondary-color);
    border-radius: 50%;
    width: 35px;
    height: 35px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
    cursor: pointer;
    transition: 0.5s linear;
}
.feature-bottom-wrap .cart:hover{
    color: var(--primary-color);
}

.feature-bottom-wrap .quantity-wrap{
    display: flex;
    align-items: center;
    height: auto;
}
.feature-bottom-wrap .quantity-wrap button{
    background-color: var(--secondary-color);
    border: 0px;
    width: 35px;
    height: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: var(--light-color);
    font-size: 13px;
}
.feature-bottom-wrap .quantity-wrap button .minus{
    position: relative;
}
.feature-bottom-wrap .quantity-wrap input{
    border: 0px;
    height: 30px;
    width: 30px;
    border-top: 1px solid var(--secondary-color);
    border-bottom: 1px solid var(--secondary-color);
    color: #999;
    font-family: 'OpenSans-Bold';
    text-align: center;
}


/*==============================*/
     /*-----7.BEST OFFERS -----*/
/*==============================*/

.offer-wrapper img{
width: 100%;
}
.offer-wrapper.big-banner{
    margin-top: 50px;
}

/*==============================*/
     /*-----8.NEW PRODUCT -----*/
/*==============================*/

.new_product_1{ 
    margin-bottom:50px;
}

/*==============================*/
     /*-----9.SOCIAL WRAPPER -----*/
/*==============================*/
.social-main-wrapper{
    padding: 15px 0px;
}
.toll-free-num{
    list-style: none;
    padding: 0px;
    margin: 0px;
}
.toll-free-num li {
    display: inline-block;
    font-size: 18px;
    color: var(--secondary-color);
    font-family: 'OpenSans-SemiBold';
}
.toll-free-num li span{
    margin-right: 10px;
    color: var(--primary-color);
}
.toll-free-num li:first-child{
    margin-right: 20px;
}
.toll-free-num li a {
    color: var(--secondary-color) !important;
}
.social-icon{
    padding: 0px;
    margin: 0px;
    list-style: none;
    text-align: right;
}

.social-icon li {
    display: inline-block;
    margin-right: 30px;
}
.social-icon li:last-child{
    margin-right: 0px;
}


.social-icon li a{
    color: var(--secondary-color);
    transition: 0.5s linear;
    display: inline-block;
}
.social-icon li a:hover{
    color: var(--primary-color);
    transform: translateY(-5px);
}

/*==============================*/
     /*-----10.FOOTER -----*/
/*==============================*/

footer ul {
    padding: 0px;
    margin: 0px;
    list-style: none;
}

footer  h6{
    font-size: 18px;
    color: var(--secondary-color);
    font-family: 'OpenSans-Bold';
    text-transform: capitalize;
    margin-bottom: 15px;
}

footer ul li a{
    font-size: 20px;
    color: #666;
    font-family: 'OpenSans-Regular';
    transition: 0.5s;
}
footer ul li a:hover{
color: var(--secondary-color);
font-weight: bold;
}

.download-app .play-store-img a{
display: inline-block;
margin: 0px 5px;
}
.download-app .play-store-img a img {
    width: 100%;
    max-width: 130px;
}

.payment-method {
    margin-top: 35px;
}
.payment-method h6{
    margin-bottom: 10px;
}
.payment-method li {
    display: inline-block;
    margin: 0px 5px;
}

.subscribe-email {
    margin-top: 35px;
}
.subscribe-email h6{
    margin-bottom: 10px;
}

.subscribe-email .email-wrap{
    display: flex;
    height: 45px;

}

.subscribe-email .email-wrap input{
    padding: 0px 5px;
    color: #999;
    font-family: 'OpenSans-SemiBold';
    width: 80%;
}
.subscribe-email .email-wrap input:focus{

    outline: 0px; 
}
.subscribe-email .email-wrap button{
    width: 20%;
    height: 45px;
    background-color: var(--secondary-color);
    color: var(--light-color);
    border: 0px;
}

/*==============================*/
     /*-----11.BOTTOM FOOTER -----*/
/*==============================*/
.bottom-footer{
    background-color: var(--primary-color);
    padding: 15px 0px;
}
.bottom-footer .copyright{
    font-size: 16px;
    color: var(--light-color);
    font-family: 'OpenSans-SemiBold';
    margin-bottom: 0px;

}

.bottom-footer .scroll-top{
   text-align: right;
   position: fixed;
   right: 15px;
   bottom: 10px;
}
.bottom-footer .scroll-top button{
    background-color: var(--secondary-color);
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 0px;
    color: var(--light-color);
    margin-left: auto;
    border-radius: 3px;

}



/*==============================*/
/*-----12.ENTER LOCATION MODAL -----*/
/*==============================*/
/*.location-popup.modal {
    padding: 15px;
}*/

.location-popup .modal-lg{
    max-width: 1100px;
}
.location-modal{
    display: flex;
    align-items: center;
    width: 100%
}
.location-popup .close{
    position: absolute;
    right: 10px;
    top: 10px;
    color: #003333;
    opacity: 1;
    font-size: 18px;
}
.location-image{
    width: 50%;
}
.location-image img {
    width: 100%;
}
.location-detail{
    width: 50%;
    padding: 0px 15px;
}
.location-detail h1{
    font-size: 36px;
    color: var(--secondary-color);
    text-align: center;
    text-transform: capitalize;
    font-family: 'OpenSans-ExtraBold';
}
.location-detail form {
    max-width: 500px;
    margin: 0 auto;
    margin-top: 40px;
}
.location-box{
    padding: 5px 20px;
    border: 1px solid #999;
    display: flex;
    align-items: center;
    border-radius: 5px;
    box-shadow: 0px 0px 14px 2px rgb(0 0 0 / 14%);
}
.location-box span{
    margin-right: 15px;
    color: var(--primary-color);
    font-size: 30px;
}
.location-box input{
    border: 0px;
    font-family: 'OpenSans-SemiBold';
    color: #666666;
    font-size: 28px;
    border-left: 1px solid #999;
    padding-left: 10px;
    height: 70px;
    width: 100%;
}
.location-box input::placeholder{
    text-transform: capitalize;
     font-family: 'OpenSans-SemiBold';
     color: #666666;
     font-size: 28px;
}

.location-detail button.btn{
    width: 100%;
    margin-top: 25px;
    height: 70px;
    font-size: 24px;
    box-shadow: 0px 0px 14px 2px rgb(0 0 0 / 14%);
}
.location-detail button span{
    margin-right: 10px;
}

.location-detail p {
    margin-top: 50px;
    text-align: center;
    font-family: 'OpenSans-SemiBold';
    font-size: 18px;
    color: #666;
}

.location-detail p a {
    color: var(--primary-color);
    font-family: 'OpenSans-ExtraBold';
}



/*==============================*/
/*-----13.LOGIN PAGE -----*/
/*==============================*/
.input-wrapper{
    border:1px solid #999999;
    border-radius: 5px;
    height: 60px;
    background-color: #fff;
    display: flex;
    align-items: center;
    padding: 0px 0px 0px 20px;
     margin-bottom: 20px;
}

.input-wrapper span {
    color: var(--primary-color);
    margin-right: 20px;
    font-size: 20px;
}
.input-wrapper span.eye{
    color: #666;
} 
.input-wrapper input{
    border:0px;
    font-family: 'OpenSans-SemiBold';
    color: #666;
    font-size: 20px;
    width: 100%;
}
.input-wrapper input::placeholder{
    text-transform: capitalize;
     color: #666;
    /* -webkit-text-fill-color: #adadad; */
}
.input-wrapper.message {
    min-height: 150px;
    align-items: flex-start;
    padding: 20px 10px 5px 20px;
}
.input-wrapper.message textarea{
     border:0px;
    font-family: 'OpenSans-SemiBold';
    color: #666;
    font-size: 20px;
    width: 100%;
    height: 100%;
}
.input-wrapper.message textarea::placeholder{
    text-transform: capitalize;
    font-family: 'OpenSans-SemiBold';
     color: #666;
    font-size: 20px;
    width: 100%;

}
.fa-eye{
    cursor: pointer;
    display: inline-block;
}
.login-form{

    max-width: 450px;
    margin: 0 auto;
    margin-top: 60px;
}
.login-form button {
    width: 100%;
    box-shadow: 0px 0px 14px 2px rgb(0 0 0 / 14%);
    height: 60px;
}

.login-form a {
    color: var(--primary-color);
    text-transform: capitalize;
     font-family: 'OpenSans-SemiBold';
     display: inline-block;
     margin-top: 35px;
     height: 60px;

}

.create-acc{
    text-align: center;
}
.create-acc h2 {
    font-size: 30px;
    color: var(--secondary-color);
    font-family: 'OpenSans-Bold';
    text-transform: capitalize;
    text-align: center;
}

.create-acc p {
    font-size: 18px;
    color: #666;
    font-family: 'OpenSans-SemiBold';
    text-transform: capitalize;
    text-align: center;
}

.create-acc a{
    display: inline-block;
    line-height: 36px;
    width: 200px;
} 



/*==============================*/
/*-----14.REGISTER PAGE -----*/
/*==============================*/



.main {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 15px;
    cursor: pointer;
    font-size: 20px;
    margin-top: 25px;
    color: #666;
}
.main a {
    margin-top: 0px; 
}
  
/* Hide the default checkbox */
input[type=checkbox] {
    visibility: hidden;
}
  
/* Creating a custom checkbox
based on demand */
.geekmark {
    position: absolute;
    top: 5px;
    left: 0;
    height: 20px;
    width: 20px;
    background-color: transparent;
    border:1px solid #fb3e0d;
    border-radius: 5px;
}
  

/* Specify the background color to be
shown when checkbox is active */
.main input:active ~ .geekmark {
    background-color: red;
}
  
/* Specify the background color to be
shown when checkbox is checked */
.main input:checked ~ .geekmark {
    background-color: #fb3e0d;
}
  
/* Checkmark to be shown in checkbox */
/* It is not be shown when not checked */
.geekmark:after {
    content: "";
    position: absolute;
    display: none;
}
  
/* Display checkmark when checked */
.main input:checked ~ .geekmark:after {
    display: block;
}
  
/* Styling the checkmark using webkit */
/* Rotated the rectangle by 45 degree and 
showing only two border to make it look
like a tickmark */
.main .geekmark:after {
    left: 8px;
    bottom: 5px;
    width: 6px;
    height: 12px;
    border: solid white;
    border-width: 0 4px 4px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}

.register-form .create-btn{
    margin-top: 30px;
    height: 60px;
}


.or-partition {
    text-align: center;
    margin: 30px 0px;
}

.or-partition span{
    color: #666;
    font-size: 18px;
    font-family: 'OpenSans-SemiBold';

}

.social-btns .btn {
width: 100%;
color: white;
line-height: 48px;
height: 60px;
}
.social-btns .btn:first-child{
    margin-top: 0px;
}

.social-btns .btn span {
    margin-right: 15px;
}

.social-btns .facebook-btn{
    background-color: #1877f2;
    border-color: #1955a2;
}

.social-btns .google-btn{
    background-color: #d44638;
    border-color: #a12f24;
}

.register-form p {
    color: var(--secondary-color);
    font-size: 18px;
    font-family: 'OpenSans-SemiBold';
    text-align: center;
}

.register-form p a {
    color: var(--primary-color);
     font-family: 'OpenSans-Bold';
}



/*==============================*/
/*-----15.PRODUCT LISTING PAGE -----*/
/*==============================*/

.category-menu{
    background-color: var(--secondary-color);
    height: auto;
    padding: 20px 0px;
    display: flex;
    align-items: center;
}
.category-menu-wrapper{
    display: flex;
    align-items: center;
}
.category-menu-wrapper .dropdown-menu{
   width: 271px;
   border: 1px solid #e8e8e8;
   border-radius: 0px;
   padding: 0px;
   top: 5px !important;
   box-shadow: 0px 0px 14px 0px rgb(0 0 0 / 22%);
}
.category-menu-wrapper .show>.btn-primary.dropdown-toggle{
    background-color: #fff;
    border: 1px solid var(--secondary-color);
    color: var(--secondary-color);
}
.category-menu-wrapper .btn-primary{
    justify-content: space-between;
}

.category-menu-wrapper .btn-primary{
    justify-content: space-between;
    background: #fff;
    color: var(--secondary-color);
    border-color: transparent;
}

.category-menu-wrapper .btn-primary::after{
    display: none;
}
.category-menu-wrapper .btn-primary:focus {
    color: var(--secondary-color);
    background-color: #fff;
    border-color: transparent;
}
.category-menu-wrapper .btn-primary:focus{
    box-shadow: none !important;
}
.category-menu-wrapper .dropdown-menu .dropdown-item{
    height: 45px;
    border-bottom:1px solid #e8e8e8;
    line-height: 42px;
    padding: 0px 15px;
    color: #666666;
    font-size: 16px;
    font-family: 'OpenSans-SemiBold';
    display: flex;
    align-items: center;
    justify-content: space-between;
    text-transform: capitalize;
}
.cat-hover{
    position: relative;
}
.cat-hover:hover .category-sub-menu{
    display: block;
}
.category-menu-wrapper .dropdown-menu .dropdown-item div i{
    color: var(--primary-color);
    font-size: 16px;
    margin-right: 5px;
}
.category-menu-wrapper .dropdown-menu .dropdown-item span{
    color: var(--secondary-color);
    font-size: 10px;
}
.category-menu-wrapper .dropdown-menu .dropdown-item span.new{
    color: white;
    background-color: #e7ae00;
    display: flex;
    align-items: center;
    height: 22px;
    padding: 0px 7px;
    border-radius: 3px;
    font-size: 11px;
    position: absolute;
    right: 35px;
    text-transform: uppercase;
}
.category-menu-wrapper .dropdown-menu .dropdown-item span.hot{
    color: white;
    background-color: #f55d2c;
    display: flex;
    align-items: center;
    height: 22px;
    padding: 0px 7px;
    border-radius: 3px;
    font-size: 11px;
    position: absolute;
    right: 35px;
    text-transform: uppercase;
}
.dropdown-item.active, .dropdown-item:active{
    background-color: #f8f9fa;
}
.category-menu-wrapper .category-sub-menu{
    position: absolute;
    left:270px;
    background: white;
    min-width: max-content;

    border: 1px solid #e8e8e8;
    display: none;
    top: 0px;
}
.category-menu-wrapper .dropdown-menu .dropdown-item:hover .category-sub-menu{
    display: block;
}
/* .category-menu-wrapper .category-sub-menu a:first-child{
    display: none;
} */
.category-menu-wrapper ul {
    padding: 0px;
    margin: 0px;
    position: relative;
}

.category-menu-wrapper ul li{
    list-style: none;
    display: inline-block;
    position: relative;
    margin-left: 25px;
}
.category-menu-wrapper ul li:first-child::after{
    display: none;
}
.category-menu-wrapper ul li::after{
    content: "";
    width: 3px;
    height: 3px;
    background-color: #f55d2c;
    border-radius: 50%;
    left: -15px;
    top: 50%;
    position: absolute;
    transform: translate(0px, -50%);

}

.category-menu-wrapper ul li a{
    color: #ffffff;
    font-family: 'OpenSans-SemiBold';
}

.category-menu-wrapper ul.cat_selected li a.active{
    color: var(--primary-color);
} 

.category-menu-wrapper.sub-cat-menu ul.sub-cat-main li:first-child{
    margin-left: 0px;
}
.category-menu-wrapper.sub-cat-menu ul.sub-cat-main li a{
    color: var(--secondary-color);
    font-family: 'OpenSans-SemiBold';
}
.category-menu-wrapper.sub-cat-menu ul.sub-cat-main li a.active_sub{
    color: #ffffff;
    background: var(--secondary-color);
    padding: 5px 10px;
}
 
/* .category-menu-wrapper.sub-cat-menu ul.sub-cat-main li:last-child{
    display: inline-block;
    background: var(--secondary-color);
    padding: 5px 10px;
    font-family: 'OpenSans-SemiBold';
    color: #000;
    border-radius: 3px;
}

.category-menu-wrapper.sub-cat-menu ul.sub-cat-main li:last-child a{
    font-family: 'OpenSans-SemiBold';
    color: #fff;
    background-color: #0a3140;
} */
/* .category-menu-wrapper ul.sub-cat-main li:first-child::after{
    display: block;
    margin-left: 25px;
} */
.category-menu-wrapper ul.sub-cat-main .dropdown-content ul li:first-child{
    margin-left: 25px;
}

.category-menu-wrapper ul.sub-cat-main .dropdown-content ul li:first-child::after{
    display: block;

}

.sidenav {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1;
    top: 0px;
    left: 0;
    background-color: #e1eaf4;
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 60px;
  }
  
  .sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    color: var(--secondary-color);
  }
  
  @media screen and (max-height: 450px) {
    .sidenav {padding-top: 15px;}
    .sidenav a {font-size: 18px;}
  }

  .open-cat{
      display: block !important;
  }
  .rotate{
      transform: rotate(90deg);
  }
.product-list .product-wrapper{
    margin-bottom: 25px;
    position: relative;
}
.product-list .show-more{
text-align: center;
margin: 0 auto;
margin-top: 30px;
}
.filter-wrapper{
    display: flex;
    justify-content: flex-end;
    align-items: center;
}
.category-menu-wrapper.mobile-category{ display: none;}

.side-category{
    background-color: white;
}
.btn.mobile-category{
    display: none ;
}
.side-category ul{
    width:100%;
    border: 1px solid #e8e8e8;
    border-radius: 0px;
    padding: 0px;
    top: 10px !important
}
.side-category ul li div.mobiel-cat{
    height: 45px;
    border-bottom: 1px solid #e8e8e8;
    line-height: 42px;
    padding: 0px 15px;
    color: #666666;
    font-size: 16px;
    font-family: 'OpenSans-SemiBold';
    display: flex;
    align-items: center;
    justify-content: space-between;
    text-transform: capitalize;
}
.side-category ul li a{
    color: #666;
}

.side-category ul li div.mobiel-cat div i{
    color: var(--primary-color);
    font-size: 16px;
    margin-right: 5px;
    
}
.side-category ul li span{
    color: var(--secondary-color);
    transition: 0.5s linear;
}
.side-category ul li span i{
    transition: 0.2s linear;
}
.side-category ul li span.new{
    color: white;
    background-color: #e7ae00;
    display: flex;
    align-items: center;
    height: 22px;
    padding: 0px 7px;
    border-radius: 3px;
    font-size: 11px;
    position: absolute;
    right: 35px;
    text-transform: uppercase;
}
.side-category .category-sub-menu{
   display: none;
    background: white;
    width: 100%;
    border: 1px solid #e8e8e8;

}
.side-category .category-sub-menu a{
    height: 45px;
    border-bottom: 1px solid #e8e8e8;
    line-height: 42px;
    padding: 0px 15px;
    color: #666666;
    font-size: 16px;
    font-family: 'OpenSans-SemiBold';
    display: flex;
    align-items: center;
    justify-content: space-between;
    text-transform: capitalize;
 
 }
.sidenav::-webkit-scrollbar {
    width: 5px;
    height: 30px;
  }
  /* Track */
.sidenav::-webkit-scrollbar-track {
    box-shadow: inset 0 0 5px grey; 
    border-radius: 2px;
  }
   
  /* Handle */
.sidenav::-webkit-scrollbar-thumb {
    background: #1ebcb7; 
    border-radius: 10px;
  }
  
/*===========FILTER SELECT MENU===========*/
.filter-wrapper .dropdown{
    width: 100%;
    max-width: 300px;
    margin-right: 15px;
}
.style-select{
    margin-right: 25px;
    position: relative;
    width: 300px;
    background: white;
    border: 1px solid #ccc;
}
.style-select span{
    position: absolute;
    right: 10px;
    transform: translate(0px, -40%);
    top: 40%;
    z-index: 22;
}
.filter-wrapper select{
    background-color: transparent;
    border: 0px;
    height: 45px;
    padding: 0px 10px;
    width: 100%;
    max-width: 300px;
    position: relative;
    text-align: left;
    color: var(--secondary-color);
    font-weight: 800;
    text-transform: capitalize;
     font-family: 'OpenSans-SemiBold';
       margin-right: 15px;
       font-size: 14px;
} 


.filter-wrapper select {
    -moz-appearance:none; /* Firefox */
    -webkit-appearance:none; /* Safari and Chrome */
    appearance:none;
}

.filter-wrapper select:hover{
    border: 0px;
    outline: 0px;
}
.filter-wrapper select:focus{
    border: 0px;
    outline: 0px;
}
.filter-wrapper select option{

    color: var(--secondary-color);
    font-size: 14px;
    font-family: 'OpenSans-SemiBold';
    border-bottom:1px solid #ccc !important;
    text-transform: capitalize;
    padding: 15px 6px !important; 
    font-weight: 800;

}
/*===========FILTER DROPDOWN===========*/

.filter-wrapper .dropdown button {
    background-color: white;
    border: 0px;
    height: 45px;
    padding: 0px 10px;
    width: 100%;
    position: relative;
    text-align: left;
    color: var(--secondary-color);
    font-weight: 800;
    text-transform: capitalize;
    border: 1px solid #ccc;
    font-size: 14px;
     font-family: 'OpenSans-SemiBold';
} 

.filter-wrapper .dropdown button.dropdown-toggle::after{
    position: absolute;
    top: 21px;
    right: 20px;
    bottom: 0px;
}

.filter-wrapper .dropdown .dropdown-menu {
    width: 100%;
    padding: 0 5px;
}

.filter-wrapper .dropdown .dropdown-item {
    color: var(--secondary-color);
    font-size: 14px;
    font-family: 'OpenSans-SemiBold';
    border-bottom:1px solid #ccc;
    text-transform: capitalize;
    padding: 10px 6px;
    font-weight: 800;
}


.filter-wrapper .filter-icon{
    display: flex !important;
    background: var(--secondary-color);
    align-items: center;
    padding: 0px 10px;
    width: 100%;
    max-width: 45px;
    color: #fff;
    box-sizing: border-box;
    height: 45px;
    border-radius: 3px;
    font-size: 16px;
    justify-content: center;
    position: relative;
    cursor: pointer;
    box-shadow: 0px 0px 14px 0px rgb(0 0 0 / 22%);
    transition: 0.5s linear;
    position: relative;
}
/*
.filter-wrapper .filter-icon:hover {
    color: var(--primary-color);
}*/

.filter-dropdown{
     position: absolute;
    right: 0px;
    width: 350px;
    background: white;
    top: 55px;
    z-index: 999;
    margin: 0px !important;
    display: none;
    animation-name: animate-top;
    animation-duration: 0.5s;
    border:1px solid #e5e2e2;
    box-shadow: 0px 6px 16px 0px rgb(0 0 0 / 17%);
}
.filter-dropdown.show{
    display: block;
}
.filter-dropdown .filter-dropdown-header{
    background-color: var(--secondary-color);
    margin: 0px !important;
    padding: 10px 10px 10px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.filter-dropdown .filter-dropdown-header h6 {
    color: #fff;
    text-transform: capitalize;
    margin-bottom: 0px;
    font-size: 20px;
}
.filter-dropdown .filter-dropdown-header h6  span.title-cart {
    position: relative;
    color: var(--primary-color);
    font-size: 18px;
    margin-right: 5px;
}
.filter-dropdown .filter-dropdown-header span.closing {
    color: var(--primary-color);
    font-size: 14px;
    margin-right: 5px;
}
/*===========FAQ accordion ===================*/
.faq .faq-wrapper{
  display: flex;
    justify-content: center;
    height: 100%;
    align-items: center;
    width: 100%;
    padding-bottom: 15px;
}
.faq .faq-wrapper .faq-accordion {
  width: 100%;
}
.faq-accordion .accordion {
  list-style-type: none;
  padding-left: 0;
  margin-bottom: 0;
  padding: 0px 7px;
}

.faq-accordion .accordion .accordion-item {
  display: block;
  background-color: #ffffff;
  border-bottom:1px solid #ccc;
}

.faq-accordion .accordion .accordion-item:last-child {
  margin-bottom: 0;
   border-bottom:0px;
}

.faq-accordion .accordion .accordion-title {
  padding: 20px 60px 17px 25px;
  color: var(--secondary-color);
  text-decoration: none;
  position: relative;
  display: block;
  font-size: 18px;
  font-family: 'OpenSans-SemiBold';
  text-transform: capitalize;
  display: flex;
  align-items: center;
}

.faq-accordion .accordion .accordion-title i {
     position: absolute;
    right: 14px;
    border-radius: 100%;
    font-size: 14px;
    -webkit-transition: 0.5s;
    transition: 0.5s;
    color: var(--primary-color);
   
}

.faq-accordion .accordion .accordion-title.active i {
  -webkit-transform: rotate(180deg);
          transform: rotate(180deg);
}

.faq-accordion .accordion .accordion-title.active i::before {
  content: "\f056";
}

.faq-accordion .accordion .accordion-content {
  display: none;
  position: relative;
  margin-top: -5px;
  padding-bottom: 30px;
  padding-right: 30px;
  padding-left: 30px;
}

.faq-accordion .accordion .accordion-content.show {
  display: block;
}


/*CATEGORY FILTER*/
.categoy-filter{
    background-color: #f9f9f9;
}

.categoy-filter ul{
    padding: 0px;
    margin: 0px;
    list-style: none;
    height: 200px;
    overflow-y: scroll;
}
.categoy-filter ul li {
  padding: 10px 15px; 
    color: var(--secondary-color);
    font-family: 'OpenSans-SemiBold';
    text-transform: capitalize;
    position: relative;
    transition: 0.5s linear;
}
.categoy-filter ul li a{
color: var(--secondary-color);
 transition: 0.5s linear;
    padding: 10px 15px; 
    width: 100%;
    display: block;
}
.categoy-filter ul li a:hover{
color: #fff;
background-color: var(--secondary-color)
}

.categoy-filter ul li .sub-drop-arrow{
    position: absolute;
    right: 10px;
    top: 6px;    
}
.sub-cat-main .subcategory-wrap{
    display: none;
    position: relative;
    background: white;
    height: 100%;
    overflow: auto;
}

.sub-cat-main.show .subcategory-wrap{
    display: block;
    
} 
.sub-cat-main.show .subcategory-wrap li {
    border-bottom: 1px solid #ccc;
    padding: 0px 0px;
}
.sub-cat-main.show .subcategory-wrap li:last-child{
    border-bottom: 0px;
}
.animate-left{
    animation-name: mymoves;
    animation-duration: 1s;
    animation-iteration-count: 1;
}
@keyframes mymoves {
    from{
        left: -30px;
    }
    to{
       left:0px;
    }
}

/*BRAND FILTER*/
.brand-search{
    border:1px solid #e5e2e2;
    background-color: #f0f0f0;
    display: flex;
    padding: 5px 10px;

}
.brand-search input{
    border: 0px;
    background-color: transparent;
    width: 100%;
    font-family: 'OpenSans-SemiBold';
    color: #a0a0a0;
}
.brand-search span {
    color: #333333;
}



.brand-list input[type=checkbox] {
    visibility: visible;
    margin-right: 10px;
}
 
.brand-list{
    background-color: #f7f7f7;
    padding: 10px 10px;
    margin-top: 15px;
     height: 200px;
    overflow-y: scroll;
}  

.brand-list li {
    list-style: none;
    color: black;
    padding: 8px 0px;
    display: flex;
    align-items: center;
}  

.brand-list li label {
    margin: 0px;
    position: relative;
    width: 100%;
    color: var(--secondary-color);
    font-family: 'OpenSans-SemiBold';
}

.brand-list li label span{
    position: absolute;
    right: 0px;
}

/*PRICE RANGE SLIDER */
.price-range-slider {
    width: 100%;
    padding: 10px 20px 15px;
    background-color: #f7f7f7;
  }
  .price-range-slider .range-value {
    margin: 0;
    display:flex;
}
  .price-range-slider .range-value .fa-rupee-sign{
    color: var(--secondary-color);
    position: relative;
    font-size: 16px;
    top: 3px;
    position: relative;
    font-weight: 900;
    margin-right: 5px;
    top: 1px;
}

.price-range-slider .range-value input {
  width: 100%;
  background: none;
  color: var(--secondary-color);
  font-family: 'OpenSans-SemiBold';
  font-size: 16px;
  font-weight: initial;
  box-shadow: none;
  border: none;
  margin: 00px 0 20px 0;
}
.price-range-slider .range-bar {
  border: none;
  background: #000;
  height: 3px;
  width: 96%;
  margin-left: 8px;
}
.price-range-slider .range-bar .ui-slider-range {
  background: #1ebcb7;
}
.price-range-slider .range-bar .ui-slider-handle {
  border: none;
  border-radius: 25px;
  background: #fff;
  border: 2px solid #1ebcb7;
  height: 17px;
  width: 17px;
  top: -0.52em;
  cursor: pointer;
}
.price-range-slider .range-bar .ui-slider-handle + span {
  background: #1ebcb7;
}



/*==============================*/
/*-----16.ACCOUNT PAGE -----*/
/*==============================*/

.nav.nav-pills{
    border:1px solid #e5e2e2;
    background-color: #fff;
    box-shadow: 0px 0px 14px 2px rgb(11 51 67 / 15%);

}
.tab-header{
    background-color: var(--secondary-color);
    margin: 0px !important;
    padding: 10px 10px 10px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.tab-header h6{
    color: #fff;
    text-transform: capitalize;
    margin-bottom: 0px;
    font-size: 24px;
      font-family: 'OpenSans-SemiBold';
}

.tab-header h6 span{
    position: relative;
    color: #fff;
    font-size: 18px;
    margin-right: 10px;
}

.nav-pills .nav-link{
    color: var(--secondary-color);
    font-size: 20px; 
    border-radius: 0px;
    text-transform: capitalize;
    padding: 10px 10px 10px 20px;
    font-family: 'OpenSans-SemiBold';
    position: relative;
    transition: 0.5s linear;
}

.nav-pills .nav-link::after{
    content: "";
    width:90%;
    height: 1px;
    margin:0 auto;
    background-color: #cccccc; 
    position: absolute;
    left: 0px;
    right: 0px;
    bottom: 0px;
}
.nav-pills .nav-link:hover{
     color: var(--secondary-color);
    background-color: #e1eaf4;
}

.nav-pills .nav-link:last-child::after{
    display: none;
}

.nav-pills .nav-link span{
    color: var(--primary-color);
    font-size: 16px;
    margin-right: 10px;
}

.nav-pills .nav-link.active{
    color: var(--secondary-color);
    background-color: #e1eaf4;
}

.nav-pills .nav-link.active::after{
    display: none;
}

/*Account page - FAQ Accordion*/




#v-pills-settings .your-order-header {
    border-bottom: 1px solid #999;
    padding-bottom: 15px
}

.faq-accordion-tab .accordion {
  background-color: var(--secondary-color);
    color: #fff;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 18px;
    transition: 0.4s;
    font-family: "OpenSans-SemiBold";
    margin-top: 25px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    text-transform: capitalize;
}

.faq-accordion-tab .active,.faq-accordion-tab .accordion:hover {
  background-color: var(--primary-color);
}

.faq-accordion-tab .accordion:after {
  content: '\002B';
    float: right;
    margin-left: 5px;
    width: 15px;
    height: 15px;
    background-color: #f55d2c;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 5px;
    color: var(--secondary-color);
    font-size: 14px;
    font-weight: bold;
}

.faq-accordion-tab .active:after {
  content: "\2212";
}

.faq-accordion-tab .panel {
  padding: 0 15px;
  background-color: #f7f7f7;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
  border-bottom: 1px solid #999;
}

.faq-accordion-tab .panel p {
    margin-bottom: 0;
    padding: 15px;
}



/*===========tab content*/
.account-form-wrapper{
    padding: 50px 25px 70px 25px;
    box-shadow:0px 0px 14px 2px rgb(11 51 67 / 15%);
    border:2px solid #e5e2e2;
}

.account-form-wrapper .page-title{
    margin-bottom: 25px;
}
.account-form-wrapper .page-title.change-ps{
    margin-top: 25px;
}
.account-form-wrapper .page-title h1 {
    font-size: 30px;
    text-align: left;

}


/*=========My account=======*/
.profile-image {
  margin: 0 auto;
    position: relative;
    width: 150px;
    height: 150px;
    margin-bottom: 50px;
}
.profile-image .image-container{
    width: 135px;
    height: 135px;
    border: 2px solid var(--secondary-color);
    border-radius: 50%;
    margin: 0 auto;
    overflow: hidden;
}

.profile-image .image-container img{
    width: 100%;
    height: 100%;
    object-fit: cover;
}



.camera .filelabel {
       width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: border 300ms ease;
    cursor: pointer;
    text-align: center;
    margin: 0 auto;
    background: var(--secondary-color);
    position: absolute;
    bottom: 25px;
    right: 0px;
}

.camera .filelabel .title {
    color: var(--primary-color);
  font-family: 'OpenSans-SemiBold';
  text-transform: uppercase;
}
.camera #FileInput{
    display:none;
}

.account-form button {
    margin:0 auto;
        width: 100%;
}


/*========= YOUR ORDER ========= */

.your-order-wrapper{
    padding: 15px 25px;
    height: 105px;
    margin-bottom: 10px;
    overflow: hidden;
}
.your-order-wrapper.open-detail{
    height: 100%;
    animation-name: fullheight;
    animation-duration: 0.5s;
    animation-timing-function: linear;
}
@keyframes fullheight{
    0%{
        height: 0%;
    }
    100%{
        height: 100%;
    }
}

.your-order-header{
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 2px solid #999;
    width: 100%;
    padding-bottom: 15px;
    margin-bottom: 20px;
}

.your-order-header_address{
    padding-left: 30px; 
    color:var(--secondary-color);
    text-transform: capitalize;
    font-size:18px;
}
.your-order-header_address span{
    font-size:13px;
    color:#a1a1a1;    
}

.your-order-header_number{
    text-transform: capitalize;
    padding-left: 30px;
    padding-top: 0px;
}
.your-order-header_number span{
    color: #a1a1a1;
}



.your-order-header h4 {
    color: var(--secondary-color);
    font-size:24px;
    text-transform: capitalize;
    font-family: 'OpenSans-SemiBold';
    margin-bottom: 0px;
 
}

.your-order-header h4 span{
color: var(--primary-color);
font-size:20px;
margin-right: 10px;
}


.your-order-header p {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #e1eaf4;
    font-size: 16px;
    color: var(--secondary-color);
    font-family: 'OpenSans-SemiBold';
    text-transform: capitalize;
    width: 100px;
    height: 32px;
    margin-bottom: 0px;
    cursor: pointer;
  
}
.your-order-header p span{
    margin-left: 5px; 
    transition: 0.5s linear;   
}

.order-detail-overflow {
    background: #e2e2e2;
    height: 500px;
    overflow-y:scroll;
    padding: 15px;
}
.order-detail-overflow::-webkit-scrollbar {
  width: 5px;
}

.order-detail-overflow::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey; 
  border-radius: 10px;
}
 
.order-detail-overflow::-webkit-scrollbar-thumb {
  background: var(--secondary-color); 
  border-radius: 10px;
}


.order-detail-overflow::-webkit-scrollbar-thumb:hover {
  background: #b30000; 
}
.your-order-wrapper ul {
    list-style: none;
    margin: 0px;
    padding: 0px;
    margin-top: 30px;
}
.your-order-wrapper ul li{
    display: flex;
    justify-content: flex-start;
    align-items: center;
    padding: 20px 20px;
    background-color: #f7f7f7;
    border-bottom: 1px solid #ccc;
    
}

.your-order-wrapper ul li:first-child{
    border-top: 0px;
}

.your-order-wrapper ul li .your-order-img-wrap{
width: 75px;
height: 75px;
background-color: #e1eaf4;
display: flex;
align-items: center;
justify-content: center;
margin-right: 20px;
}


.your-order-wrapper ul li .your-order-img-wrap img
{
width: 100%;
height: 100%;
object-fit: contain;
} 
.your-order-wrapper ul li .your-order-img-wrap a img
{
width: 100%;
height: 100%;
object-fit: contain;
} 
.your-order-wrapper ul li .your-order-detail-wrap h6{
color: var(--secondary-color);
font-size: 18px;
font-family: 'OpenSans-SemiBold';
text-transform: capitalize;
margin-bottom: 0px;
}
.your-order-wrapper ul li .your-order-detail-wrap p{
 color: #000;
font-size: 16px;
font-family: 'OpenSans-SemiBold';
text-transform: capitalize; 
margin-bottom: 0px;  
text-align: left;
}

.your-order-wrapper ul li.total-wrap{
 padding: 10px 20px;   
 background-color: #e1eaf4;
 border-bottom: 1px solid #fff;
}

.total-count{
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
}
.total-count h6{
color: var(--secondary-color);
font-size: 18px;
font-family: 'OpenSans-SemiBold';
text-transform: capitalize; 
margin-bottom: 0px;  
text-align: left;
}
.total-count .price-seperator{
    display: flex;
    align-items:center; 
}
.total-count .price-seperator span.seperator{
    color: var(--secondary-color);
    font-weight: bolder;
}
.total-count .price-seperator p {
    margin-bottom: 0px;
    color: var(--primary-color);
    font-size: 20px;
    font-family: 'OpenSans-SemiBold';
    text-transform: capitalize;
    width: 120px;
    text-align: right;
}


/*===== whislist=====*/

.wishlist-items {
    display: flex;

align-items: center;
}

.wihslist-wrapper{
    padding: 20px 25px;
}



.wihslist-wrapper ul {
    list-style: none;
    margin: 0px;
    padding: 0px;
    margin-top: 30px;
}
.wihslist-wrapper ul li{
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 20px;
    background-color: #f7f7f7;
    border-bottom: 1px solid #ccc;
    position: relative;
}
.img-con-cart{
      display: flex; 
      align-items: center;
   }

.wihslist-wrapper ul li:first-child{
    border-top: 1px solid #999;
}
.wihslist-wrapper ul li .your-order-img-wrap{
width: 75px;
height: 75px;
background-color: #e1eaf4;
display: flex;
align-items: center;
justify-content: center;
margin-right: 20px;
}


.wihslist-wrapper ul li .your-order-img-wrap img
{
/*width: 100%;*/
max-width: 70px;
/*height: 100%;
object-fit: contain;*/
} 
.wihslist-wrapper ul li .your-order-detail-wrap h6{
color: var(--secondary-color);
font-size: 18px;
font-family: 'OpenSans-SemiBold';
text-transform: capitalize;
margin-bottom: 0px;
}
.wihslist-wrapper ul li .your-order-detail-wrap p{
 color: #999;
font-size: 16px;
font-family: 'OpenSans-SemiBold';
text-transform: capitalize; 
margin-bottom: 0px;  
text-align: left;
}
 
 .wishlist-items-btn {
    display: flex;
    align-items: center;
    justify-content: space-between;
 }
 .wishlist-items-btn .delete-item .fa-shopping-basket {
    color: #fff;
 }
.wihslist-wrapper .delete-item{
    width: 30px;
    height: 30px;
    background-color: var(--secondary-color);
    color: #f55d2c;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 5px;
    cursor: pointer;
}


/*============address ============*/
.address-wrapper{
    margin-bottom: 50px;
}
.address-wrapper .address-header button{
        width: 100%;
    max-width: 200px;
    height: 35px;
}
/*.address-wrapper ul {
    border-top: 1px solid #999999;
}*/
.address-wrapper ul li {
    padding: 20px 10px;
    background-color: #f7f7f7;
    display: block;
}
.address-wrapper .user-detail{
    display: flex;
    padding-left: 32px;
    align-items: center;
        margin-top: 10px;
}
.address-wrapper .user-detail span{
    width: 5px;
    height: 5px;
    background-color: #f55d2c;
    border-radius: 50%;
    margin: 0px 10px;
}
.address-wrapper .user-detail h6{
    font-size: 20px;
    color: var(--secondary-color);
    font-family: "OpenSans-Bold";
    margin-bottom: 0px;
}
.address-wrapper ul li  p {
    font-size: 18px;
    color: #666666;
    font-family: "OpenSans-SemiBold";
    margin-bottom: 0px;
    margin-top: 5px;
    padding: 0px 00px 0px 32px;
    max-width: 600px;
}
.address-wrapper ul li .address-list{
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.address-list .address-title{
    display: flex;
    align-items: center;   
}
.address-list .address-title span {
    width: 25px;
    height: 25px;
    background: var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 5px;
    color: var(--light-color);
    font-size: 15px;
    margin-right: 8px;
}

.address-list .address-title h6 {
    margin-bottom: 0px;
    font-size: 18px;
    color: var(--secondary-color);
    text-transform: capitalize;
    font-family: "OpenSans-SemiBold";
}


.address-operation{
    display: flex;
    align-items: center;
}
.address-operation span {
    width: 25px;
    height: 25px;
    background: var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 5px;
    color:var(--light-color);
    font-size: 15px;
    margin-right: 8px;
    cursor: pointer;
}



.address-chk-box {
    display: block;
    position: relative; 
    font-size: 14px;
    color: #666;
    padding: 5px 20px 5px 15px; 
    padding-right: 20px;
    background-color: #e1eaf4;
    margin-right:8px;
    color: var(--secondary-color);
    font-family: "OpenSans-Bold";
}

.address-chk-box.dn-btn:before{
    display: none;
}


.address-chk-box:before{
content:"";
position:absolute;
left:0px;
top:0px;
width:100%;
height:100%;
background:transparent;
z-index:22;
}

.address-chk-box.is_default:before{
    display:none;
}
.address-chk-box label {
    margin-bottom: 0px;
     cursor: pointer;
}

  
/* Hide the default checkbox */
.address-chk-box input[type=checkbox] {
    visibility: hidden;
}
  
/* Creating a custom checkbox
based on demand */
.address-chk-box .blue {
   position: absolute;
    top: 8px;
    right: 5px;
    height: 15px;
    width: 15px;
    background-color: transparent;
    border: 1px solid var(--secondary-color);
    border-radius: 5px;
}
  

  
/* Specify the background color to be
shown when checkbox is checked */
.address-chk-box input:checked ~ .blue {
    background-color: var(--secondary-color);
}
  
/* Checkmark to be shown in checkbox */
/* It is not be shown when not checked */
.blue:after {
    content: "";
    position: absolute;
    display: none;
}
  
/* Display checkmark when checked */
.address-chk-box input:checked ~ .blue:after {
    display: block;
}
  
/* Styling the checkmark using webkit */
/* Rotated the rectangle by 45 degree and 
showing only two border to make it look
like a tickmark */
.address-chk-box .blue:after {
   left: 4px;
    bottom: 3px;
    width: 5px;
    height: 9px;
    border: solid white;
    border-width: 0 2px 2px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}



.address-chk-box .radio-container {
  display: block;
  position: relative;
  padding-left: 13px;
  cursor: pointer;
  font-size: 13.5px;
    color: var(--secondary-color);
  font-family: "OpenSans-Bold";
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  text-align: center;
}

/* Hide the browser's default radio button */
.address-chk-box .radio-container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.address-chk-box .checkmark {
   position: absolute;
   top: 2px;
   left: -7px;
   height: 15px;
   width: 15px;
   background-color: #fff;
   border-radius: 50%;
   /* border-color: red; */
   border: 1px solid #999;
}

/* On mouse-over, add a grey background color */
.address-chk-box .radio-container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.address-chk-box .radio-container input:checked ~ .checkmark {
  background-color: #fff;
   border-color: #f55d2c;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.address-chk-box .checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.address-chk-box .radio-container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.address-chk-box .radio-container .checkmark:after {
     top: 3px;
    left: 3px;
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #f55d2c;
}




.address-wrapper .address-header.new-add-header{
    border-bottom: 1px solid #999;
    padding-bottom: 10px;
}
.address-wrapper .address-header.new-add-header button{
    max-width: 300px;
}

.new-address-wrap{
    display: none;
    transition: 0.5s linear;
}
.new-address-wrap.add-visible {
    display: block;
}
.address-wrapper .address-form{
margin-top: 30px;
}
.address-wrapper .address-form .input-wrapper{
    position: relative;
}
.address-wrapper .address-form .input-wrapper.add-text{
    padding: 5px 5px 0px 20px;
    height: 110px;
    align-items: flex-start;

}
.address-wrapper .address-form .input-wrapper.add-text textarea{
    height: 100px;
    width: 100%;
    border: 0px;
    font-family: 'OpenSans-SemiBold';
     color: #666666;
     font-size: 20px;
}

.address-wrapper .address-form .input-wrapper.add-text textarea::placeholder{
    text-transform: capitalize;
     font-family: 'OpenSans-SemiBold';
     color: #666666;
     font-size: 20px;
}
.add-new-address-wrapper form {
    padding: 0px 15px;
}
.add-new-address-wrapper .address-form .input-wrapper.add-text{
    padding: 5px 5px 0px 20px;
    height: 110px;
    align-items: flex-start;

}
.add-new-address-wrapper .address-form .input-wrapper.add-text textarea{
    height: 100px;
    width: 100%;
    border: 0px;
    font-family: 'OpenSans-SemiBold';
     color: #666666;
     font-size: 20px;
}

.add-new-address-wrapper .address-form .input-wrapper.add-text textarea::placeholder{
    text-transform: capitalize;
     font-family: 'OpenSans-SemiBold';
     color: #666666;
     font-size: 20px;
}

.address-wrapper .address-form select{
    -moz-appearance: none;
    -webkit-appearance: none;
    appearance: none;
    width: 100%; 
    border: 0px;
    font-family: 'OpenSans-SemiBold';
    color: #666;
    height: 50px;
    font-size: 20px;
    position: relative;
    
}
.select-down-arrow{
    position: absolute;
    right: 0px;
    color: #666666 !important;
}
.address-wrapper .address-form select:focus{
    border:0px;
    outline: 0px;
}

.address-wrapper .address-form .save-btn{
    width: 100%;

}

.address-wrapper .address-form .cancel-btn{
    width: 100%;
    background-color: #f55d2c;
    border-color: #c63b0e;
}
.address-wrapper .address-form .cancel-btn:hover{
    background-color: transparent;
    color: #f55d2c;
}

/*==============================*/
     /*-----17. PRODUCT DETAIL-----*/
/*==============================*/


.product-detail-wrapper .in-stock{
    display: inline-block;
    background-color:var(--primary-color);
    padding: 6px 13px;
    border-radius: 3px;
}
.product-detail-wrapper .in-stock h6 {
    margin-bottom: 0px;
    color: #fff;
    font-size: 20px;
    font-family: "OpenSans-Bold";
    text-transform:capitalize;
}

.product-detail-wrapper h1{
    margin-bottom: 0px;
    color: var(--secondary-color);
    font-size: 30px;
    font-family: "OpenSans-Bold";
    text-transform: inherit;
    margin:20px 0px;
}

.product-detail-wrapper .product-price p{
    margin-bottom: 0px;
    color: var(--primary-color);
    font-size: 25px;
    font-family: "OpenSans-Bold";
    text-transform:uppercase;
}

.product-detail-wrapper .product-price p span.orginal-price{
    color: #666;
    margin-left: 25px;
    position: relative;
    z-index: 0;
}
.product-detail-wrapper .product-price p span.orginal-price::after{
    content: "";
    position: absolute;
    width: 115%;
    height: 2px;
    background-color: #666;
    top: 50%;
    left: -7px;
    right: 0px;
    margin:0 auto;
    transform: translate(0px,-50%);
    z-index: 1;
}

.product-detail-wrapper .product-vairant{
    margin:25px 0px;
}
.product-detail-wrapper .product-vairant .variant{
    background-color: #e1eaf4;
    font-size: 16px;
    color: var(--secondary-color);
     font-family: "OpenSans-Bold";
     padding: 5px 10px;
     cursor: pointer;
     margin-right: 8px;
    margin-bottom: 10px;
    display: inline-block;
}

.product-detail-wrapper .product-vairant .variant.active{
background-color: var(--primary-color);
color: #fff;
}

.product-detail-wrapper .order-btn{
    margin:30px 0px;
    display: flex;
}
.product-detail-wrapper .order-btn button span{
margin-right: 5px;
}

.product-detail-wrapper .order-btn button.hover{
    margin-left: 10px;
    background-color: #fff;
    color: var(--primary-color);
}

.product-detail-wrapper .order-btn button.hover:hover{
    color: #fff;
    background-color: var(--primary-color);
}

.product-detail-wrapper .product-description{
    border-top: 1px solid #ccc;
    padding-top: 25px;
}

.product-detail-wrapper .product-description h6{
     font-size: 18px;
    color: var(--secondary-color);
     font-family: "OpenSans-SemiBold";
     text-transform: capitalize;
}

.product-detail-wrapper .product-description p{
    font-size: 16px;
    color:#666666;
      font-family: "OpenSans-Regular";
}

.product-detail-wrapper .product-description span{
    font-size: 16px;
    color:#666666; 
      font-family: "OpenSans-Regular";
}

.product-slider{
    background-color: #fff;
    padding: 20px 25px;
    border-radius: 5px;
}


.product-slider .wishlist-wrapper{
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
}
.product-slider .wishlist-wrapper .offer-wrap{
    background-color: #f55d2c;
    padding: 7px 10px;
    border-radius:3px;
}
.product-slider .wishlist-wrapper .offer-wrap p {
    color: #fff;
    margin-bottom: 0px;
    font-family: 'OpenSans-Bold';
}
.product-slider .wishlist-wrapper .wishlist-icon{
    background-color: #fdead6;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
}

.product-slider .wishlist-wrapper .wishlist-icon i{
    color: #f55d2c;
}


 .slider-for{
      margin-top: 25px;
    }
  .main-img-wrapper{
    width: 100%;
  height: 500px !important;
  }
  .main-img-wrapper img{
    width: 100% !important;
    height: 100% !important;
    object-fit: contain !important;
  }
  .slick-dots{
    display: none !important; 
  }
  .slick-arrow{
   display: none !important;  
  }
  .slick-slide div{
    text-align: center;
  }
  .slider-nav{
    margin-top: 30px;
  }
  .thumnail{
    background-color: #f7f7f7;
    text-align: center;   
    width: 100px !important;
    height: 100px !important;
    display: flex !important;
    justify-content: center;
    align-items: center;
    margin: 0 auto;
    cursor: pointer;
    padding: 5px;
  }
  .thumnail img {
    width: 100%;
    height: 100%;
    margin:0 auto;
    object-fit: contain;
  }


/*==============================*/
 /*-----18. CART PAGE-----*/
/*==============================*/
.cart-table-wrapper{
    background-color: #fff;
    padding: 25px;
    box-shadow: 0px 0px 14px 2px rgb(11 51 67 / 15%);
    border: 1px solid #e5e2e2;
    /* height: 100%; */
}

table.rt-responsive-table td, table.rt-responsive-table th{
    border: 0px;
}
.cart-table{
    width: 100%;
    margin-bottom: 25px;
}
.cart-table tr th{
    text-transform: capitalize;
    color: var(--secondary-color);
    font-family: "OpenSans-Bold";
    border:0px;
    font-size: 18px;
    background-color: #fff;
    padding: 0px 0px 25px 0px;
}
.w-50{
    width: 50%;
}

.w-20{
    width: 20%;
}

.w-10{
    width:10%;
}

.cart-table tbody tr{
    background-color: #f7f7f7 !important;
    border-bottom: 1px solid #ccc;
}

.cart-table tbody tr td{
    vertical-align: middle;
    padding: 20px 5px;
}
.cart-table tbody tr:first-child td{
    border-top: 1px solid #999999 !important;
}
/*.cart-table tbody tr:last-child{
    border-bottom:0px;
}
*/
.cart-table tbody tr td p {
    color: var(--primary-color);
    font-size: 16px;
    font-family: "OpenSans-SemiBold";
    margin-bottom: 0px;
}
.cart-table tbody tr td p.discount-on{
    color: #666;
    position: relative;
    z-index: 1;
    display: inline-block;
    font-size:14px; 
}
.cart-table tbody tr td p.discount-on:before{
        content: "";
    position: absolute;
    width: 130%;
    height: 2px;
    background-color: #666;
    bottom: 5px;
    left: -5px;
    top: 50%;
    right: 0px;
    margin: 0 auto;
    z-index: 2;

}
.cart-table tbody tr td .cart-item {
    display: block;
    display: flex;
    align-items: center;
}
/*.cart-table tbody tr td .cart-item:last-child{
 border-bottom: 0px;   
}*/
.cart-table tbody tr td .cart-item .cart-img-wrap{
width: 75px;
height: 75px;
background-color: #e1eaf4;
display: flex;
align-items: center;
justify-content: center;
margin-right: 20px;
}


.cart-table tbody tr td .cart-item .cart-img-wrap img
{
width: 100%;
/*max-width: 70px;*/
height: 100%;
object-fit: contain;
} 
.cart-table tbody tr td .cart-item .cart-detail-wrap h6{
color: var(--secondary-color);
font-size: 16px;
font-family: 'OpenSans-SemiBold';
text-transform: capitalize;
margin-bottom: 0px;
}
.cart-table tbody tr td .cart-item .cart-detail-wrap p{
 color: #999;
font-size: 16px;
font-family: 'OpenSans-SemiBold';
text-transform: capitalize; 
margin-bottom: 0px;  
text-align: left;
}
.cart-table tbody tr td .delete-item{
    width: 30px;
    height: 30px;
    background-color: var(--secondary-color);
    color: #f55d2c;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 5px;
    cursor: pointer;
    margin:0 auto;
}

.discount-coupon{
    display: flex;
    align-items: center;
    justify-content:space-between;
}

.discount-coupon .input-wrapper{
  max-width: 270px;
    height: 50px;
    margin-bottom: 0;
}
.update-cart-btn{
    margin-left: auto;
}
.cart-total-wrap{
    background-color: #fff;
    box-shadow: 0px 0px 14px 2px rgb(11 51 67 / 15%);
     border: 1px solid #e5e2e2;
}

.cart-total-wrap .cart-total-heading{
    background-color: var(--secondary-color);
    padding: 10px 12px;
}

.cart-total-wrap .cart-total-heading h6{
    color: #fff;
    font-size: 20px;
    text-transform: capitalize;
    margin-bottom: 0px;
    font-family: "OpenSans-SemiBold";
}
.cart-total-wrap .cart-total-heading h6 span{
    color: var(--primary-color);
    padding-right: 5px;
}

.cart-total-wrap .cart-total-innerbox{
    padding: 10px 15px;
}
.cart-total-wrap .cart-total-innerbox .total-count{
    border-bottom: 1px solid #ccc;
    padding: 10px 0px;
}

.cart-total-wrap .cart-total-innerbox p.instruc {
    padding: 10px 10px;
    background-color: #f7f7f7;
    color: #666666;
    margin-top: 10px;
    font-family: "OpenSans-SemiBold";
    font-size: 14px;
}
.cart-total-wrap .cart-total-innerbox a{
    width: 100%;
    display: inline-block;
    width:100% ;
    height: 100%;
    object-fit: contain;
}

.cart-total-wrap .cart-total-scroll{
    height: 320px;
    overflow-y: scroll;

}
.cart-total-wrap .cart-total-scroll::-webkit-scrollbar {
    width: 5px;
    height: 30px;
  }
  /* Track */
  .cart-total-wrap .cart-total-scroll::-webkit-scrollbar-track {
    box-shadow: inset 0 0 5px grey; 
    border-radius: 2px;
  }
   
  /* Handle */
  .cart-total-wrap .cart-total-scroll::-webkit-scrollbar-thumb {
    background: #1ebcb7; 
    border-radius: 10px;
  }
  


/*==============================*/
 /*-----19. CHECKOUT PAGE-----*/
/*==============================*/

.order-summary-box{
    height: 100%;
    overflow: inherit;
       padding: 0px 15px !important;
}

.order-summary-box ul {
    margin-top: 0px;
}
.order-summary-box ul li{
    background-color: transparent;
    position: relative;
}
.order-summary-box ul li .cart-delete{
position: absolute;
right: 10px;
cursor: pointer;
}
.order-summary-box ul li:last-child {
    border-bottom: 0px;
}
.order-summary-box ul li.total-wrap{
    background-color: #f7f7f7 !important;
}
.order-summary-box ul li .total-count{
    border-bottom: 0px !important;
    background-color: #f7f7f7 !important;
        padding: 0px 0px !important;
}
.order-summary-box ul li.saving{
    padding:10px 20px 
    display: flex;
    flex-direction: column;
}

.order-summary-box ul li.saving input{
    width: 100%;
    height: 45px;
    padding: 0px 10px;
    border: 1px solid #999999;
    border-radius: 5px;

}


.order-summary-box ul li.saving button{
    width: 100%;
    height: 45px;
    margin-top: 10px;
    /*padding: 0px 10px;*/
}
.order-summary-box ul li.saving button:active,.order-summary-box ul li.saving button:focus{
    background-color: var(--primary-color) !important;
       border-color: var(--primary-color) !important;
       color: #fff !important;
}

.order-summary-box ul li.saving p {
    margin-bottom: 0px;
    color: var(--primary-color);
    font-size: 14px;
    font-family: "OpenSans-SemiBold";
}

.order-summary-box ul li.saving p span{
    color: var(--primary-color)
}

.order-summary-box ul li.saving h6{
    font-size: 16px;
    color: #666666;
    margin-bottom: 0px;
    font-family: "OpenSans-SemiBold";
    display: flex;
    align-items: center;   
    width: 100%;
}

.order-summary-box ul li.saving h6 img {
    margin-right: 15px;
    width: 100%;
    max-width: 20px;
}


.billing-wrapper .address-wrapper{
    margin-bottom: 0px;
    
}
.billing-wrapper .address-wrapper ul li{
border-bottom: 1px solid #ccc;
}
.billing-wrapper .billing-header{
    display: flex;
    align-items: flex-start;
    justify-content:space-between;
    border-bottom: 1px solid #999;
    padding-bottom: 10px;
    margin-bottom: 20px;
}
 
 .billing-wrapper .billing-header h4 {
    color: var(--secondary-color);
    font-size: 24px;
    font-family: "OpenSans-Bold";
  
 }
 .billing-wrapper .billing-btns {
  background-color: var(--secondary-color);
  color: #fff;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 18px;
  transition: 0.4s;
  font-family: "OpenSans-SemiBold";
  margin-bottom: 25px;
}

.billing-btns.active + panel {
    height: 100% !important;
    max-height: 100% !important;
}
.billing-wrapper .billing-btns:hover {
  background-color: var(--primary-color);
}

.billing-wrapper .billing-btns:after {
  content: '\002B';
  float: right;
  margin-left: 5px;
  width: 15px;
  height: 15px;
  background-color: #f55d2c;
  display: flex;
  align-items: center;
   justify-content: center;
   border-radius: 5px;
   color: var(--secondary-color);
   font-size: 14px;
   font-weight: bold;
   position: relative;
   top: 5px;
}

.billing-wrapper .billing-btns.active:after {
  content: "\2212";
}

.billing-wrapper .panel {
  padding: 0 0px;
  background-color: #fff;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
}
.billing-wrapper .panel.full_height{
max-height: 100% !important;
}

.billing-wrapper .billing-btn{
    display: flex;
    justify-content: flex-end;
}

.billing-wrapper .billing-btn .btn{
width: 200px;
margin: 10px 10px;
}
.billing-wrapper .billing-btn .next-btn{
width: 150px;
}

.add-new-address-wrapper{
    background-color: #f7f7f7;
    margin: 15px 0px;
    display: none;
    transition: 0.5s linear;
}
.add-new-address-wrapper .new-add-header {
    display: flex;
    align-items: center;
    background-color: var(--primary-color);
    justify-content: space-between;
    padding: 5px 18px;
}
.add-new-address-wrapper .new-add-header p {
    color: #fff;
    font-size: 20px;
    margin-bottom: 0px;
}

.add-new-address-wrapper .new-add-header button {
    border: 0px;
    background-color: transparent;
    color: #fff;
    text-transform: capitalize;
    font-size: 20px;
}


.add-new-address-wrapper .address-form{
margin-top: 30px;
}
.add-new-address-wrapper .address-form .input-wrapper{
    position: relative;
}

.add-new-address-wrapper .address-form select{
    -moz-appearance: none;
    -webkit-appearance: none;
    appearance: none;
    width: 100%; 
    border: 0px;
    font-family: 'OpenSans-SemiBold';
    color: #666;
    font-size: 20px;
    height: 50px;
}
.add-new-address-wrapper .address-form select:focus{
    border:0px;
    outline: 0px;
}

.add-new-address-wrapper .address-form .save-btn{
    width: 100%;

}

.add-new-address-wrapper .address-form .cancel-btn{
    width: 100%;
    background-color: var(--primary-color);
    border-color: var(--border-color);
}
.add-new-address-wrapper .address-form .cancel-btn:hover{
    background-color: transparent;
    color: var(--primary-color);
}

/*=========== date picker ===========*/
.date-time-common{
    padding: 25px 15px;
    background-color: #f7f7f7; 
    display: flex;
    justify-content: space-between;
    border-bottom: 1px solid #999;
}

.ui-widget.ui-widget-content {
    width: 100% !important;
    left:0px !important;
}

.ui-datepicker-calendar .ui-state-default {
    width: 100% !important;
}

.date-wrap{
    width: 49%;
}

.time-wrap{
    width: 49%;
}

.datepicker{
    position: relative;
}

.ui-datepicker {
  display: none;
  background-color: #fff;
  box-shadow: 0 0.125rem 0.3rem rgba(0, 0, 0, 0.2);
  border-radius: 0.5rem;
  padding: 0.5rem;
  border:1px solid #999;

}
.ui-datepicker-calendar table {
  border-collapse: collapse;
  border-spacing: 0;
  
}

/*.ui-datepicker-calendar{
   margin-left: 10px !important;  
}*/
.ui-datepicker-calendar thead th {
  padding: 0.25rem 0;
  text-align: center;
  font-size: 0.8rem;
  font-weight: 400;
  color: #353535;
}
.ui-datepicker-calendar tbody td {
  width: 2.5rem;
  text-align: center;
  padding: 0;
}
.ui-datepicker-calendar tbody td a {
  display: block;
  border-radius: 5px;
  line-height: 2rem;
  transition: 0.3s all;
  color: var(--secondary-color);
  font-size: 0.875rem;
  text-decoration: none;
  width: 2rem;
  height: 2rem;
  line-height: 2rem;
   font-family: "OpenSans-SemiBold";
}
.ui-datepicker-calendar tbody td a:hover {
  background: #f55d2c;
  color: #ffffff;
}
.ui-datepicker-calendar tbody td a.ui-state-active {
  background: var(--primary-color);
  color: #ffffff !important;
  font-family: "OpenSans-Bold";
  border: 1px solid var(--primary-color);
}
.ui-datepicker-calendar tbody td a.ui-state-highlight {
  color: #f55d2c;
  border: 1px solid #f55d2c;
  font-family: "OpenSans-Bold";
}
.ui-datepicker-header a span {
  display: none;
}
.ui-datepicker-header a.ui-corner-all {
  cursor: pointer;
  position: absolute;
  top: 0;
  width: 2rem;
  height: 2rem;
  margin: 0.5rem;
  border-radius: 0.5rem;
}
.ui-datepicker-header a.ui-datepicker-prev {
  left: 0;
}
.ui-datepicker-header a.ui-datepicker-prev::after {
 font-family: 'Font Awesome 5 Free';
    content: "\f053";
    font-size: 15px;
    color: #ffffff;
    font-weight: 700;
    width: 25px;
    height: 25px;
    background: var(--secondary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 5px;
}
.ui-datepicker-header a.ui-datepicker-next {
  right: 0;
}
.ui-datepicker-header a.ui-datepicker-next::after {
  font-family:'Font Awesome 5 Free';
  content:"\f054";
   font-size: 15px;
    color: #ffffff;
    font-weight: 700;
    width: 25px;
    height: 25px;
    background: var(--secondary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 5px;
}

.ui-datepicker-title {
     text-align: center;
    line-height: 27px;
    font-size: 18px;
/*    padding-bottom: 20px;*/
    color: var(--secondary-color);
    font-family: "OpenSans-Bold";
}


.ui-datepicker .ui-datepicker-prev span, .ui-datepicker .ui-datepicker-next span{
    display: none !important;
}

.ui-datepicker-week-col {
  color: #353535;
  font-weight: 400;
  font-size: 0.75rem;
}

.ui-datepicker-calendar thead {
  border-bottom: 1px solid #ccc;
}
.ui-datepicker-calendar thead th {
  color: var(--secondary-color);
  font-family: "OpenSans-Bold";
  font-size: 16px;
}


/*=========== time picker ===========*/
.time-box{
    border:1px solid #999;
    padding: 15px 15px;
    background:#fff;
    width: 100%;
    border-radius: 0.5rem;
    box-shadow: 0 0.125rem 0.3rem rgb(0 0 0 / 20%);
}
.time-title h6{
    font-size: 22px;
    color: var(--secondary-color);
    font-family: "OpenSans-SemiBold";
    text-align: center;
    border-bottom: 1px solid #ccc;
    margin-bottom: 0px;
    padding-bottom: 15px;
}
.radio-wrap{
    margin-top: 27px;
}

.radio-wrap .row div{
    padding: 0px;
}
.radio-container {
  display: block;
  position: relative;
  padding-left: 13px;
  margin-bottom: 22px;
  cursor: pointer;
  font-size: 13.5px;
    color: var(--secondary-color);
  font-family: "OpenSans-Bold";
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  text-align: center;
}

/* Hide the browser's default radio button */
.radio-container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
   position: absolute;
   top: 5px;
   left: 6px;
   height: 10px;
   width: 10px;
   background-color: #fff;
   border-radius: 50%;
   /* border-color: red; */
   border: 1px solid #999;
}

/* On mouse-over, add a grey background color */
.radio-container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.radio-container input:checked ~ .checkmark {
  background-color: #fff;
   border-color: var(--primary-color);
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.radio-container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.radio-container .checkmark:after {
     top: 2px;
    left: 2px;
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: var(--primary-color);
}

.pay-btn {
    margin: 20px 18px;
    text-align: right;
}

.pay-btn button.btn{
    width: 250px;
    margin-left: auto;
}


/*=====payment wraper====*/
.payment-wrapper{
    padding: 25px 15px;
    background-color: #f7f7f7;
    border-bottom: 1px solid #999;
}
.payment-options{
    display: flex;
    /*justify-content: space-between;*/
    flex-wrap: wrap;
}
.payment-options .option-1{
    background-color: #fff;
    border:1px solid #666;
    width: 200px;
    height: 50px;
    border-radius: 3px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0px 5px;
    cursor: pointer;
}

.payment-options .option-1 .checkmark{
    left: 0px;
}

/*==========*/
.debit-wrapper{
    display: none;
}

.debit-wrapper  h6{
    font-size: 20px;
    color: var(--secondary-color);
    font-family: "OpenSans-Bold";
    margin: 25px 0px;

}
.debit-wrapper .select-wrapper p{
      text-transform: capitalize;
     font-family: 'OpenSans-SemiBold';
     color: #757575;
     font-size: 20px;
     margin-bottom: 0px;
}
.debit-wrapper .select-wrapper select{
    border:0px;
    background-color: #e1eaf4;
    color: #757575;
    padding: 3px;
    margin: 0px 5px;
}


.debit-wrapper .cvv::placeholder{
text-transform: uppercase !important;
}

.debit-wrapper .input-wrapper{
    position: relative;
}

.cvv-wrap{
    position: relative;
}
.cvv-info {
    right: 0px;
    position:absolute;

}
.cvv-info span{
    color: #666;
    cursor: pointer;
}

.cvv-wrap p{
color: #666;
font-size: 14px;
font-family: "OpenSans-SemiBold";
margin-bottom: 0px;
position: absolute;
right: 0;
top: -31px;
padding: 5px;
background: #e1eaf4;
border-radius: 5px;
z-index: 4;
display: none;
transition: 1s linear;
animation: up 1s;
}
@keyframes up {
from{
    top: -20px;
    opacity: 0.5;
}
to{
 top: -32px;
     opacity: 1;
}
}

.cvv-wrap p:after{
    content: "";
    position: absolute;
    width: 14px;
    height: 15px;
    right: 23px;
    bottom: -8px;
    transform: rotate(
45deg
);
    background-color: #e1eaf4;
    z-index: -1;
}

.netbanking-wrapper{
    display: none;
}

.cod-wrapper{
    display: none;
}



/*==============================*/
 /*-----20.VENDOR PAGE-----*/
/*==============================*/
.vendor-card{
    background-color: #fff;
    padding: 25px;
    box-shadow: 0px 0px 14px 2px rgb(11 51 67 / 15%);
}

.vendor-card .vendor-heading h6{
    color: var(--secondary-color);
    font-size: 24px;
    font-family: "OpenSans-Bold";
    border-bottom:1px solid #999999;
    padding-bottom: 20px;
    margin-bottom: 0px;
}

.vendor-loc{
    background-color: #f7f7f7;
    padding:15px;
    margin: 20px 0px; 
    border-bottom: 1px solid #ccc;
    height: 90%;
}
.vendor-loc .vendor-header{
    display: flex;
    justify-content: flex-end;
}

.vendor-1{
    display: flex;

}

.vendor-1 .vendor-img {
    width: 125px;
    height: 125px;
    margin-right: 25px;
}

.vendor-1 .vendor-img img {
    width: 125px;
    height: 125px;
    object-fit: contain;
}

.vendor-1 .vendor-detail h5{
    font-size: 20px;
    color: var(--secondary-color);
    font-family: "OpenSans-Bold";
    margin-bottom: 0px;
}

.vendor-1 .vendor-detail p{
    font-size: 16px;
    color: #666;
    font-family: "OpenSans-Regular";
    margin-bottom: 0px;
    margin-top: 8px;
}

.vendor-1 .vendor-detail p:last-child{
    margin-top: 0px;
}

.vendor-loc .address-chk-box{
    color: #666;
    border-radius: 5px; 
}

.vendor-loc .address-chk-box .blue{
border: 1px solid #666;
right: 15px;
}
.vendor-loc .address-chk-box input:checked ~ .blue {
    background-color: #f55d2c !important;
    border-color: #f55d2c !important;
}

.vendor-loc .address-chk-box.checked{
 color: #f55d2c;
 background-color: var(--secondary-color);   
}

.current-location {
    text-align: right;
    margin-top: 40px;
}

.current-location button.btn{
    width:250px;
    display: inline-block;
}
.current-location button.btn-orange{
    width:150px;
    display: inline-block;
}


/*==============================*/
 /*----- 21.ABOUT PAGE-----*/
/*==============================*/
.about-detail h5{
    font-size:30px;
    color: var(--secondary-color);
    font-family: "OpenSans-SemiBold";
    margin-bottom: 0px;   
}


.about-detail p{
    font-size:18px;
    color: #666;
    font-family: "OpenSans-Regular";
    margin-top: 50px;
    margin-bottom: 0px;   
}

.about-img{
    text-align: center;
}
.about-img img {
    width: 100%;
    max-width:450px; 
}

.counter-wrapper{
    background: #fff;
    padding: 30px;
    margin-bottom: 25px;
}

.counter-img{
    width: 140px;
    height: 140px;
    padding: 10px;
    border-radius: 50%;
    background-color: #f7f7f7;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 auto;
}
.counter-img img {
    width: 100px;
}

.counter-detail{
    text-align: center;
    margin-top: 25px;
}
.counter-detail h6{
    font-size: 35px;
    margin-bottom: 0px;
    color: var(--secondary-color);
    font-family: "OpenSans-Bold";
    text-transform: capitalize;
    display: inline-block;
}
.counter-detail {
      font-size: 35px;
    margin-bottom: 0px;
    color: var(--secondary-color);
    font-family: "OpenSans-Bold";
}

.counter-detail p{
    font-size: 20px;
    color: #666;
    margin-bottom: 0px;
     font-family: "OpenSans-SemiBold";
     text-transform: capitalize;
}


.client-title h6{
    color: #fff;
    font-size: 30px;
     font-family: "OpenSans-SemiBold";
    margin-bottom: 0px;  
}


.client-wrapper{
    background-color: #fff;
    padding:15px; 
    border-radius: 5px;
    height: 250px;
    position: relative;
}

.client-wrapper p {
    color: #666;
    margin-bottom: 0px;
    font-size: 18px;
}


.client-name {
    background-color: var(--secondary-color);
    padding: 10px;
    border-radius: 5px;
    margin-top: 25px;
    position: absolute;
    bottom: 7px;
    left: 0;
    right: 0;
    width: 95%;
    margin: 0 auto;
}


.client-name h4{
    color: #fff;
    text-transform: capitalize;
    font-family: "OpenSans-SemiBold";
    font-size: 20px;

}

.client-name h5{
    color: var(--primary-color);
    font-size: 15px;
    margin-bottom: 0px;
     font-family: "OpenSans-SemiBold";
}

.client-img{
    width: 100px;
    height: 100px;
    background-color: #ccc;
    border-radius: 5px;
    position: absolute;
    right: 10px;
    top: -20px;
    display: none;
}

.client-img img {
    width: 100%;
    height: 100%;
    display: none;
}

/*client slider*/
/*.owl-carousel.client-owl-slider .owl-stage-outer {
    margin-left: 100px;
}*/

.owl-carousel.client-owl-slider .owl-nav{
    display: none !important;
}

.owl-carousel.client-owl-slider .owl-dots {
    margin-top: 20px !important;

}

.owl-carousel.client-owl-slider .owl-dots .owl-dot span{
    background-color: #fff ;
    opacity: 0.3;
    width: 40px;
    height: 7px;
    border-radius: 5px;
}
.owl-carousel.client-owl-slider .owl-dots .owl-dot.active span{
    opacity: 1;
}

/*==============================*/
 /*----- 22.CONTACT US PAGE-----*/
/*==============================*/
.contact-us{
    position: relative;
}
.spices{
    position: absolute;
    right: 0px;
    width: 100%;
    max-width:500px;
}
.contact-us h1{
    font-size:36px;
    color: var(--secondary-color);
    font-family: "OpenSans-Bold";
    text-transform: capitalize;
    margin-bottom: 0px; 
}

.contact-us form {
    margin-top: 30px;
}

.contact-us form button {
    width: 100%;
    height: 60px;
    font-size: 22px;
}

.contact-address-wrap{
    border-top: 1px solid transparent !important;
    margin-top: 50px;
    padding-left: 30px;

}
.contact-address-wrap .location{
    /*text-align: left;*/
    margin: 0 auto;
}

.location {
	display: flex;
}

.contact-address-wrap .location.loc-1{
    margin-bottom: 50px;
    text-align: left;
}

.contact-address-wrap .location span{
    color: var(--primary-color);
    font-size: 23px !important; 
}

.contact-address-wrap .location h6{
    font-size: 25px;
    color: var(--secondary-color);
    font-family: "OpenSans-SemiBold";
    text-transform: capitalize;
    text-align: left;
}

.contact-address-wrap .location p{
    font-size: 18px;
    color: #666;
    font-family: "OpenSans-Regular";
    max-width: 450px;
    margin-bottom: 0px;
    margin:0px auto;
} 


/*==============================*/
     /*-----1. FONT FAMILY-----*/
/*==============================*/
.policy-wrapper{
    background-color: #fff;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 25px;
}
.policy-wrapper h5 {
 font-size: 25px;
    color: var(--secondary-color);
    font-family: "OpenSans-SemiBold";
}


.policy-wrapper p{
    font-size: 18px;
    color: #666;
    font-family: "OpenSans-Regular";
    margin-bottom: 0px;
} 


/*=================================
=========== ORDER SUCCESS ==========
=================================*/


.order_success{
       padding: 100px 0px;
        display: flex;
        justify-content: center;
        align-items: center;

    }
.order_success_wrapper{
    background: #fff;
    padding: 50px;
    border-radius: 15px;
    box-shadow: 0px 4px 17px -1px rgba(0,0,0,0.72); 
}
.order_success_container{
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
.order_success_container h1{
    text-transform: capitalize;
    margin: 0px;
    color: var(--secondary-color);
}
.order_success_container h4{
    margin: 0px;
    margin-top: 10px;
    font-size: 22px;
}
.order_success_container p{
    font-size: 18px;
    color: #6b6b6b;
    margin-top: 25px;
}
.order_success_container a{
    display: inline-block;
    padding: 10px 15px;
    border: var(--secondary-color);
    color: var(--secondary-color);
    text-decoration: none;
    font-size: 18px;
    margin-top: 10px;
    border-radius: 15px;
}


/*=================*/
.pickup_timming h6 {
    font-size: 20px;
    color: var(--secondary-color);
    font-family: "OpenSans-Bold";
    margin-bottom: 0px;
}
.pickup_timming p{
    font-size: 18px;
    color: #666666;
    font-family: "OpenSans-SemiBold";
    margin-bottom: 0px;
    margin-top: 5px;
    
    max-width: 600px;
}




/* 
order successfull
*/

#order_success .modal-dialog {
    position: absolute;
    width: 100%;
    left: 50%;
    top: 50%;
    transform: translate(-50%,-50%);
}

#order_success .modal-header {
    border: 0 !important;
    padding: 10px;
}

#order_success h3,h5 {
    color: #04527a;
    text-transform: capitalize;
    margin-bottom: 0;
}

#order_success .modal-body {
    padding: 0 0 50px;
}

#order_success h3 {
    font-weight: 700;
}

#order_success .bag {
    width: 100%;
    max-width: 140px;
}

#order_success p {
    font-size: 19px;
    font-weight: 500;
    text-transform: capitalize;
}

#order_success .shopping_btn {
    display: inline-block;
    background-color: #04527a;
    text-transform: uppercase;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
}

#order_success .shopping_btn:hover {
    text-decoration: none;
    color: #fff;
}

#order_success .fa-shopping-bag {
    color: #04527a;
    font-size: 99px;
}

#payBtn_error{
    color: red;
    position: relative;
    left: 7px;
    top: 20px;
}



#payment_fail .modal-dialog {
    position: absolute;
    width: 100%;
    left: 50%;
    top: 50%;
    transform: translate(-50%,-50%);
}
#payment_fail .retry_btn {
  color: #fff;
  display: inline-block;
  background: red;
  border-radius: 5px;
  padding: 10px 25px;
  text-transform: capitalize;
}
#payment_fail a:hover {
  text-decoration: none;
  color: #fff;
}

#payment_fail h3,
#payment_fail p {
  text-transform: capitalize;
}

#payment_fail .fa-ban {
  font-size: 90px;
  color: red;
}





/* 
sec navbar
*/

.sec_navbar ul li {
    margin: 0;
    padding: 0;
    list-style: none;
    display: inline-block;
}

.sec_navbar ul {
    margin: 0;
}

.sec_navbar ul li a {
    /* color: var(--na); */
    color:var(--navbarColor);
    text-transform: capitalize;
    margin-right : 10px;
    font-size: 16px;
    font-family: 'OpenSans-SemiBold';
    transition: 0.5s;
}

.sec_navbar ul li a:hover {
    color: var(--hvrClr);
}


/* 
about section
*/

.abt_section {
    overflow: hidden;
    background:#fff;
}
.abt_content{
    position: relative;
    z-index: 9;
}
.abt_content h2 {
    color: #0B3343;
    font-family: 'OpenSans-Bold';
    font-size: 40px;
}

.abt_content p {
    font-size: 17px;
    color: #666666;
    max-width: 473px;
    font-family: 'OpenSans-Regular';
    line-height: 22px;
}

.abt_image {
    position: relative;
    z-index: 4;
}

.abt_image img.about_img {
    width: 100%;
    max-width: var(--abtImgWidth);
    position: relative;
    z-index: 5;
}

.abt_image img.about_img1{
    position: relative;
    z-index: 8;
    width: 100%;
    max-width: 350px;
}

.abt_image img.pngwing_img {
    width: 100%;
    max-width: 300px;
    position: absolute;
    right: -277px;
    top: -50px;
    z-index: 1;
}

.abt_one .pngwing_img {
    left: -270px;    
    top: -14px !important;
    transform: scaleX(-1);
}



/* 
counter css
*/

.numbered-section::after {
    content: '';
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    background-color: #000;
    opacity: 0.5;
    z-index: 2;
}

#counter {
    display: flex;
    justify-content: space-between;
    position: relative;
    z-index: 3;
}

#counter ul {
    list-style: none;
}

#counter li {
    list-style: none;
    flex-basis: 25%;
}

#counter img {
    width: 100%;
    max-width: 60px;
}

.num_text {
    font-size: 30px;
    color: #fff;
    font-family: 'OpenSans-Bold';
    margin: 15px 0;
}

#counter h5 {
    font-size: 16px;
    color: #fff;
    font-family: 'OpenSans-Bold';
    margin: 15px 0;
}

.abt_icon {
    height: 78px;
}


.location-wrap{
    display: flex;
    align-items:center; 
    background: #fff;
    padding: 0px 10px;
    width: 100%;
    max-width: 150px;
    box-sizing: border-box;
    height: 50px;
    border-radius: 3px;
    box-shadow: 0px 0px 14px 0px rgb(0 0 0 / 7%);
    position: relative;
}
.location-wrap select {
    border: 0px;
    color: #0b3343;
    font-weight: bold;
    padding: 0px;
    -webkit-appearance: none;
    -moz-appearance: none;
    position: relative;
}
.location-wrap select::-ms-expand {
    display: none;
}

.location-wrap::after{
    content: "\f078";
    
    right: 15px;
    top: 50%;
    font-family: 'Font Awesome 5 Free';
    z-index: 3;
    width: 25px;
    height: 25px;
    color: #333;
    font-weight: 700;
}

.search-wrap{
    display: flex ;
    background: #fff;
    align-items: center;
    padding: 0px 10px;
    width: 100%;
    max-width: 600px;
    box-sizing: border-box;
    height: 50px;
    border-radius: 3px;
     box-shadow: 0px 0px 14px 0px rgb(0 0 0 / 7%);

}
.search-wrap input{
    background: transparent;
    border: 0;
    padding: 0px;
}
.search-wrap span{
    color: #0b3343;
}

.search-wrap-2{
    display: flex ;
    background: #fff;
    align-items: center;
    padding: 0px 10px;
    width: 100%; 
    box-sizing: border-box;
    height: 50px;
    border-radius: 3px;
}
.search-wrap-2 input{
    background: transparent;
    border: 0;
    padding: 0px;
}
.search-wrap-2 span{
    color: #0b3343;
}

.mobile-search{
display: none;
margin-top: 20px;
}

.mobile-location{
   display: none;
}
.mobile-location .location-wrap-2{
    display: flex;
    align-items:center; 
    background: #fff;
    padding: 0px 10px;
    box-sizing: border-box;
    height: 50px;
    border-radius: 3px;
     width: 100%;
    max-width: 100%;
    margin-top: 20px;
}
.mobile-location .location-wrap-2 select {
    border: 0px;
    color: #0b3343;
    font-weight: bold;
    padding: 0px;
}

   
.autocomplete {
  position: relative;
  display: inline-block;
}

.autocomplete input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}

.autocomplete input[type=text] {
  background-color: #fff;
  width: 100%;
  height: 100%;
}

.autocomplete input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
  cursor: pointer;
}

.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 101%;
  left: 0;
  right: 0;
  width: 100%;
  margin: 0 !important;
}

.autocomplete-items div {
  margin: 0 !important;
  width: 100%;
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}

/*when hovering an item:*/
.autocomplete-items div:hover {
  background-color: #e9e9e9; 
}

/*when navigating through the items using the arrow keys:*/
.autocomplete-active {
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}



.xzoom {
    box-shadow: none !important;
}

.xzoom-preview {
    width: 400px !important;
    height: 400px!important;
    background-color: #fff; 
	margin-left: 55px !important;
	background: #fff !important;
}

.xzoom-preview img {
    width: 800px !important;
    height: 800px !important;
}
.mobile-login-user_without_login{
      display: flex !important;
    background: var(--primary-color);
    align-items: center;
    /*padding: 0px 10px;*/
    width: 100%;
    max-width: 45px;
    color: #fff;
    box-sizing: border-box;
    height: 50px;
    border-radius: 3px;
    font-size: 19px;
    justify-content: center;
    position: relative;
    cursor: pointer;
    box-shadow: 0px 0px 14px 0px rgb(0 0 0 / 22%);
    transition: 0.5s linear;
}
.mobile-login-user_without_login a{
    color: #fff;
    width: 45px;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}
/*  .mobile-login-user_without_login a:hover{
  color: #1ebcb7;
  }*/
  .mobileModal .modal-dialog {
    position: fixed !important;
    width: 100% !important;
    left: 50% !important;
    top: 50% !important;
    transform: translate(-50%, -50%) !important;
}
.mobileModal .modal-content {
    padding: 40px;
    border: none;
    border-radius: 0;
}
.mobile-title{
    color:var(--primary-color);
    font-size:18px;
    text-transform:capitalize;
}

.self_pickup {
    display: block;
    position: relative;
    font-size: 14px;
    color: #666;
    padding: 5px 20px 5px 15px;
    padding-right: 20px;
    background-color: #e1eaf4;
    margin-right: 8px;
    color: var(--secondary-color);
    font-family: "OpenSans-Bold";
}
.selfpickup-wrap{
            display:flex;
        }

        .product-detail-wrapper .detail{
  position: absolute;
  width: 100%;
  height: 100%;
  top:0px;
  left:0px;
  z-index:-5;
}
.z-9{
            z-index: 9999 !important;
        }
        .z-0{
            z-index: -9999 !important;
        }
.product-detail-wrapper{
	position:relative
}
/*.xzoom-lens {
	
}
*/
#resend {
    border: none;
    background-color: transparent;
    color: var(--primary-color);
    box-shadow: none;
    padding: 0;
    height: auto;
    width: auto;
}

/*=======  13/06/202   ===============*/


#country_code{
    font-weight: 700;
    font-size: 18px;
    color: #666666;
    appearance: none;
    position: relative;
    width: 100%;
}

.owl-carousel.client-owl-slider {
    padding: 0 0 0 calc((100vw - 1125px)/2);
}

#RegisterForm input , #RegisterForm textarea{
    padding: 0px;
}


#ChangePass #country_code {
    font-weight: normal;
}

.order-summary-box ul li.saving .btn.btn-orange{
    height:45px;
    display: flex;
}
.category-menu-wrapper .btn-primary span{
        display: inherit;
        margin-left: 9px;
}

.cart-item-table-wrapper{
    height: 100%;
}


/* ======= NOTIFICATION ======== */


.notif{
     padding:10px;
     position: relative;
   }
   .notif ul.dropdown {
  display: none;
  position: absolute;
  top: 110%;
  right:0px;
width: 374px;
  padding: 0;
  border-radius: 5px;
  box-shadow: 0 1px 1px rgba(50,50,50,0.1); 
  background:#fff;
  z-index: 22;
  height: 300px;
  overflow:auto;
   
}
.notif ul.dropdown.ishave{
    height:45px;
}
.notif .fa-bell {
  color:var(--primary-color);
  font-size:18px;
}
.notif .dropdown-toggle::after {
  display:none;
}

.notif ul.dropdown::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #fff;
}

.notif ul.dropdown::-webkit-scrollbar
{
    width: 6px;
    background-color: #fff;
}

.notif ul.dropdown::-webkit-scrollbar-thumb
{
    background-color: var(--primary-color);
    border-radius: 10px;
}


 
.notif ul.dropdown li {
  padding: 10px;
  list-style-type: none;
  border-top: 1px solid lightgrey;
  cursor: pointer;
}   
 
.notif ul.dropdown li:hover{
  background-color: #eee;
}
    
.notif ul.dropdown li:first-child {
  list-style-type: none;
  border-top: none;    
  
}
    
.notif ul.dropdown .fa-circle{
    font-size: 15px;
    color: rgba(115, 187, 22, 1);  
} 
    

/*View All Notification*/
.notif ul.dropdown .fa-list{
    font-size: 15px;
    padding:5px;
    color: rgba(115, 187, 22, 1); 
    border: 2px solid rgba(115, 187, 22, 1);
    border-radius: 100%;
}
    
/*.notif ul.dropdown li:last-child{
    text-align: center;
    padding: 10px;
    background:#fff;
    position: sticky;
    top:100%;
    color:#63CDF5;
    font-weight:bold;
}  */

.notif ul.dropdown li:last-child{
    text-align: center;
    padding: 10px;
    background: #fff;
    position: sticky;
    /* top: 100%; */
    color: var(--primary-color);
    font-weight: bold;
    /* left: 0; */
    /* right: 0; */
    bottom: 0;
    width: 100%;
}

#promo_err{
    margin: 10px 0px;
    color: var(--primary-color);
}




/* ============ACCOUNT IMAGE============= */

.group-image{
    display:inline-block;
    position: relative;
    margin-bottom:30px;
}
.group-image .profile-pic {
    width: 100%;
    height: 100%;
    object-fit: cover;

}

 .group-image .file-upload {
    visibility:hidden;
    width: 0px;
} 
.group-image .circle {
    border-radius: 100% !important;
    overflow: hidden;
    width: 128px;
    height: 128px;
    border: 2px solid rgba(255, 255, 255, 0.2);
    position: static;
    top: 72px;
}
/* .group-image img {
    max-width: 100%;
    height: auto;

} */
.group-image .p-image {
  position: absolute;
  top: 0px;
 right: 0px;
  color: #666666;
  transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
  cursor: pointer;
}
.group-image .p-image:hover {
  transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
}
.group-image .upload-button {
  font-size: 1.2em;
  color: var(--primary-color);
}
.group-image .upload-button:hover {
  transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
  color: #999;
}


.checkout-scroll {
    height: 400px;
    overflow: auto;
}


.cart-total-wrap .cart-total-innerbox.your-order-wrapper.order-summary-box{
    height: 100%;
} 

/**/


        /* ======= NOTIFICATION ======== */

        .top-nav{
            display:flex;
        }
.notif{
     padding:10px;
     position: relative;
     cursor: pointer;
   }
   .notif ul.dropdown {
  display: none;
  position: absolute;
  top: 110%;
  right:0px;
  min-width: 374px;
  padding: 0;
  border-radius: 5px;
  box-shadow: 0px 14px 16px -11px rgba(0,0,0,0.75);
  background:#fff;
  z-index: 22;
  height: 300px;
  overflow:auto !important;
   
}
.notif .fa-bell {
  color:#63CDF5;
  font-size:18px;
}
.notif .dropdown-toggle::after {
  display:none;
}

.notif ul.dropdown::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #fff;
}

.notif ul.dropdown::-webkit-scrollbar
{
    width: 6px;
    background-color: #fff !important;
}

.notif ul.dropdown::-webkit-scrollbar-thumb
{
    background-color: #63CDF5;
    border-radius: 10px;
}

.notif .dropdown.notify-drop.ishave{
    height:45px !important;
}
 
.notif ul.dropdown li {
  padding: 10px;
  list-style-type: none;
  border-top: 1px solid lightgrey;
  cursor: pointer;
}   
 
.notif ul.dropdown li:hover{
  background-color: #eee;
}
    
.notif ul.dropdown li:first-child {
  list-style-type: none;
  border-top: none;    
  
}
    
.notif ul.dropdown .fa-circle{
    font-size: 15px;
    color: rgba(115, 187, 22, 1);
} 
    

/*View All Notification*/
.notif ul.dropdown .fa-list{
    font-size: 15px;
    padding:5px;
    color: rgba(115, 187, 22, 1); 
    border: 2px solid rgba(115, 187, 22, 1);
    border-radius: 100%;
}
    
.notif ul.dropdown li:last-child{
    text-align: center;
    padding: 10px;
    background:#fff;
    position: sticky;
    bottom:0;
    color:#63CDF5;
    font-weight:bold;
}   


@media only screen and (max-width:768px)  {
    .notif ul.dropdown{
        min-width: 320px;
        right: -100px;
    }
}
/*.btn__badge {
    background: #FF5D5D;
    color: white;
    font-size: 12px;
    position: absolute;
    top: 8px;
    right: 4px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
}
*/
.btn__badge {
    background: var(--secondary-color);
    color: white;
    font-size: 12px;
    position: absolute;
    top: 8px;
    right: 4px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
}


</style>
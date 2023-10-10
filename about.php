<?php
$host = 'db'; // Replace with your MySQL server hostname or IP address
$dbname = 'shop_db'; // Replace with your database name
$username = 'Shaivi'; // Replace with your MySQL username
$password = 'root'; // Replace with your MySQL password
session_start();
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Your database operations here...
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    // Handle the error gracefully.
}

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <style>

.home-bg{
   background: url(../images/home-bg.jpg) no-repeat;
   background-size: cover;
   background-position: center;
}

.home-bg .home{
   display: flex;
   align-items: center;
   min-height: 60vh;
}

.home-bg .home .content{
   width: 50rem;
}

.home-bg .home .content span{
   color:var(--orange);
   font-size: 2.5rem;
}

.home-bg .home .content h3{
   font-size: 3rem;
   text-transform: uppercase;
   margin-top: 1.5rem;
   color:var(--black);
}

.home-bg .home .content p{
   font-size: 1.6rem;
   padding:1rem 0;
   line-height: 2;
   color:var(--light-color);
}

.home-bg .home .content a{
   display: inline-block;
   width: auto;
}

.home-category .box-container{
   display: grid;
   grid-template-columns: repeat(auto-fit, 27rem);
   gap:1.5rem;
   justify-content: center;
   align-items: flex-start;
}

.home-category .box-container .box{
   padding:2rem;
   text-align: center;
   border:var(--border);
   background-color: var(--white);
   box-shadow: var(--box-shadow);
   border-radius: .5rem;
}

.home-category .box-container .box img{
   width: 100%;
   margin-bottom: 1rem;
}

.home-category .box-container .box h3{
   text-transform: uppercase;
   color:var(--black);
   padding:1rem 0;
   font-size: 2rem;
}

.home-category .box-container .box p{
   line-height: 2;
   font-size: 1.5rem;
   color:var(--light-color);
   padding:.5rem 0;
}

.home-category{
   padding-bottom: 0;
}

.products .box-container{
   display: grid;
   grid-template-columns: repeat(auto-fit, 35rem);
   gap:1.5rem;
   justify-content: center;
   align-items: flex-start;
}

.products .box-container .box{
   padding:2rem;
   text-align: center;
   border:var(--border);
   background-color: var(--white);
   box-shadow: var(--box-shadow);
   border-radius: .5rem;
   position: relative;
}

.products .box-container .box .price{
   position: absolute;
   top:1rem; left:1rem;
   padding:1rem;
   border-radius: .5rem;
   background-color: var(--red);
   font-size: 1.8rem;
   color:var(--white);
}

.products .box-container .box .price span{
   font-size: 2.5rem;
   color:var(--white);
   margin:0 .2rem;
}

.products .box-container .box .fa-eye{
   position: absolute;
   top:1rem; right:1rem;
   border-radius: .5rem;
   height: 4.5rem;
   line-height: 4.3rem;
   width: 5rem;
   border:var(--border);
   color:var(--black);
   font-size: 2rem;
   background-color: var(--white);
}

.products .box-container .box .fa-eye:hover{
   color:var(--white);
   background-color: var(--black);
}

.products .box-container .box img{
   width: 100%;
   margin-bottom: 1rem;
}

.products .box-container .box .name{
   font-size: 2rem;
   color:var(--black);
   padding:1rem 0;
}

.products .box-container .box .qty{
   margin:.5rem 0;
   border-radius: .5rem;
   padding:1.2rem 1.4rem;
   font-size: 1.8rem;
   color:var(--black);
   border:var(--border);
   width: 100%;
}

.quick-view .box{
   max-width: 50rem;
   padding:2rem;
   text-align: center;
   border:var(--border);
   background-color: var(--white);
   box-shadow: var(--box-shadow);
   border-radius: .5rem;
   position: relative;
   margin:0 auto;
}

.quick-view .box img{
   height: 25rem;
   margin-bottom: 1rem;
}

.quick-view .box .price{
   position: absolute;
   top:1rem; left:1rem;
   padding:1rem;
   border-radius: .5rem;
   background-color: var(--red);
   font-size: 1.8rem;
   color:var(--white);
}

.quick-view .box .price span{
   font-size: 2.5rem;
   color:var(--white);
   margin:0 .2rem;
}

.quick-view .box .qty{
   margin:.5rem 0;
   border-radius: .5rem;
   padding:1.2rem 1.4rem;
   font-size: 1.8rem;
   color:var(--black);
   border:var(--border);
   width: 100%;
}

.quick-view .box .name{
   font-size: 2rem;
   color:var(--black);
   padding:1rem 0;
}

.quick-view .box .details{
   padding:1rem 0;
   line-height: 2;
   font-size: 1.5rem;
   color:var(--light-color);
}

.p-category{
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(27rem, 1fr));
   gap:1.5rem;
   justify-content: center;
   align-items: flex-start;
}

.p-category{
   padding-bottom: 0;
}

.p-category a{
   padding:1.5rem;
   text-align: center;
   border:var(--border);
   background-color: var(--white);
   box-shadow: var(--box-shadow);
   border-radius: .5rem;
   font-size: 2rem;
   text-transform: capitalize;
   color:var(--black);
}

.p-category a:hover{
   background-color: var(--black);
   color: var(--white);
}

.about .row{
   display: flex;
   flex-wrap: wrap;
   gap:3rem;
   align-items: center;
}

.about .row .box{
   flex:1 1 40rem;
   text-align: center;
}

.about .row .box img{
   margin-bottom: 2rem;
   height: 40rem;
}

.about .row .box h3{
   padding:1rem 0;
   font-size: 2.5rem;
   text-transform: uppercase;
   color:var(--black);
}

.about .row .box p{
   line-height: 2;
   font-size: 1.5rem;
   color:var(--light-color);
   padding:1rem 0;
}

.about .row .box .btn{
   display: inline-block;
   width: auto;
}

.reviews .box-container{
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(30rem, 1fr));
   gap:1.5rem;
   justify-content: center;
   align-items: flex-start;
}

.reviews .box-container .box{
   padding:2rem;
   text-align: center;
   border:var(--border);
   background-color: var(--white);
   box-shadow: var(--box-shadow);
   border-radius: .5rem;
}

.reviews .box-container .box img{
   height: 10rem;
   width: 10rem;
   border-radius: 50%;
   margin-bottom: 1rem;
   object-fit: cover;
}

.reviews .box-container .box p{
   padding:1rem 0;
   font-size: 1.6rem;
   color:var(--light-color);
   line-height: 2;
}

.reviews .box-container .box .stars{
   display: inline-block;
   padding:1rem;
   background-color: var(--light-bg);
   border:var(--border);
   border-radius: .5rem;
   margin:.5rem 0;
}

.reviews .box-container .box .stars i{
   font-size: 1.7rem;
   color:var(--orange);
   margin:0 .3rem;
}

.reviews .box-container .box h3{
   margin-top: 1rem;
   color:var(--black);
   font-size: 2rem;
}

.contact form{
   margin:0 auto;
   max-width: 50rem;
   padding:2rem;
   text-align: center;
   border:var(--border);
   background-color: var(--white);
   box-shadow: var(--box-shadow);
   border-radius: .5rem;
   padding-top: 1rem;
}

.contact form .box{
   width: 100%;
   padding:1.2rem 1.4rem;
   border:var(--border);
   margin:1rem 0;
   background-color: var(--light-bg);
   font-size: 1.8rem;
   color:var(--black);
   border-radius: .5rem;
}

.contact form textarea{
   height: 15rem;
   resize: none;
}

.search-form form{
   display: flex;
   gap:1.5rem;
   align-items: center;
}

.search-form form .box{
   width: 100%;
   padding:1.4rem;
   border:var(--border);
   margin:1rem 0;
   background-color: var(--white);
   box-shadow: var(--box-shadow);
   font-size: 2rem;
   color:var(--black);
   border-radius: .5rem;
}

.search-form form .btn{
   display: inline-block;
   width: auto;
   margin-top: 0;
}

.wishlist .box-container{
   display: grid;
   grid-template-columns: repeat(auto-fit, 35rem);
   gap:1.5rem;
   justify-content: center;
   align-items: flex-start;
}

.wishlist .box-container .box{
   padding:2rem;
   text-align: center;
   border:var(--border);
   background-color: var(--white);
   box-shadow: var(--box-shadow);
   border-radius: .5rem;
   position: relative;
}

.wishlist .box-container .box .price{
   padding:1rem 0;
   color:var(--red);
   font-size: 2.5rem;
}

.wishlist .box-container .box .price span{
   font-size: 2.5rem;
   color:var(--white);
   margin:0 .2rem;
}

.wishlist .box-container .box .fa-eye{
   position: absolute;
   top:1rem; right:1rem;
   border-radius: .5rem;
   height: 4.5rem;
   line-height: 4.3rem;
   width: 5rem;
   border:var(--border);
   color:var(--black);
   font-size: 2rem;
   background-color: var(--white);
}

.wishlist .box-container .box .fa-eye:hover{
   color:var(--white);
   background-color: var(--black);
}

.wishlist .box-container .box .fa-times{
   position: absolute;
   top:1rem; left:1rem;
   border-radius: .5rem;
   height: 4.5rem;
   line-height: 4.3rem;
   width: 5rem;
   color:var(--white);
   font-size: 2rem;
   background-color: var(--red);
}

.wishlist .box-container .box .fa-times:hover{
   background-color: var(--black);
}

.wishlist .box-container .box img{
   width: 100%;
   margin-bottom: 1rem;
}

.wishlist .box-container .box .name{
   font-size: 2rem;
   color:var(--black);
   padding-top: 1rem;
}

.wishlist .box-container .box .qty{
   margin:.5rem 0;
   border-radius: .5rem;
   padding:1.2rem 1.4rem;
   font-size: 1.8rem;
   color:var(--black);
   border:var(--border);
   width: 100%;
}

.wishlist .wishlist-total{
   max-width: 50rem;
   margin: 0 auto;
   margin-top: 2rem;
   padding:2rem;
   text-align: center;
   border:var(--border);
   background-color: var(--white);
   box-shadow: var(--box-shadow);
   border-radius: .5rem;
}

.wishlist .wishlist-total p{
   margin-bottom: 2rem;
   font-size: 2.5rem;
   color:var(--light-color);
}

.wishlist .wishlist-total p span{
   color:var(--red);
}

.shopping-cart .box-container{
   display: grid;
   grid-template-columns: repeat(auto-fit, 35rem);
   gap:1.5rem;
   justify-content: center;
   align-items: flex-start;
}

.shopping-cart .box-container .box{
   padding:2rem;
   text-align: center;
   border:var(--border);
   background-color: var(--white);
   box-shadow: var(--box-shadow);
   border-radius: .5rem;
   position: relative;
}

.shopping-cart .box-container .box .price{
   padding:1rem 0;
   color:var(--red);
   font-size: 2.5rem;
}

.shopping-cart .box-container .box .price span{
   font-size: 2.5rem;
   color:var(--white);
   margin:0 .2rem;
}

.shopping-cart .box-container .box .fa-eye{
   position: absolute;
   top:1rem; right:1rem;
   border-radius: .5rem;
   height: 4.5rem;
   line-height: 4.3rem;
   width: 5rem;
   border:var(--border);
   color:var(--black);
   font-size: 2rem;
   background-color: var(--white);
}

.shopping-cart .box-container .box .fa-eye:hover{
   color:var(--white);
   background-color: var(--black);
}

.shopping-cart .box-container .box .fa-times{
   position: absolute;
   top:1rem; left:1rem;
   border-radius: .5rem;
   height: 4.5rem;
   line-height: 4.3rem;
   width: 5rem;
   color:var(--white);
   font-size: 2rem;
   background-color: var(--red);
}

.shopping-cart .box-container .box .fa-times:hover{
   background-color: var(--black);
}

.shopping-cart .box-container .box img{
   width: 100%;
   margin-bottom: 1rem;
}

.shopping-cart .box-container .box .name{
   font-size: 2rem;
   color:var(--black);
   padding-top: 1rem;
}

.shopping-cart .box-container .box .qty{
   margin-top: 1rem;
   border-radius: .5rem;
   padding:1.2rem 1.4rem;
   font-size: 1.8rem;
   color:var(--black);
   border:var(--border);
   width: 100%;
}

.shopping-cart .box-container .sub-total{
   margin-top: 2rem;
   font-size: 2rem;
   color:var(--light-color);
}

.shopping-cart .box-container .sub-total span{
   color:var(--red);
}

.shopping-cart .cart-total{
   max-width: 50rem;
   margin: 0 auto;
   margin-top: 2rem;
   padding:2rem;
   text-align: center;
   border:var(--border);
   background-color: var(--white);
   box-shadow: var(--box-shadow);
   border-radius: .5rem;
}

.shopping-cart .cart-total p{
   margin-bottom: 2rem;
   font-size: 2.5rem;
   color:var(--light-color);
}

.shopping-cart .cart-total p span{
   color:var(--red);
}

.display-orders{
   text-align: center;
   padding-bottom: 0;
}

.display-orders p{
   display: inline-block;
   padding:1rem 2rem;
   margin:1rem .5rem;
   font-size: 2rem;
   text-align: center;
   border:var(--border);
   background-color: var(--white);
   box-shadow: var(--box-shadow);
   border-radius: .5rem;
}

.display-orders p span{
   color:var(--red);
}

.display-orders .grand-total{
   margin-top: 2rem;
   font-size: 2.5rem;
   color:var(--light-color);
}

.display-orders .grand-total span{
   color:var(--red);
}

.checkout-orders form{
   padding:2rem;
   border:var(--border);
   background-color: var(--white);
   box-shadow: var(--box-shadow);
   border-radius: .5rem;
}

.checkout-orders form h3{
   border-radius: .5rem;
   background-color: var(--black);
   color:var(--white);
   padding:1.5rem 1rem;
   text-align: center;
   text-transform: uppercase;
   margin-bottom: 2rem;
   font-size: 2.5rem;
}

.checkout-orders form .flex{
   display: flex;
   flex-wrap: wrap;
   gap:1.5rem;
   justify-content: space-between;
}

.checkout-orders form .flex .inputBox{
   width: 49%;
}

.checkout-orders form .flex .inputBox .box{
   width: 100%;
   border:var(--border);
   border-radius: .5rem;
   font-size: 1.8rem;
   color:var(--black);
   padding:1.2rem 1.4rem;
   margin:1rem 0;
   background-color: var(--light-bg);
}

.checkout-orders form .flex .inputBox span{
   font-size: 1.8rem;
   color:var(--light-color);
}

.placed-orders .box-container{
   display: flex;
   flex-wrap: wrap;
   gap:1.5rem;
   align-items: flex-start;
}

.placed-orders .box-container .box{
   padding:1rem 2rem;
   flex:1 1 40rem;
   border:var(--border);
   background-color: var(--white);
   box-shadow: var(--box-shadow);
   border-radius: .5rem;
}

.placed-orders .box-container .box p{
   margin:.5rem 0;
   line-height: 1.8;
   font-size: 2rem;
   color:var(--light-color);
}

.placed-orders .box-container .box p span{
   color:var(--green);
}









@media (max-width:768px){

   .home-bg{
      background-position: left;
   }

   .home-bg .home{
      justify-content: center;
      text-align: center;
   }

   .checkout-orders form .flex .inputBox{
      width: 100%;
   }

}

@media (max-width:450px){

   .home-category .box-container{
      grid-template-columns: 1fr;
   }

   .products .box-container{
      grid-template-columns: 1fr;
   }

   .quick-view .box img{
      height: auto;
      width: 100%;
   }

   .about .row .box img{
      width: 100%;
      height: auto;
   }   

   .shopping-cart .box-container{
      grid-template-columns: 1fr;
   }

   .wishlist .box-container{
      grid-template-columns: 1fr;
   }

}

@import url('https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap');

:root{
   --green:#27ae60;
   --orange:#f39c12;
   --red:#e74c3c;
   --black:#333;
   --light-color:#666;
   --white:#fff;
   --light-bg:#f6f6f6;
   --border:.2rem solid var(--black);
   --box-shadow:0 .5rem 1rem rgba(0,0,0,.1);
}

*{
   font-family: 'Rubik', sans-serif;
   margin:0; padding:0;
   box-sizing: border-box;
   outline: none; border:none;
   text-decoration: none;
   color:var(--black);
}

*::selection{
   background-color: var(--green);
   color:var(--white);
}

*::-webkit-scrollbar{
   height: .5rem;
   width: 1rem;
}

*::-webkit-scrollbar-track{
   background-color: transparent;
}

*::-webkit-scrollbar-thumb{
   background-color: var(--green);
}

body{
   background-image: url("admin home.jpg");
   background-repeat:no-repeat;
   background-size: 1600px 800px;
   background-color: var(--light-bg);
   /* padding-bottom: 6.5rem; */
}

html{
   font-size: 62.5%;
   overflow-x: hidden;
   scroll-behavior: smooth;
   scroll-padding-top: 6.5rem;
}

section{
   padding:3rem 2rem;
   max-width: 1200px;
   margin:0 auto;
}

.disabled{
   user-select: none;
   pointer-events: none;
   opacity: .5;
}

.btn,
.delete-btn,
.option-btn{
   display: block;
   width: 100%;
   margin-top: 1rem;
   border-radius: .5rem;
   color:var(--white);
   font-size: 2rem;
   padding:1.3rem 3rem;
   text-transform: capitalize;
   cursor: pointer;
   text-align: center;
}

.btn{
   background-color: var(--green);
}

.delete-btn{
   background-color: var(--red);
}

.option-btn{
   background-color: var(--orange);
}

.btn:hover,
.delete-btn:hover,
.option-btn:hover{
   background-color: var(--black);
}

.flex-btn{
   display: flex;
   flex-wrap: wrap;
   gap:1rem;
}

.flex-btn > *{
   flex:1;
}

.title{
   text-align: center;
   margin-bottom: 2rem;
   text-transform: uppercase;
   color:var(--black);
   font-size: 3.5rem;
}

.message{
   position: sticky;
   top:0;
   max-width: 1200px;
   margin:0 auto;
   background-color: var(--light-bg);
   padding:2rem;
   display: flex;
   align-items: center;
   justify-content: space-between;
   gap:1.5rem;
   z-index: 10000;
}

.message span{
   font-size: 2rem;
   color:var(--black);
}

.message i{
   font-size: 2.5rem;
   cursor: pointer;
   color:var(--red);
}

.message i:hover{
   color:var(--black);
}

.empty{
   padding:1.5rem;
   background: var(--white);
   color:var(--red);
   border-radius: .5rem;
   border:var(--border);
   font-size: 2rem;
   text-align: center;
   box-shadow: var(--box-shadow);
   text-transform: capitalize;
}

@keyframes fadeIn {
   0%{
      transform: translateY(1rem);
   }
}

.form-container{
   min-height: 100vh;
   display: flex;
   align-items: center;
   justify-content: center;
}

.form-container form{
   width: 50rem;
   background-color: var(--white);
   border-radius: .5rem;
   box-shadow: var(--box-shadow);
   border:var(--border);
   text-align: center;
   padding:2rem;
}

.form-container form h3{
   font-size: 3rem;
   color:var(--black);
   margin-bottom: 1rem;
   text-transform: uppercase;
}

.form-container form .box{
   width: 100%;
   margin:1rem 0;
   border-radius: .5rem;
   border:var(--border);
   padding:1.2rem 1.4rem;
   font-size: 1.8rem;
   color:var(--black);
   background-color: var(--light-bg);
}

.form-container form p{
   margin-top: 2rem;
   font-size: 2.2rem;
   color:var(--light-color);
}

.form-container form p a{
   color:var(--green);
}

.form-container form p a:hover{
   text-decoration: underline;
}

.header{
   background: var(--white);
   position: sticky;
   top:0; left:0; right:0;
   z-index: 1000;
   box-shadow: var(--box-shadow);
}

.header .flex{
   display: flex;
   align-items: center;
   justify-content: space-between;
   padding:2rem;
   margin: 0 auto;
   max-width: 1200px;
   position: relative;
}

.header .flex .logo{
   font-size: 2.5rem;
   color:var(--black);
}

.header .flex .logo span{
   color:var(--green);
}

.header .flex .navbar a{
   margin:0 1rem;
   font-size: 2rem;
   color:var(--light-color);
}

.header .flex .navbar a:hover{
   text-decoration: underline;
   color:var(--green);
}

.header .flex .icons > *{
   font-size: 2.5rem;
   color:var(--light-color);
   cursor: pointer;
   margin-left: 1.5rem;
}

.header .flex .icons > *:hover{
   color:var(--green);
}

.header .flex .icons a span,
.header .flex .icons a i{
   color:var(--light-color);
}

.header .flex .icons a:hover span,
.header .flex .icons a:hover i{
   color:var(--green);
}

.header .flex .icons a span{
   font-size: 2rem;
}

#menu-btn{
   display: none;
}

.header .flex .profile{
   position: absolute;
   top:120%; right:2rem;
   box-shadow: var(--box-shadow);
   border:var(--border);
   border-radius: .5rem;
   padding:2rem;
   text-align: center;
   background-color: var(--white);
   width: 33rem;
   display: none;
   animation: fadeIn .2s linear;
}

.header .flex .profile.active{
   display: inline-block;
}

.header .flex .profile img{
   height: 15rem;
   width: 15rem;
   margin-bottom: 1rem;
   border-radius: 50%;
   object-fit: cover;
}

.header .flex .profile p{
   padding:.5rem 0;
   font-size: 2rem;
   color:var(--light-color);
}

.update-profile form{
   max-width: 70rem;
   margin: 0 auto;
   background-color: var(--white);
   box-shadow: var(--box-shadow);
   border:var(--border);
   border-radius: .5rem;
   padding:2rem;
   text-align: center;
}

.update-profile form .flex{
   display: flex;
   gap:1.5rem;
   justify-content: space-between;
}

.update-profile form img{
   height: 20rem;
   width: 20rem;
   margin-bottom: 1rem;
   border-radius: 50%;
   object-fit: cover;
}

.update-profile form .inputBox{
   text-align: left;
   width: 49%;
}

.update-profile form .inputBox span{
   display: block;
   padding-top: 1rem;
   font-size: 1.8rem;
   color:var(--light-color);
}

.update-profile form .inputBox .box{
   width: 100%;
   padding:1.2rem 1.4rem;
   font-size: 1.8rem;
   color:var(--black);
   border:var(--border);
   border-radius: .5rem;
   margin:1rem 0;
   background-color: var(--light-bg);
}













.footer{
   background-color: var(--white);
}

.footer .box-container{
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(27rem, 1fr));
   gap:2.5rem;
   align-items: flex-start;
}

.footer .box-container .box h3{
   text-transform: uppercase;
   color:var(--black);
   margin-bottom: 2rem;
   font-size: 2rem;
}

.footer .box-container .box a,
.footer .box-container .box p{
   display: block;
   padding:1.3rem 0;
   font-size: 1.6rem;
   color:var(--light-color);
}

.footer .box-container .box a i,
.footer .box-container .box p i{
   color:var(--green);
   padding-right: 1rem;
}

.footer .box-container .box a:hover{
   text-decoration: underline;
   color:var(--green);
}

.footer .credit{
   margin-top: 2rem;
   padding: 2rem 1.5rem;
   padding-bottom: 2.5rem;
   line-height: 1.5;
   border-top: var(--border);
   text-align: center;
   font-size: 2rem;
   color:var(--black);
}

.footer .credit span{
   color:var(--green);
}



/* media queries  */

@media (max-width:991px){

   html{
      font-size: 55%;
   }
   
}

@media (max-width:768px){

   #menu-btn{
      display: inline-block;
   }

   .header .flex .navbar{
      border-top: var(--border);
      border-bottom: var(--border);
      background-color: var(--white);
      position: absolute;
      top:99%; left:0; right:0;
      transition: .2s linear;
      clip-path: polygon(0 0, 100% 0, 100% 0, 0 0);
   }

   .header .flex .navbar.active{
      clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
   }

   .header .flex .navbar a{
      display: block;
      margin:2rem;   
   }

   .update-profile form .flex{
      flex-wrap: wrap;
      gap:0;
   }

   .update-profile form .flex .inputBox{
      width: 100%;
   }

}

@media (max-width:450px){

   html{
      font-size: 50%;
   }

   .flex-btn{
      flex-flow: column;
      gap:0;
   }

   .title{
      font-size: 3rem;
   }
   
}

</style>

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="about">

   <div class="row">

      <div class="box">
         <img src="images/about-img-1.png" alt="">
         <h3>Why Choose Us?</h3>
         <p>
We at Peto are committed to provide premium quality products and quality life for your pets. With the best ever new generation of pure, human grade, organic, high-quality diet.
Peto started as a need of the hour to bring about a change in the view of not just towards our pets, their diet & nutrition but also towards the way we treat them on a deeper level. 
We started Peto when we realized that we were presented with limited options and void in the market in terms of organic high quality feed,pet care and holistic well being.
From only being a pet-parent to running a passionate startup.. We have rediscovered the finest collective of services and products to pamper those forever-friends of ours. As we met more pet parents, we have seen bringing to light a like-minded, co-operative venture. A drive to create a responsible environment for animal-welfare and to find the right balance of intense crazy pet-lovers to responsible pet-parent.

Continuing into the future, we aim at providing Undivided attention towards -having a good, healthy, life -long companionship with our pets and taking that extra step to understand their daily nutritional needs and holistic well being.
Visualizing a solution to best suit each pet and pet owner, match every lifestyle is a strength of Peto. </p>
        
      </div>

     
   </div>

</section>

<section class="reviews">

   <h1 class="title">clients reivews</h1>

   <div class="box-container">

      <div class="box">
         <img src="profile icon.png" alt="">
         <p>Peto is a wonderful pet item shop, it is my go-to destination for all pet my pet needs. 
            The shop offers an impressive range of pet accessories including clothing, food, toys, grooming products, and much more.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Neha Singh</h3>
      </div>

      <div class="box">
         <img src="profile icon.png" alt="">
         <p>The store has an amazing selection of pet clothing, with options available for dogs of all sizes and breeds. 
            I was impressed by the variety of options available, and the quality of the material used in the clothing.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Hannah Smith</h3>
      </div>

      <div class="box">
         <img src="profile icon.png" alt="">
         <p>This is my fav go to place for my dog treats and necessities.
There products are great ! My dogs love the biscuits - yummy tummy</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Tina Khanna</h3>
      </div>

      
   </div>

</section>









<?php include 'footer.php'; ?>

<script>
   newFunction();

function newFunction() {
   let navbar = document.querySelector('.header .flex .navbar');

   document.querySelector('#menu-btn').onclick = () => {
      navbar.classList.toggle('active');
      profile.classList.remove('active');
   };

   let profile = document.querySelector('.header .flex .profile');

   document.querySelector('#user-btn').onclick = () => {
      profile.classList.toggle('active');
      navbar.classList.remove('active');
   };

   window.onscroll = () => {
      profile.classList.remove('active');
      navbar.classList.remove('active');
   };
}
</script>

</body>
</html>
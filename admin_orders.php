<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['update_order'])){

   $order_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   $update_payment = filter_var($update_payment, FILTER_SANITIZE_STRING);
   $update_orders = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_orders->execute([$update_payment, $order_id]);
   $message[] = 'payment has been updated!';

};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_orders->execute([$delete_id]);
   header('location:admin_orders.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
<style>

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
   background-color: lightblue;
 
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
   justify-content: left;
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
   height: 55px;
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
   background-color:var(--white);
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


.dashboard .box-container{
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(27rem, 1fr));
   gap:2rem;
   align-items: flex-start;
   box-shadow: ;
}

.dashboard .box-container .box{
   padding:2rem;
   text-align: center;
   border:var(--border);
   box-shadow: var(--box-shadow);
   background-color: var(--white);
   border-radius: 3rem;
}

.dashboard .box-container .box h3{
   font-size: 3.5rem;
   color:var(--black);
}

.dashboard .box-container .box p{
   font-size: 2rem;
   background-color: var(--light-bg);
   color:var(--light-color);
   padding:1.5rem;
   margin:0.5rem 0;
   border:var(--border);
   border-radius: .5rem;
   color:var(--black);
}

.add-products form{
   max-width: 70rem;
   padding:2rem;
   margin:0 auto;
   text-align: center;
   border:var(--border);
   box-shadow: var(--box-shadow);
   background-color: var(--white);
   border-radius: .5rem;
}

.add-products form .flex{
   display: flex;
   justify-content: space-between;
   flex-wrap: wrap;
}

.add-products form .flex .inputBox{
   width: 49%;
}

.add-products form .box{
   width: 100%;
   margin:1rem 0;
   padding:1.2rem 1.4rem;
   font-size: 1.8rem;
   color:var(--black);
   border-radius: .5rem;
   background-color: var(--light-bg);
   border:var(--border);
}

.add-products form textarea{
   height: 20rem;
   resize: none;
}

.show-products{
   padding-top: 0;
}

.show-products .box-container{
   display: grid;
   grid-template-columns: repeat(auto-fit, 33rem);
   gap:1.5rem;
   align-items: flex-start;
   justify-content:center;
}

.show-products .box-container .box{
   text-align: center;
   border:var(--border);
   box-shadow: var(--box-shadow);
   background-color: var(--white);
   border-radius: .5rem;
   padding:2rem;
   position: relative;
}

.show-products .box-container .box .price{
   position: absolute;
   top:1rem; left:1rem;
   padding:1rem;
   font-size: 2rem;
   color:var(--white);
   background-color: var(--red);
   border-radius: .5rem;
}

.show-products .box-container .box img{
   width: 100%;
   margin-bottom: 1rem;
}

.show-products .box-container .box .name{
   margin:.5rem 0;
   font-size: 2rem;
   color:var(--black);
}

.show-products .box-container .box .cat{
   font-size: 1.8rem;
   color:var(--green);
}

.show-products .box-container .box .details{
   padding-top: 1rem;
   font-size: 1.5rem;
   line-height: 1.5;
   color:var(--light-color);
}

.update-product form{
   max-width: 50rem;
   padding:2rem;
   margin:0 auto;
   text-align: center;
   border:var(--border);
   box-shadow: var(--box-shadow);
   background-color: var(--white);
   border-radius: .5rem;
}

.update-product form img{
   height: 25rem;
   object-fit: cover;
   margin-bottom: 1rem;
}

.update-product form .box{
   width: 100%;
   border:var(--border);
   background-color: var(--white);
   border-radius: .5rem;
   background-color: var(--light-bg);
   padding:1.2rem 1.4rem;
   font-size: 1.8rem;
   color:var(--black);
   margin:1rem 0;
}

.placed-orders .box-container{
   display: grid;
   grid-template-columns: repeat(auto-fit, 33rem);
   gap:1.5rem;
   align-items: flex-start;
   justify-content:center;
}

.placed-orders .box-container .box{
   border:var(--border);
   box-shadow: var(--box-shadow);
   background-color: var(--white);
   border-radius: .5rem;
   padding:2rem;
}

.placed-orders .box-container .box p{
   margin-bottom: 1rem;
   line-height: 1.5;
   font-size: 2rem;
   color:var(--light-color);
}

.placed-orders .box-container .box p span{
   color:var(--green);
}

.placed-orders .box-container .box .drop-down{
   width: 100%;
   padding:1.2rem 1.4rem;
   font-size: 1.8rem;
   border:var(--border);
   border-radius: .5rem;
   background-color: var(--light-bg);
   margin-bottom: .5rem;
}

.user-accounts .box-container{
   display: grid;
   grid-template-columns: repeat(auto-fit, 33rem);
   gap:1.5rem;
   align-items: flex-start;
   justify-content:center;
}

.user-accounts .box-container .box{
   border:var(--border);
   box-shadow: var(--box-shadow);
   background-color: var(--white);
   border-radius: .5rem;
   padding:2rem;
   text-align: center;
}

.user-accounts .box-container .box img{
   height: 15rem;
   width: 15rem;
   border-radius: 50%;
   object-fit: cover;
   margin-bottom: 1rem;
}

.user-accounts .box-container .box p{
   line-height: 1.5;
   padding:.5rem 0;
   font-size: 2rem;
   color:var(--light-color);
}

.user-accounts .box-container .box p span{
   color:var(--green);
}

.messages .box-container{
   display: grid;
   grid-template-columns: repeat(auto-fit, 33rem);
   gap:1.5rem;
   align-items: flex-start;
   justify-content:center;
}

.messages .box-container .box{
   border:var(--border);
   box-shadow: var(--box-shadow);
   background-color: var(--white);
   border-radius: .5rem;
   padding:2rem;
}

.messages .box-container .box p{
   line-height: 1.5;
   padding:.5rem 0;
   font-size: 2rem;
   color:var(--light-color);
}

.messages .box-container .box p span{
   color:var(--green);
}












@media (max-width:768px){

   .add-products form .flex .inputBox{
      width: 100%;
   }

}



@media (max-width:450px){

   .show-products .box-container{
      grid-template-columns: 1fr;
   }

   .update-product form img{
      height: auto;
      width: 100%;
   }

   .placed-orders .box-container{
      grid-template-columns: 1fr;
   }

   .user-accounts .box-container{
      grid-template-columns: 1fr;
   }

   .messages .box-container{
      grid-template-columns: 1fr;
   }

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
   
<?php include 'admin_header.php'; ?>

<section class="placed-orders">

   <h1 class="title">placed orders</h1>

   <div class="box-container">

      <?php
         $select_orders = $conn->prepare("SELECT * FROM `orders`");
         $select_orders->execute();
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box">
         <p> user id : <span><?= $fetch_orders['user_id']; ?></span> </p>
         <p> placed on : <span><?= $fetch_orders['placed_on']; ?></span> </p>
         <p> name : <span><?= $fetch_orders['name']; ?></span> </p>
         <p> email : <span><?= $fetch_orders['email']; ?></span> </p>
         <p> number : <span><?= $fetch_orders['number']; ?></span> </p>
         <p> address : <span><?= $fetch_orders['address']; ?></span> </p>
         <p> total products : <span><?= $fetch_orders['total_products']; ?></span> </p>
         <p> total price : <span>Rs.<?= $fetch_orders['total_price']; ?>/-</span> </p>
         <p> payment method : <span><?= $fetch_orders['method']; ?></span> </p>
         <form action="" method="POST">
            <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
            <select name="update_payment" class="drop-down">
               <option value="" selected disabled><?= $fetch_orders['payment_status']; ?></option>
               <option value="pending">pending</option>
               <option value="completed">completed</option>
            </select>
            <div class="flex-btn">
               <input type="submit" name="update_order" class="option-btn" value="udate">
               <a href="admin_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">delete</a>
            </div>
         </form>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty"><marquee>no orders placed yet!<marquee></p>';
      }
      ?>

   </div>

</section>

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
<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['update_profile'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);

   $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
   $update_profile->execute([$name, $email, $user_id]);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;
   $old_image = $_POST['old_image'];

   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $update_image = $conn->prepare("UPDATE `users` SET image = ? WHERE id = ?");
         $update_image->execute([$image, $user_id]);
         if($update_image){
            move_uploaded_file($image_tmp_name, $image_folder);
            unlink('uploaded_img/'.$old_image);
            $message[] = 'image updated successfully!';
         };
      };
   };

   $old_pass = $_POST['old_pass'];
   $update_pass = md5($_POST['update_pass']);
   $update_pass = filter_var($update_pass, FILTER_SANITIZE_STRING);
   $new_pass = md5($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_pass = md5($_POST['confirm_pass']);
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

   if(!empty($update_pass) AND !empty($new_pass) AND !empty($confirm_pass)){
      if($update_pass != $old_pass){
         $message[] = 'old password not matched!';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'confirm password not matched!';
      }else{
         $update_pass_query = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
         $update_pass_query->execute([$confirm_pass, $user_id]);
         $message[] = 'password updated successfully!';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update user profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="components.css">
 <style>  
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
   justify-content: right;
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

<section class="update-profile">

   <h1 class="title">update profile</h1>

   <form action="" method="POST" enctype="multipart/form-data">
      <img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
      <div class="flex">
         <div class="inputBox">
            <span>username :</span>
            <input type="text" name="name" value="<?= $fetch_profile['name']; ?>" placeholder="update username" required class="box">
            <span>email :</span>
            <input type="email" name="email" value="<?= $fetch_profile['email']; ?>" placeholder="update email" required class="box">
            <span>update pic :</span>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box">
            <input type="hidden" name="old_image" value="<?= $fetch_profile['image']; ?>">
         </div>
         <div class="inputBox">
            <input type="hidden" name="old_pass" value="<?= $fetch_profile['password']; ?>">
            <span>old password :</span>
            <input type="password" name="update_pass" placeholder="enter previous password" class="box">
            <span>new password :</span>
            <input type="password" name="new_pass" placeholder="enter new password" class="box">
            <span>confirm password :</span>
            <input type="password" name="confirm_pass" placeholder="confirm new password" class="box">
         </div>
      </div>
      <div class="flex-btn">
         <input type="submit" class="btn" value="update profile" name="update_profile">
         <a href="home.php" class="option-btn">go back</a>
      </div>
   </form>

</section>










<?php include 'footer.php'; ?>


<script src="script.js"></script>

</body>
</html>
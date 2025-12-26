<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel</title>
   <?php require('inc/links.php') ?>
</head>
<body>
<?php require('inc/header.php');?>

<div class="my-5 px-4">
   <h2 class="fw-bold font2 text-center">Contact us </h2>
   <div class="hline bg-dark"></div>
   <p class="text-center mt-3">"Your Comfort Awaits: Reach Out Anytime!"</p>
</div>
<div class="container">
  <div class="row">
        <div class="col-lg-6 col-md-6 p-4 mb-lg-0 mb-3 bg-white shadow">
            <!-- Map -->
            <iframe class="w-100" height="320" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d448196.5263595192!2d76.76357175795702!3d28.64368462003187!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfd5b347eb62d%3A0x37205b715389640!2sDelhi!5e0!3m2!1sen!2sin!4v1726917348635!5m2!1sen!2sin" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <div class="p-4 pb-0 text-info">
                <h5>Address: </h5>
                <p class="text-dark">Delhi</p>
            </div>
            
            <!-- Phone Details  -->
            <div class="p-4 pt-0 text-info">
                <h5>Call Us: </h5>
                <a href="tel: +919999999999" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-telephone-fill"></i> +91-9999999999</a>
                <br>
                <a href="tel: +918888888888" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-telephone-fill"></i> +91-8888888888</a>
            </div>
            <!-- Email  -->
            <div class="p-4 pt-0 text-info">
                <h5>Email: </h5>
                <a href="mailto: ask.abc@abc.com" class="text-dark"><i class="bi bi-envelope-fill"></i> abc@abc.com</a>
            </div>

            <!-- Social Medias -->
            <div class=" p-4 pt-0 text-info">
                <h5 class="text-info">Follow Us: </h5>
                <a href="#" class="d-inline-block mb-2 text-decoration-none text-dark"><span class="badge bg-white text-dark fs-6 p-2"> <i class="bi bi-twitter-x me-1"></i></span></a>
                <a href="#" class="d-inline-block mb-2 text-decoration-none text-dark"><span class="badge bg-white text-dark fs-6 p-2"> <i class="bi bi-facebook me-1"></i></span></a>
                <a href="#" class="d-inline-block mb-2 text-decoration-none text-dark"><span class="badge bg-white text-dark fs-6 p-2"> <i class="bi bi-instagram me-1"></i></span></a>
            </div>
        </div>
        
        <!-- Contact us form  -->
        <div class="col-lg-6 col-md-6">
            <div class="bg-white shadow p-4 mb-3 text-info">
                <form method="POST" id="contact_form" >
                    <div>
                        <div class="container text-info">
                            <div class="row fw-medium">
                                <div class="mb-3">
                                    <label class="form-lable">Name: </label>
                                    <input type="text" name="name" required class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-lable ps-0">Email : </label>
                                    <input type="email" name="email" required class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-lable ps-0">Subject : </label>
                                    <input type="text" name="subject" required class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-lable ps-0">Message : </label>
                                    <textarea class="form-control" name="message" required rows="5" ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex text-center mb-4 mx-auto">
                        <button type="submit" class="btn btn-info" name="send" data-mdb-ripple-init data-mdb-ripple-color="dark">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require("inc/footer.php")?>
<script>
    let contact_form=document.getElementById('contact_form');

    contact_form.addEventListener('submit',function(e){
        e.preventDefault();
        send()
    });

    //Check if room available
    function send(){
        let data=new FormData();
        data.append('name',contact_form.elements['name'].value);
        data.append('email',contact_form.elements['email'].value);
        data.append('sub',contact_form.elements['subject'].value);
        data.append('message',contact_form.elements['message'].value);
        data.append('send','');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/project/ajax/users.php", true);

        xhr.onload = function () {
            console.log(this.responseText);
            if (xhr.status === 200) {
                if(xhr.responseText=='1'){
                    alert("Query Sent")
                    location.reload()
                }
                else{
                    alert("error")
                }
                
            } else {
                alert("Error Please try again.");
                console.log("Error:", xhr.status, xhr.responseText);
            }
        };
        xhr.send(data);
        
    }

</script>
</body>
</html>
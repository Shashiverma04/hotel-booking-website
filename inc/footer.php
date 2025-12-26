<div class="container-fluid bg-white mt-5 shadow">
    <div class="row">
        <div class="col-lg-4 p-4">
            <h3 class="font2 text-info fw-bold fs-3">Tropical Hotels</h3>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Error voluptas veritatis tenetur dolorum expedita et facere, ut, sequi molestias, repellendus inventore? Modi atque animi facilis? Commodi id molestiae sed voluptate.</p>
        </div>
        <div class="col-lg-4 p-4 text-info">
            <h5 class="mb-3">Links :</h5>
            <a href="home.php" class="d-inline-block mb-2 text-dark text-decoration-none"><i class="bi bi-house-fill me-1"></i> Home</a><br>
            <a href="room.php" class="d-inline-block mb-2 text-dark text-decoration-none"><i class="bi bi-door-closed-fill me-1"></i> Rooms</a><br>
            <a href="facilities.php" class="d-inline-block mb-2 text-dark text-decoration-none"><i class="bi bi-wifi me-1"></i> Facilities</a><br>
            <a href="contact.php" class="d-inline-block mb-2 text-dark text-decoration-none"><i class="bi bi-telephone-fill me-1"></i> Contact Us</a><br>
            <a href="about.php" class="d-inline-block mb-2 text-dark text-decoration-none"><i class="bi bi-file-person-fill me-1"></i> About</a><br>
            <a href="admin/index.php" class="d-inline-block mb-2 text-dark text-decoration-none"><i class="bi bi-person-vcard"></i> Admin</a><br>
        </div>
        <div class="col-lg-4 p-4 text-info">
            <h5 class="mb-3 mt-2">Follow Us: </h5>
            <a href="#" class="d-inline-block mb-2 text-decoration-none text-dark"><span class="badge bg-white text-dark fs-6 p-2"> <i class="bi bi-twitter-x me-1"></i> Twitter</span></a><br>
            <a href="#" class="d-inline-block mb-2 text-decoration-none text-dark"><span class="badge bg-white text-dark fs-6 p-2"> <i class="bi bi-facebook me-1"></i> Facebook</span></a><br>
            <a href="#" class="d-inline-block mb-2 text-decoration-none text-dark"><span class="badge bg-white text-dark fs-6 p-2"> <i class="bi bi-instagram me-1"></i> Instagram</span></a>
        </div>
    </div>
</div>
<script>
    let register_form = document.getElementById('register_form');
    let login_form=document.getElementById('login_form'); 

    register_form.addEventListener('submit', function (e) {
        e.preventDefault();
        add_info();
    });

    login_form.addEventListener('submit', function (e) {
        e.preventDefault();
        login_user();
    });

    // registering user
    function add_info() {
        let register_form = document.getElementById('register_form');
        let data = new FormData();
        data.append('add_info', '');
        data.append('name', register_form.elements['name'].value);
        data.append('email', register_form.elements['email'].value);
        data.append('phone', register_form.elements['phone'].value);
        data.append('address', register_form.elements['address'].value);
        data.append('pin', register_form.elements['pin'].value);
        data.append('DOB', register_form.elements['DOB'].value);
        data.append('password', register_form.elements['password'].value);
        data.append('c_password', register_form.elements['c_password'].value);

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/project/ajax/login_register.php", true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                if (xhr.responseText== 'password_mismatch') {
                    alert_send("alert-container-register","error","Password Mismatch")
                } else if (xhr.responseText == "User already Exists") {
                    alert_send("alert-container-register","error","User already exists")
                }else if(xhr.responseText == "deleted_by_admin"){
                    alert_send("alert-container-register","error","Deleted by admin, Please contact the admin")
                }else if (xhr.responseText == "success") {
                    var myModal = document.getElementById('registermodal');
                    if (myModal) {
                        var modal = bootstrap.Modal.getInstance(myModal);
                        modal.hide();
                    }
                    alert_send("alert-container-register","success","Registered Successfully")
                    register_form.reset();
                    location.reload();
                } else {
                    alert("Unexpected response from the server.");
                    console.log(xhr.responseText);
                }
            } else {
                alert("Error adding info. Please try again.");
                console.log("Error:", xhr.status, xhr.responseText);
            }
        };
        xhr.send(data);
    };

    // check login details 
    function login_user() {
        let login_form = document.getElementById('login_form');
        let data = new FormData();
        data.append('login_user', '');
        data.append('email', login_form.elements['email'].value);
        data.append('password', login_form.elements['password'].value);

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                if (xhr.responseText== 'User_doesnt_exist') {
                    alert_send("alert-container","error","User Doesnt Exist")
                }else if(xhr.responseText=='incorrect_password'){
                    alert_send("alert-container","error","Incorrect Password")
                }else if(xhr.responseText == 'deleted_by_admin'){
                    alert_send("alert-container","error","Deleted by admin, Please contact admin")
                }else {
                    window.location.href=window.location.pathname;
                }
            } else {
                alert_send("alert-container","error","Error in login, Please try again later")
                console.log("Error:", xhr.status, xhr.responseText);
            }
        };
        xhr.send(data);
    };

    //check room and login status
    function check_login(status,room_id){
        if(status){
            window.location.href='confirm_booking.php?&id='+room_id;
        }else{
            alert("Please Login to Book Room");
        }
    }

</script>
<script type="text/javascript" src="js/essentials.js"></script>
<!-- MDB -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>
 
<!-- bootstrap js  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- swiper js -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
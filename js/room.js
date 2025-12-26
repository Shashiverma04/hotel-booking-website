let room_form=document.getElementById('room_form');
let edit_form=document.getElementById('edit_form');
let imageform=document.getElementById('imageform');

room_form.addEventListener('submit',function(e){
    e.preventDefault();
    add_room();
});

edit_form.addEventListener('submit',function(e){
    e.preventDefault();
    submit_edit();
})

imageform.addEventListener('submit',function(e){
    e.preventDefault();
    add_image();
})

//to add new rooms
function add_room(){
    let data=new FormData();
    data.append('add_room','');
    data.append('name',room_form.elements['room_name'].value);
    data.append('area',room_form.elements['area'].value);
    data.append('price',room_form.elements['price'].value);
    data.append('quantity',room_form.elements['quantity'].value);
    data.append('adult',room_form.elements['adult'].value);
    data.append('child',room_form.elements['child'].value);
    data.append('description',room_form.elements['description'].value);
    
    //getting all features
    let features=[];
    room_form.elements['features'].forEach(el => {
        if(el.checked){
            features.push(el.value);
        }
    });

    // getting all facilities
    let facilities=[];
    room_form.elements['facilities'].forEach(el => {
        if(el.checked){
            facilities.push(el.value);
        }
        
    });
    
    data.append('features',JSON.stringify(features));
    data.append('facilities',JSON.stringify(facilities));

    let xhr=new XMLHttpRequest();
    xhr.open("POST","../ajax/room.php",true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            var myModal = document.getElementById('room');
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();
            
            alert("Room added successfully!");
            room_form.reset();
            location.reload();
        } else {
            alert("Error adding room. Please try again.");
            console.log(xhr.responseText);
        }
    };
    xhr.send(data);
}

// to remove room 
function rem_room(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../ajax/room.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            alert("Room deleted successfully!");
            location.reload();
        } else {
            alert("Error: " + xhr.responseText); 
        }
    };
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("rem_room=" + val);
}
    
// for inactive and active status of room 
function toggleStatus(id, val){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../ajax/room.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        if (xhr.status === 200) {
            alert("Status Toggled");
            location.reload();
        } else {
            alert("Error: " + xhr.responseText);
        }
    };
    xhr.send('toggleStatus=' + id + '&value=' + val);
}

// editing the room info 
function edit(val){
    let xhr=new XMLHttpRequest();
    xhr.open("POST","../ajax/room.php",true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 

    xhr.onload = function () {
        let data=JSON.parse(this.responseText);
        edit_form.elements['room_name'].value=data.room_data.name;
        edit_form.elements['area'].value=data.room_data.area;
        edit_form.elements['price'].value=data.room_data.price;
        edit_form.elements['quantity'].value=data.room_data.quantity;
        edit_form.elements['adult'].value=data.room_data.adult;
        edit_form.elements['child'].value=data.room_data.children;
        edit_form.elements['description'].value=data.room_data.description;
        edit_form.elements['room_id'].value=data.room_data.id;

        let facilitiesElements = edit_form.elements['facilities'];
        let featuresElements = edit_form.elements['features'];
        
        //checking the facilities checkboxes
        Array.from(facilitiesElements).forEach(el => {
            if (data.facilities.includes(el.value)) {
                el.checked=true;
            }
        });

        //checking the form checkboxes
        Array.from(featuresElements).forEach(el => {
            if (data.features.includes(el.value)) {
                el.checked=true;
            }
        });
    };
    xhr.send('get_detail='+val);
    console.log(val);
}

//submit edit
function submit_edit(){
    let data=new FormData();
    data.append('update_room','');
    data.append('room_id',edit_form.elements['room_id'].value);
    data.append('name',edit_form.elements['room_name'].value);
    data.append('area',edit_form.elements['area'].value);
    data.append('price',edit_form.elements['price'].value);
    data.append('quantity',edit_form.elements['quantity'].value);
    data.append('adult',edit_form.elements['adult'].value);
    data.append('child',edit_form.elements['child'].value);
    data.append('description',edit_form.elements['description'].value);
    
    // fetching features
    let features=[];
    edit_form.elements['features'].forEach(el => {
        if(el.checked){
            features.push(el.value);
        }
        
    });

    // fetching facilities
    let facilities=[];
    edit_form.elements['facilities'].forEach(el => {
        if(el.checked){
            facilities.push(el.value);
        }
        
    });
    
    data.append('features',JSON.stringify(features));
    data.append('facilities',JSON.stringify(facilities));

    let xhr=new XMLHttpRequest();
    xhr.open("POST","../ajax/room.php",true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            var myModal = document.getElementById('editroom');
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();
            alert("Room updated successfully!");
            edit_form.reset();
            location.reload();
        } else {
            alert("Error updating room. Please try again.");
            console.log(xhr.responseText);
        }
    };
    xhr.send(data);
}

// add room image 
function add_image(){
    let data=new FormData();
    data.append('image',imageform.elements['room_image'].files[0]);
    data.append('room_id',imageform.elements['room_id'].value);
    data.append('add_image','');

    let xhr=new XMLHttpRequest();
    xhr.open("POST","/project/ajax/room.php",true);

    xhr.onload = function () {
        if(this.responseText=='inv_image'){
            alert('Only jpg, png images allowed');
        }else if(this.responseText=='inv_size'){
            alert('image should be less than 2MB');
        }else if(this.responseText=='upd_failed'){
            alert('image upload failed');
        }else if(this.responseText=='success'){
            alert('image uploaded');
            imageform.reset();
        }else{
            alert("Server Error");
        }

    };
    xhr.send(data);
}

function room_image(id,name){
    imageform.elements['room_id'].value=id;
    document.getElementById('head_name').innerText=name;
}

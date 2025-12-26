
let feature_form=document.getElementById('feature_form');
let facility_form=document.getElementById('facility_form');

feature_form.addEventListener('submit',function(e){
    e.preventDefault();
    add_feature();
});


//add new features
function add_feature(){
    let data=new FormData();
    data.append('name',feature_form.elements['feature_name'].value);
    data.append('image',feature_form.elements['feature_image'].files[0]);
    data.append('add_feature','');
    
    let xhr=new XMLHttpRequest();
    xhr.open("POST","../ajax/features.php",true);

    xhr.onload=function(){
        var myModal=document.getElementById('feature');
        var modal=bootstrap.Modal.getInstance(myModal);
        modal.hide();
        console.log(this.responseText);

        let data=JSON.parse(this.responseText);
        if(data.status=='inv_image'){
            alert('Only jpg, png images allowed');
        }else if(data.status=='inv_size'){
            alert('image should be less than 2MB');
        }else if(data.status=='upd_failed'){
            alert('image upload failed');
        }else if(data.status=='success'){
            alert("Feature added successfully!");
        }else{
            alert("Server issues");
        }
        feature_form.reset();
        location.reload();;
    }
    xhr.send(data);
}

//to remove features
function rem_feature(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../ajax/features.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            alert("Feature deleted successfully!");
            location.reload();
        } else {
            alert("Error: " + xhr.responseText); 
        }
    };
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("rem_feature=" + val);
}

facility_form.addEventListener('submit',function(e){
    e.preventDefault();
    add_facility();
});

//add new facilities
function add_facility(){
    let data=new FormData();
    data.append('name',facility_form.elements['facility_name'].value);
    data.append('image',facility_form.elements['facility_image'].files[0]);
    data.append('add_facility','');
    
    let xhr=new XMLHttpRequest();
    xhr.open("POST","../ajax/features.php",true);

    xhr.onload=function(){
        var myModal=document.getElementById('facility');
        var modal=bootstrap.Modal.getInstance(myModal);
        modal.hide();
        console.log(this.responseText);

        let data=JSON.parse(this.responseText);
        if(data.status=='inv_image'){
            alert('Only jpg, png images allowed');
        }else if(data.status=='inv_size'){
            alert('image should be less than 2MB');
        }else if(data.status=='upd_failed'){
            alert('image upload failed');
        }else if(data.status=='success'){
            alert("Facility added successfully!");
        }else{
            alert("Server issues");
        }
        facility_form.reset();
        location.reload();
    }
    xhr.send(data);
}

//remove facilities
function rem_facility(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../ajax/features.php", true);
    xhr.onload = function () {
        if (xhr.responseText==1) {
            alert("Facility deleted successfully!");
            location.reload();
        } else {
            alert("Error: " + xhr.responseText); 
        }
    };
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("rem_facility=" + val);
}
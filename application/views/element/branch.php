<h2>branch</h2>
<p class="d-inline">Limit</p>
<select id="limit" class="form-select-sm">
    <option value=25>25</option>
    <option value=50>50</option>
    <option value=100>100</option>
    <option value=150>150</option>
    <option value=200>200</option>
</select>

<button type="button" class="btn btn-sm btn-primary" onclick="getTable()">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
        <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
    </svg>
</button>

<button type="button" class="btn btn-sm btn-primary" onclick="branch_create_init()">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
    </svg>
</button>

<div class="table-responsive shadow">
    <table id="table" class="table table-striped table-sm text-center mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th>#</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <tr>
                <td>#</td>
                <td>#</td>
                <td>#</td>
            </tr>
        </tbody>
    </table>
</div>

<div id="branch_form" style="display:none">
    <br>
    <h2 id="branch_form_title">Branch Edit</h2>

    <img id="imgpreview" style="height:200px;">

    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="ed_branch_id" disabled>
        <label for="ed_branch_id">id</label>
    </div>

    <form enctype="multipart/form-data" class="row mb-3 mx-1">
        <div class="col-5 border border-1 rounded-3">
            <input name="file" type="file" class="mt-1"/>
            <input type="button" id="button" value="Upload" class="mt-1"/>
        </div>
        <div class="col-6">
            <div class="form-floating">
                <input type="text" class="form-control" id="ed_branch_img">
                <label for="ed_branch_img">Branch Image</label>
            </div>
        </div>
    </form>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="ed_branch_name">
        <label for="ed_branch_name">Branch Name</label>
    </div>
    <div class="form-floating mb-3">
        <textarea type="text" class="form-control" id="ed_description"></textarea>
        <label for="ed_description">Description</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="ed_location">
        <label for="ed_location">Location</label>
    </div>
    <div class="text-end">
        <button id="branch_form_btn" type="button" class="btn btn-primary rounded-3 px-4" onclick="branchEdit()">Save</button>
    </div>
</div>

<script>
    function branch_create_init(){
        $("#table").hide();
        $("#branch_form").show(250);
        $("#branch_form_title").html("Create");
        $("#branch_form_btn").attr("onclick","branchCreate()")

        $("#ed_branch_id").val("");
        $("#ed_location").val("");
        $("#ed_branch_img").val("");
        $("#imgpreview").attr('src','');
        $("#ed_branch_name").val("");
        $("#ed_description").val("");
        $("#ed_contact").val('');
    }

    function branch_edit_init(id,loc,name,desc,img,cont){
        $("#table").hide();
        $("#branch_form").show(250);
        $("#branch_form_title").html("Edit");
        $("#branch_form_btn").attr("onclick","branchEdit()")

        $("#ed_branch_id").val(id);
        $("#ed_location").val(loc);
        $("#ed_branch_img").val(img);
        $("#imgpreview").attr('src','<?=base_url()?>'+img);
        $("#ed_branch_name").val(name);
        $("#ed_description").val(desc);
        $("#ed_contact").val(cont);
    }
    
    // fetch
    function branchCreate(){
        $.ajax({
            type: "POST",
            url: "<?=base_url("api/create/branch")?>",
            contentType : "application/json",
            data: JSON.stringify({
                "create":{
                    "img" : $("#ed_branch_img").val(),
                    "branch_name" : $("#ed_branch_name").val(),
                    "description" : $("#ed_description").val(),
                    "location" : $("#ed_location").val(),
                    "contact" : $("#ed_contact").val(),
                }
            }),
            success: function(respone){
                if(respone['status']=="ok"){getTable();}
                else{getTable();}
            },
        });
    }

    function branchEdit(){
        $.ajax({
            type: "POST",
            url: "<?=base_url("api/update/branch")?>",
            contentType : "application/json",
            data: JSON.stringify({
                "update_where":{"branch_id":$("#ed_branch_id").val()},
                "update":{
                    "img" : $("#ed_branch_img").val(),
                    "branch_name" : $("#ed_branch_name").val(),
                    "description" : $("#ed_description").val(),
                    "location" : $("#ed_location").val(),
                    "contact" : $("#ed_contact").val(),
                }
            }),
            success: function(respone){
                if(respone['status']=="ok"){getTable();}
                else{
                    alert(respone['error']);
                }
            },
        });
    }

    function branchDelete(id){
        if( ! confirm("Confirm delete branch "+id+" ?") ){ return; };
        $.ajax({
            type: "POST",
            url: "<?=base_url("api/delete/branch")?>",
            contentType : "application/json",
            data: JSON.stringify({
                "delete":{"branch_id":id}
            }),
            success: function(respone){
                if(respone['status']=="ok"){getTable();}
                else{getTable();}
            },
        });
    }

    /** image upload */
    $(':file').on('change', function () {
        var file = this.files[0];
        if (file.size > 1024000) {
            alert('max upload size is 1 mb');
        };
        if (!(file.type == 'image/jpg' || file.type == 'image/jpeg' || file.type == 'image/png')) {
            alert('only supported jpg, jpeg, png file.');
        };
    });

    $('#button').on('click', function () {
        $.ajax({
            url: "<?=base_url("imgcatch/branch")?>",
            type: 'POST',
            data: new FormData($('form')[0]),
            cache: false,
            contentType: false,
            processData: false,
            complete:(msg)=>{
                let response = JSON.parse(msg.responseText);
                alert(response.result);
                $("#imgpreview").attr('src',response.path);
                $("#ed_branch_img").val(response.path);
            }
        });
    });

    $("#ed_branch_img").change(()=>{
        $("#imgpreview").attr('src','<?=base_url()?>'+$("#ed_branch_img").val());
    });
    
    function getTable(){
        $("#branch_form,#table").hide();
        $.get(
            "<?=base_url("api/read/branch?limit=")?>"+$("#limit").val(), 
            function( data ) {
                console.log(data);
                let result = data['result'];
                let table = "";
                // console.log(Object.keys(result[0]));
                table += "<thead><tr>";
                Object.keys(result[0]).forEach(function(head) {
                    // console.log(key, result[idx][key]);
                    if (head!="is_deleted"){
                        table += "<th>"+(head=="branch_id"?"#":head)+"</th>";
                    }
                });
                table += "</tr></thead>";

                table+="<tbody class='table-group-divider'>";
                Object.keys(result).forEach(function(idx) {
                    // console.log(idx, result[idx]);
                    let id = result[idx]['branch_id'];
                    table+="<tr>";
                    Object.keys(result[idx]).forEach(function(key) {
                        // console.log(key, result[idx][key]);
                        if (key!="is_deleted"){

                            if(key=="img"){
                                let img_str = "<img src='<?=base_url()?>" +result[idx][key] + "' class='img-fluid' style='height:100px;'/>";
                                table += "<td>"+img_str+"</td>";
                            }
                            else{
                                table += "<td>"+result[idx][key]+"</td>";
                            }
                        }else if(key=="created_time"){
                            table += "<td>"+timestamp_DateTime(result[idx][key])+"</td>";
                        }else if(key=="modified_time"){
                            if(result[idx][key]){
                                table += "<td>"+timestamp_DateTime(result[idx][key])+"</td>";
                            }else{
                                table += "<td>---</td>";
                            }
                        }
                    });
                        
                    table+=`<td>
                        <div class='btn-group'>
                            <button class='btn btn-sm btn-primary' onclick=\"branch_edit_init('${id}','${result[idx]['location']}','${result[idx]['branch_name']}','${result[idx]['description']}','${result[idx]['img']}')\">Edit</button>
                            <button class='btn btn-sm btn-danger' onclick='branchDelete(\"${id}\")'>Delete</button>
                        </div>
                    </td></tr>`;
                });

                table+="</tbody>";
                $( "#table" ).html( table );
            }
        );
        $("#table").show(250);
    }

    $(document).ready(function(){
        getTable();
    })
</script>
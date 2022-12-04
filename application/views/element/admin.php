<h2>Admin</h2>
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

<button type="button" class="btn btn-sm btn-primary" onclick="admin_create_init()">
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

<div id="admin_form" style="display:none">
    <h2 id="admin_form_title">Admin Edit</h2>
    <img id="ed_img_preview"  width="100px">
    
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="ed_admin_id" disabled>
        <label for="ed_admin_id">Admin_id</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="ed_username" >
        <label for="ed_username">Username</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="ed_password">
        <label for="ed_password">Password</label>
    </div>
    <div class="form-floating mb-3">
        <input type="number" class="form-control" id="ed_branch_id">
        <label for="ed_branch_id">Branch_id</label>
    </div>
    <div class="form-floating mb-3">
        <input type="number" class="form-control" id="ed_superadmin">
        <label for="ed_superadmin">Superadmin</label>
    </div>
    <div class="text-end">
        <button id="admin_form_btn" type="button" class="btn btn-primary rounded-3 px-4" onclick="adminEdit()">Save</button>
    </div>
</div>

<script>

    function admin_create_init(){
        $("#table").hide();
        $("#admin_form").show(250);
        $("#admin_form_title").html("Create");
        $("#admin_form_btn").attr("onclick","adminCreate()")

        $("#ed_admin_id").val("");
        $("#ed_username").val("");
        $("#ed_password").val("");
        $("#ed_branch_id").val("");
        $("#ed_superadmin").val("");
    }

    function admin_edit_init(id,user,pwd,bh_id,spa){
        $("#table").hide();
        $("#admin_form").show(250);
        $("#admin_form_title").html("Edit");
        $("#admin_form_btn").attr("onclick","adminEdit()")

        $("#ed_admin_id").val(id);
        $("#ed_username").val(user);
        $("#ed_password").val(pwd);
        $("#ed_branch_id").val(bh_id);
        $("#ed_superadmin").val(spa);
    }
    
    // fetch
    function adminCreate(){
        $.ajax({
            type: "POST",
            url: "<?=base_url("api/create/admin")?>",
            contentType : "application/json",
            data: JSON.stringify({
                "create":{
                    "user":$("#ed_username").val(),
                    "pwd":$("#ed_password").val(),
                    "bh_id":$("#ed_branch_id").val(),
                    "spa":$("#ed_superadmin").val(),
                }
            }),
            success: function(respone){
                if(respone['status']=="ok"){getTable();}
                else{getTable();}
            },
        });
    }

    function adminEdit(id,arr){
        $("#ed_admin_id").val();
        $("#ed_username").val();
        $("#ed_password").val();
        $("#ed_branch_id").val();
        $("#ed_superadmin").val();
        $.ajax({
            type: "POST",
            url: "<?=base_url("api/update/admin")?>",
            contentType : "application/json",
            data: JSON.stringify({
                "update_where":{"menu_id":$("#ed_admin_id").val()},
                "update":{
                    "img" : $("#ed_username").val(),
                    "category" : $("#ed_password").val(),
                    "prod_name" : $("#ed_branch_id").val(),
                    "price" : $("#ed_superadmin").val(),
                }
            }),
            success: function(respone){
                if(respone['status']=="ok"){getTable();}
                else{getTable();}
            },
        });
    }
    function adminDelete(id){
        $.ajax({
            type: "POST",
            url: "<?=base_url("api/delete/admin")?>",
            contentType : "application/json",
            data: JSON.stringify({
                "delete":{"admin_id":id}
            }),
            success: function(respone){
                if(respone['status']=="ok"){getTable();}
                else{getTable();}
            },
        });
    }
    function getTable(){
        $("#admin_form,#table").hide();
        $("#table").show(250);
        $.get(
            "<?=base_url("api/read/admin?branch_id=".intval($admin['branch_id']))."&limit="?>"+$("#limit").val(), 
            function( data ) {
                console.log(data);
                let result = data['result'];
                let table = "";
                // console.log(Object.keys(result[0]));
                table += "<thead><tr>";
                Object.keys(result[0]).forEach(function(head) {
                    // console.log(key, result[idx][key]);
                    if (head!="is_deleted"){
                        table += "<th>"+(head=="admin_id"?"#":head)+"</th>";
                    }
                });
                table += "</tr></thead>";

                table+="<tbody class='table-group-divider'>";
                Object.keys(result).forEach(function(idx) {
                    // console.log(idx, result[idx]);
                    let id = result[idx]['admin_id'];
                    table+="<tr>";
                    Object.keys(result[idx]).forEach(function(key) {
                        // console.log(key, result[idx][key]);
                        if (key=="img"){
                            table += "<td><img width='100px' src='"+result[idx][key]+"'></td>";
                        } else if (key!="is_deleted"){
                            table += "<td>"+result[idx][key]+"</td>";
                        }
                    });
                        
                    table+="<td><div class='btn-group'><button class='btn btn-sm btn-primary' onclick=\"admin_edit_init('"+id+"','"+result[idx]['img']+"','"+result[idx]['category']+"','"+result[idx]['prod_name']+"','"+result[idx]['price']+"','"+result[idx]['description']+"')\">Edit</button><button class='btn btn-sm btn-danger' onclick='menuDelete(\""+id+"\")'>Delete</button></div></td></tr>";
                });

                table+="</tbody>";
                $( "#table" ).html( table );
            }
        );
    }

    $(document).ready(function(){
        getTable();
        $("#ed_img").change(()=>{
            let x = $("#ed_img").val();
            $("#ed_img_preview").attr("src",x);
        });
    })
</script>
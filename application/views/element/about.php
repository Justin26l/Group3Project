<div id="view_about">
    <h2>About</h2>
    <div class="text-center rounded-4 shadow-lg p-3">
        <img src="<?=$about['logo']?>" width="200">
        <h2><?=$about['company_name']?></h2>
        <p class="fs-7"><?=$about['description']?></p>
        <br/>
        <p><b>Customer Service</b><br/><?=$about['customer_service_no']?></p>
        <p><b>Bussiness Contact (<?=$about['bussiness_name']?>)</b><br/><?=$about['bussiness_no']?></p>
        <button type="button" id="edit" class="btn btn-primary rounded-3 px-4">Edit</button>
    </div>
</div>

<div id="edit_about" class="rounded-4 shadow-lg p-3" style="display:none;">
    <h2>Edit Info</h2>
    <img id="ed_logo_preview" src="<?=$about['logo']?>" width="100px">
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="ed_logo" name="logo" value="<?=$about['logo']?>">
        <label for="ed_logo">Logo Source Path</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="ed_company_name" name="company_name" value="<?=$about['company_name']?>">
        <label for="ed_company_name">Company Name</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="ed_customer_service_no" name="customer_service_no" value="<?=$about['customer_service_no']?>">
        <label for="ed_customer_service_no">Customer Service No</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="ed_bussiness_name" name="bussiness_name" value="<?=$about['bussiness_name']?>">
        <label for="ed_bussiness_name">Bussiness Contact Name</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="ed_bussiness_no" name="bussiness_no" value="<?=$about['bussiness_no']?>">
        <label for="ed_bussiness_no">Bussiness No</label>
    </div>
    <div class="form-floating mb-3">
        <textarea type="text" class="form-control" id="ed_description" name="description"><?=$about['description']?></textarea>
        <label for="ed_description">Description</label>
    </div>
    <div class="text-end">
        <button type="button" class="btn btn-primary rounded-3 px-4" data-bs-toggle="modal" data-bs-target="#ed_confirm">Save</button>
    </div>
</div>


<div class="modal" id="ed_confirm" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Info Change</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="editsend()">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- <pre>
    <?=print_r($about)?>
</pre> -->

<script>
    function editsend(){
        $.ajax({
            type: "POST",
            url: "<?=base_url("api/update/about")?>",
            data: {
                "update_where":{"logo":"<?=$about['logo']?>"},
                "update":{
                    "logo":$("#ed_logo").val(),
                    "company_name":$("#ed_company_name").val(),
                    "customer_service_no":$("#ed_customer_service_no").val(),
                    "bussiness_name":$("#ed_bussiness_name").val(),
                    "bussiness_no":$("#ed_bussiness_no").val(),
                    "description":$("#ed_description").val(),
                }
            },
            success: function(respone){
                $("#nav-about").click();
            },
        });
    }

    $(document).ready(()=>{
        $("#edit").click(()=>{
            $("#view_about").hide("fast");
            $("#edit_about").show("fast");
        });

        $("#ed_logo").change(()=>{
            let x = $("#ed_logo").val();
            console.log(x);
            $("#ed_logo_preview").attr("src",x);
        });
    });

</script>
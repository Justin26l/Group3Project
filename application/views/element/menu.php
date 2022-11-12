<h2>Booking</h2>
<p class="d-inline">Limit</p>
<select id="limit" class="form-select-sm">
    <option value=25>25</option>
    <option value=50>50</option>
    <option value=100>100</option>
    <option value=150>150</option>
    <option value=200>200</option>
</select>
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

<script>
    function bookUpdate(id,status){
        $.ajax({
            type: "POST",
            url: "<?=base_url("api/update/booking")?>",
            data: {
                "update_where":{"book_id":id},
                "update":{"status":status}
            },
            success: function(respone){
                if(respone['status']=="ok"){getTable();}
                else{getTable();}
            },
        });
    }
    function getTable(){
        $.get(
            "<?=base_url("api/read/menu?limit=")?>"+$("#limit").val(), 
            function( data ) {
                // console.log(data);
                let result = data['result'];
                let table = "";
                // console.log(Object.keys(result[0]));
                table += "<thead><tr>";
                Object.keys(result[0]).forEach(function(head) {
                    // console.log(key, result[idx][key]);
                    if (head!="is_deleted"){
                        table += "<th>"+(head=="menu_id"?"#":head)+"</th>";
                    }
                });
                table += "</tr></thead>";

                table+="<tbody class='table-group-divider'>";
                Object.keys(result).forEach(function(idx) {
                    // console.log(idx, result[idx]);
                    table+="<tr>";
                    Object.keys(result[idx]).forEach(function(key) {
                        // console.log(key, result[idx][key]);
                        if (key=="img"){
                            table += "<td><img width='100px' src='"+result[idx][key]+"'></td>";
                        } else if (key!="is_deleted"){
                            table += "<td>"+result[idx][key]+"</td>";
                        }
                    });
                    table+="</tr>";
                });
                table+="</tbody>";
                $( "#table" ).html( table );
            }
        );
    }

    $(document).ready(function(){
        $("#bookingTime").change(function(){console.log($("#bookingTime").val())})
        $("#limit").change(function(){getTable();})
        getTable();
    })
</script>
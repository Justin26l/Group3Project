<h2>Booking</h2>
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
    

    function timestamp_DateTime(timestamp){
        var a = new Date(timestamp * 1000);
        var year = a.getFullYear();
        var month = a.getMonth()+1;
        var date = a.getDate();
        var hour = a.getHours();
        var min = a.getMinutes();
        var sec = a.getSeconds();
        var time = year + '-' + month + '-' + date + ' ' + hour + ':' + min + ':' + sec ;
        return time;
    }

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
        $("#table").hide();
        $("#table").show(250);
        $.get(
            "<?=base_url("api/read/booking?book_branch=".intval($admin['branch_id']))."&limit="?>"+$("#limit").val(), 
            function( data ) {
                // console.log(data);
                let result = data['result'];
                let table = "";
                // console.log(Object.keys(result[0]));
                table += "<thead><tr>";
                Object.keys(result[0]).forEach(function(head) {
                    // console.log(key, result[idx][key]);
                    table += "<th>"+(head=="book_id"?"#":head)+"</th>";
                });
                table += "</tr></thead>";

                table+="<tbody class='table-group-divider'>";
                Object.keys(result).forEach(function(idx) {
                    // console.log(idx, result[idx]);
                    table+="<tr>";
                    Object.keys(result[idx]).forEach(function(key) {
                        // console.log(key, result[idx][key]);
                        if (key=="status"){
                            if (result[idx][key]=='accept'){
                                table += "<td class='bg-success bg-opacity-75 text-white'>"+result[idx][key]+"</td>";
                            }else if(result[idx][key]=='denied'){
                                table += "<td class='bg-danger bg-opacity-75 text-white'>"+result[idx][key]+"</td>";
                            }else if(result[idx][key]=='pending'){
                                table += "<td class='btn-group btn-group-sm'><button type='button' class='btn btn-success' onclick='bookUpdate("+result[idx]['book_id']+",\"accept\")'>Accept</button><button type='button' class='btn btn-danger' onclick='bookUpdate("+result[idx]['book_id']+",\"denied\")'>Denied</button></td>";
                            };
                        }else if(key=="created_time"){
                            table += "<td>"+timestamp_DateTime(result[idx][key])+"</td>";
                        }else if(key=="modified_time"){
                            if(result[idx][key]){
                                table += "<td>"+timestamp_DateTime(result[idx][key])+"</td>";
                            }else{
                                table += "<td>---</td>";
                            }
                            
                        }else{
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
        getTable();
        // console.log(timestamp_DateTime(Date.now()/1000))
    })
</script>
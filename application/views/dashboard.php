<body>

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Company name</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="<?=base_url('logout')?>">Sign out</a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3 sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file align-text-bottom" aria-hidden="true">
                                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                    <polyline points="13 2 13 9 20 9"></polyline>
                                </svg>
                                Booking
                            </a>
                        </li>

                    <?php if($admin['superadmin']==1){ ?>
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
                        <span>Super Admin</span>
                        <a class="link-secondary" href="#" aria-label="Add a new report">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle align-text-bottom" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                        </a>
                    </h6>
                    <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                            <a class="nav-link" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file align-text-bottom" aria-hidden="true">
                                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                    <polyline points="13 2 13 9 20 9"></polyline>
                                </svg>
                                Branch
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file align-text-bottom" aria-hidden="true">
                                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                    <polyline points="13 2 13 9 20 9"></polyline>
                                </svg>
                                About
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file align-text-bottom" aria-hidden="true">
                                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                    <polyline points="13 2 13 9 20 9"></polyline>
                                </svg>
                                Admin
                            </a>
                        </li>
                    </ul>
                    <?php }?>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                        <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                        <div class=""></div>
                    </div>
                </div>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>
                <h2>Booking</h2>
                <p class="d-inline">Limit</p>
                <select id="limit" class="form-select-sm">
                    <option value=25>25</option>
                    <option value=50>50</option>
                    <option value=100>100</option>
                    <option value=150>150</option>
                    <option value=200>200</option>
                </select>
                <div class="table-responsive">
                    <table id="table" class="table table-sm text-center bg-light">
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
            </main>
        </div>
    </div>
    <input type="datetime-local" id="bookingTime" value="2022-01-01 01:00" min="2022-01-01 01:00" max="2023-01-01 01:00">

    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
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
                "<?=base_url("api/read/booking?book_branch=".intval($admin['branch']))."&limit="?>"+$("#limit").val(), 
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
            $("#limit").change(function(){getTable();})
            getTable();
        })
    </script>
</body>

</html>
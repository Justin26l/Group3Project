<body>

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <p class="navbar-brand col-md-3 col-lg-2 m-0 px-3 fs-5" href="#"><?=$about['company_name']?></p>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap bg-danger">
                <a class="nav-link text-white px-3 fs-5" href="<?=base_url('logout')?>">Sign out</a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <!-- 侧边导览 -->
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse" style="height:100%;">
                <div class="position-sticky pt-3 sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <span id="nav-booking" class="nav-link" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M0 .5A.5.5 0 0 1 .5 0h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 0 .5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2A.5.5 0 0 1 .5 2h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2A.5.5 0 0 1 .5 4h10a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2A.5.5 0 0 1 .5 6h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2A.5.5 0 0 1 .5 8h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Z"/></svg>
                                Booking
                            </span>
                        </li>
                        <li class="nav-item">
                            <span id="nav-order" class="nav-link" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journals" viewBox="0 0 16 16"><path d="M5 0h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2 2 2 0 0 1-2 2H3a2 2 0 0 1-2-2h1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1H1a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v9a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1H3a2 2 0 0 1 2-2z"/><path d="M1 6v-.5a.5.5 0 0 1 1 0V6h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V9h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 2.5v.5H.5a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1H2v-.5a.5.5 0 0 0-1 0z"/></svg>
                                Order
                            </span>
                        </li>
                        <!-- Abandoned Function -->
                        <!-- <li class="nav-item">
                            <span id="nav-setting" class="nav-link" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journals" viewBox="0 0 16 16"><path d="M5 0h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2 2 2 0 0 1-2 2H3a2 2 0 0 1-2-2h1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1H1a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v9a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1H3a2 2 0 0 1 2-2z"/><path d="M1 6v-.5a.5.5 0 0 1 1 0V6h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V9h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 2.5v.5H.5a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1H2v-.5a.5.5 0 0 0-1 0z"/></svg>
                                Setting
                            </span>
                        </li> -->

                    <?php if($admin['superadmin']==1){ ?>
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
                        <span>Super Admin</span>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <span id="nav-menu" class="nav-link" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 60 60">
                                    <path d="M18.35,20.805c0.195,0.195,0.451,0.293,0.707,0.293c0.256,0,0.512-0.098,0.707-0.293c0.391-0.391,0.391-1.023,0-1.414   c-1.015-1.016-1.015-2.668,0-3.684c0.87-0.87,1.35-2.026,1.35-3.256s-0.479-2.386-1.35-3.256c-0.391-0.391-1.023-0.391-1.414,0   s-0.391,1.023,0,1.414c0.492,0.492,0.764,1.146,0.764,1.842s-0.271,1.35-0.764,1.842C16.555,16.088,16.555,19.01,18.35,20.805z"/>
                                    <path d="M40.35,20.805c0.195,0.195,0.451,0.293,0.707,0.293c0.256,0,0.512-0.098,0.707-0.293c0.391-0.391,0.391-1.023,0-1.414   c-1.015-1.016-1.015-2.668,0-3.684c0.87-0.87,1.35-2.026,1.35-3.256s-0.479-2.386-1.35-3.256c-0.391-0.391-1.023-0.391-1.414,0   s-0.391,1.023,0,1.414c0.492,0.492,0.764,1.146,0.764,1.842s-0.271,1.35-0.764,1.842C38.555,16.088,38.555,19.01,40.35,20.805z"/>
                                    <path d="M29.35,14.805c0.195,0.195,0.451,0.293,0.707,0.293c0.256,0,0.512-0.098,0.707-0.293c0.391-0.391,0.391-1.023,0-1.414   c-1.015-1.016-1.015-2.668,0-3.684c0.87-0.87,1.35-2.026,1.35-3.256s-0.479-2.386-1.35-3.256c-0.391-0.391-1.023-0.391-1.414,0   s-0.391,1.023,0,1.414c0.492,0.492,0.764,1.146,0.764,1.842s-0.271,1.35-0.764,1.842C27.555,10.088,27.555,13.01,29.35,14.805z"/>
                                    <path d="M25.345,28.61c0.073,0,0.147-0.008,0.221-0.024c1.438-0.324,2.925-0.488,4.421-0.488c0.004,0,0.008,0,0.013,0h0   c0.552,0,1-0.447,1-0.999c0-0.553-0.447-1.001-1-1.001c-0.004,0-0.009,0-0.014,0c-1.643,0-3.278,0.181-4.86,0.537   c-0.539,0.121-0.877,0.656-0.756,1.195C24.476,28.295,24.888,28.61,25.345,28.61z"/>
                                    <path d="M9.821,45.081c0.061,0.012,0.121,0.017,0.18,0.017c0.474,0,0.895-0.338,0.983-0.82c1.039-5.698,4.473-10.768,9.186-13.56   c0.475-0.281,0.632-0.895,0.351-1.37c-0.282-0.475-0.895-0.632-1.37-0.351c-5.204,3.083-8.992,8.661-10.134,14.921   C8.917,44.462,9.277,44.982,9.821,45.081z"/>
                                    <path d="M55.624,43.721C53.812,33.08,45.517,24.625,34.957,22.577c0.017-0.16,0.043-0.321,0.043-0.48c0-2.757-2.243-5-5-5   s-5,2.243-5,5c0,0.159,0.025,0.32,0.043,0.48C14.483,24.625,6.188,33.08,4.376,43.721C2.286,44.904,0,46.645,0,48.598   c0,5.085,15.512,8.5,30,8.5s30-3.415,30-8.5C60,46.645,57.714,44.904,55.624,43.721z M27.006,22.27   C27.002,22.212,27,22.154,27,22.098c0-1.654,1.346-3,3-3s3,1.346,3,3c0,0.057-0.002,0.114-0.006,0.172   c-0.047-0.005-0.094-0.007-0.14-0.012c-0.344-0.038-0.69-0.065-1.038-0.089c-0.128-0.009-0.255-0.022-0.383-0.029   c-0.474-0.026-0.951-0.041-1.432-0.041s-0.958,0.015-1.432,0.041c-0.128,0.007-0.255,0.02-0.383,0.029   c-0.348,0.024-0.694,0.052-1.038,0.089C27.1,22.263,27.053,22.264,27.006,22.27z M26.399,24.368   c0.537-0.08,1.077-0.138,1.619-0.182c0.111-0.009,0.222-0.017,0.333-0.025c1.098-0.074,2.201-0.074,3.299,0   c0.111,0.008,0.222,0.016,0.333,0.025c0.542,0.044,1.082,0.102,1.619,0.182c10.418,1.575,18.657,9.872,20.152,20.316   c0.046,0.321,0.083,0.643,0.116,0.965c0.011,0.111,0.026,0.221,0.036,0.332c0.039,0.443,0.068,0.886,0.082,1.329   c-15.71,3.641-32.264,3.641-47.974,0c0.015-0.443,0.043-0.886,0.082-1.329c0.01-0.111,0.024-0.221,0.036-0.332   c0.033-0.323,0.07-0.645,0.116-0.965C7.742,34.24,15.981,25.942,26.399,24.368z M30,55.098c-17.096,0-28-4.269-28-6.5   c0-0.383,0.474-1.227,2.064-2.328c-0.004,0.057-0.002,0.113-0.006,0.17C4.024,46.988,4,47.54,4,48.098v0.788l0.767,0.185   c8.254,1.98,16.744,2.972,25.233,2.972s16.979-0.991,25.233-2.972L56,48.886v-0.788c0-0.558-0.024-1.109-0.058-1.658   c-0.004-0.057-0.002-0.113-0.006-0.17C57.526,47.371,58,48.215,58,48.598C58,50.829,47.096,55.098,30,55.098z"/>
                                </svg>
                                Menu
                            </span>
                        </li>
                        <li class="nav-item">
                            <span id="nav-branch" class="nav-link" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z"/>                                </svg>
                                Branch
                            </span>
                        </li>
                        <li class="nav-item">
                            <span id="nav-about" class="nav-link" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022ZM6 8.694 1 10.36V15h5V8.694ZM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15Z"/>
                                    <path d="M2 11h1v1H2v-1Zm2 0h1v1H4v-1Zm-2 2h1v1H2v-1Zm2 0h1v1H4v-1Zm4-4h1v1H8V9Zm2 0h1v1h-1V9Zm-2 2h1v1H8v-1Zm2 0h1v1h-1v-1Zm2-2h1v1h-1V9Zm0 2h1v1h-1v-1ZM8 7h1v1H8V7Zm2 0h1v1h-1V7Zm2 0h1v1h-1V7ZM8 5h1v1H8V5Zm2 0h1v1h-1V5Zm2 0h1v1h-1V5Zm0-2h1v1h-1V3Z"/>
                                </svg>
                                About
                            </span>
                        </li>
                        <li class="nav-item">
                            <span id="nav-admin" class="nav-link" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 267.5 267.5">
                                    <path xmlns="http://www.w3.org/2000/svg" d="M256.975,100.34c0.041,0.736-0.013,1.485-0.198,2.229l-16.5,66c-0.832,3.325-3.812,5.663-7.238,5.681l-99,0.5  c-0.013,0-0.025,0-0.038,0H35c-3.444,0-6.445-2.346-7.277-5.688l-16.5-66.25c-0.19-0.764-0.245-1.534-0.197-2.289  C4.643,98.512,0,92.539,0,85.5c0-8.685,7.065-15.75,15.75-15.75S31.5,76.815,31.5,85.5c0,4.891-2.241,9.267-5.75,12.158  l20.658,20.814c5.221,5.261,12.466,8.277,19.878,8.277c8.764,0,17.12-4.162,22.382-11.135l33.95-44.984  C119.766,67.78,118,63.842,118,59.5c0-8.685,7.065-15.75,15.75-15.75s15.75,7.065,15.75,15.75c0,4.212-1.672,8.035-4.375,10.864  c0.009,0.012,0.02,0.022,0.029,0.035l33.704,45.108c5.26,7.04,13.646,11.243,22.435,11.243c7.48,0,14.514-2.913,19.803-8.203  l20.788-20.788C238.301,94.869,236,90.451,236,85.5c0-8.685,7.065-15.75,15.75-15.75s15.75,7.065,15.75,15.75  C267.5,92.351,263.095,98.178,256.975,100.34z M238.667,198.25c0-4.142-3.358-7.5-7.5-7.5h-194c-4.142,0-7.5,3.358-7.5,7.5v18  c0,4.142,3.358,7.5,7.5,7.5h194c4.142,0,7.5-3.358,7.5-7.5V198.25z"/>
                                </svg>
                                Admin
                            </span>
                        </li>
                    </ul>
                    <?php }?>
                </div>
            </nav>

            <!-- 主框架 -->
            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>
                <main id="page">
                    <!-- 盒子 -->
                </main>
            </div>

        </div>
    </div>

    <script>
        
        var tzoffset = (new Date()).getTimezoneOffset() * 60; //offset in milliseconds
        
        function load(path){
            console.log("Loading : <?=base_url("element?path=")?>"+path);
            $("#page").hide();
            $.get({
                url: "<?=base_url("element?path=")?>"+path,
                success: function(respone){
                    $("#page").html(respone);
                    $("#page").show(200);
                },
            });
        }
        
        $(document).ready(function(){
            load("booking");

            $("#nav-booking").click(()=>{load("booking");});
            $("#nav-order")  .click(()=>{load("order");});
            $("#nav-setting")  .click(()=>{load("setting");});

            $("#nav-menu")   .click(()=>{load("menu");});
            $("#nav-branch") .click(()=>{load("branch");});
            $("#nav-about")  .click(()=>{load("about");});
            $("#nav-admin")  .click(()=>{load("admin");});
            
        })
    </script>
</body>

</html>
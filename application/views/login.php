
<body class="text-center bg-light">

    <main class="w-50" style="margin:auto;margin-top:15%;">
        <form action="<?=base_url("loginverify")?>" method="post">
            <h1 class="h3 mb-3 fw-normal">Sign in</h1>

            <div class="form-floating">
                <input type="text" class="form-control" id="floatingInput" name="username">
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" name="password">
                <label for="floatingPassword">Password</label>
            </div>

            <p class="text-danger"><?=$x?></p>

            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
        </form>
    </main>

</body>
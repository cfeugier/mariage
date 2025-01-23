<!doctype html>
            <html lang="fr">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <meta name="description" content="">
                <meta name="author" content="">
                <!-- Change the title to the name of you and your spouse -->
                <title></title>
                <link rel="icon" href="assets/ring.png" sizes="32x32" type="image/png">
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
                <!-- Bootstrap core CSS -->
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
                <style>
                    /*
                    * Base structure
                    */

                    @font-face {
                    font-family: 'angella';
                    src: url('assets/877121ad-21c3-4236-b672-e201ebea7a2e.otf');
                    }

                    @media (min-width:1400px){
                    #background{
                        background-size: 50%;
                    }
                    .cormorand{
                        font-size: 20px;
                    }
                    }

                    @media (max-width:1400px) and (min-width:1200px){
                    #background{
                        background-size: 60%;
                    }
                    .cormorand{
                        font-size: 20px;
                    }
                    }

                    @media (max-width:1200px) and (min-width:992px){
                    #background{
                        background-size: 70%;
                    }
                    .cormorand{
                        font-size: 20px;
                    }
                    }

                    @media (max-width:992px) and (min-width:576px){
                    #background{
                        background-size: 80%;
                    }
                    .cormorand{
                        font-size: 15px;
                    }
                    }

                    @media (max-width:576px){
                    #background {
                        background-size: 100%;
                    }
                    .cormorand{
                        font-size: 12px;
                    }
                    .angella {
                        font-size: 70px !important;
                    }
                    }

                    #background {
                    background-image: url("assets/tacherose.png");
                    background-repeat: no-repeat;
                    background-attachment: fixed;
                    background-position-x: center;
                    background-position-y: center;
                    }

                    body {
                    display: -ms-flexbox;
                    display: flex;
                    background-image: url("assets/noisemini.png");
                    background-attachment: fixed;
                    font-family: "Cormorant Garamond", serif;
                    }

                    .angella {
                    font-family: "angella", serif;
                    font-size: 100px;
                    }

                    #buttonToggle {
                    position: absolute;
                    height: fit-content;
                    right: 10px;
                    border-color: #6c757d;
                    border-style: solid;
                    border-width: 2px;
                    border-radius: 5px;
                    padding: 7px;
                    top: 10px;
                    
                    }

                    #buttonToggle .navbar-toggler-icon{
                    background-image: url("data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'><path stroke='rgba(108, 117, 125, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/></svg>");
                    }

                    #buttonClose {
                    padding: 13px;
                    background-color: white;
                    border: #6c757d;
                    opacity: 1;
                    border-style: solid;
                    border-width: 1px;
                    color: #6c757d;
                    --bs-btn-close-bg: url("data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%236c757d'><path d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.416z'/></svg>");
                    }
                </style>
            </head>

            <body class="text-center" style="box-shadow: none !important; text-shadow: none;">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation" id="buttonToggle">
                <span class="navbar-toggler-icon"></span>
                </button>
                    <div class="nav" style="width: 100%;">
                        <div class="col-md-2"></div>
                        <div class="col-md-8 col-12" id="background">
                            <div class="col-md-12 align-items-left">
                            
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-12 col-12 row">
                                    <div class="col-sm-1 col-1"></div>
                                    <div class="col-sm-10 col-10 col-md-12"><p class="cormorand align-items-center" style="padding-top: 15px;">A WELCOMING MESSAGE FOR YOUR INVITEES</p></div>
                                    <div class="col-sm-1 col-1"></div>
                                </div>
                                <p class="angella align-items-center">Your name & spouse's name</p>
                                <br><br><br><br><br><br>
                                <!-- Add here the div that will be placed in the center and has the info about location, time and everything you might want to add -->
                            </div>
                            <div style="height: 200px;" class="col-md-12"></div>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="background-color: rgba(0,0,0,0); border-left: none;">
                        <div class="offcanvas-header">
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close" id="buttonClose"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                <li class="nav-item">
                                <button class="btn btn-light btn-outline-secondary" aria-current="page" onclick="window.open('/?idFamily=<?php echo $_COOKIE['idFamily']?>',  '_self');">I access my guest area</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    </div>
                <!-- Bootstrap core JavaScript
                ================================================== -->
                <!-- Placed at the end of the document so the pages load faster -->
                <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            </body>
            </html>
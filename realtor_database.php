<html lang="en">
    <?php require 'navbar.php'; ?>
    <?php if($_SESSION['admin']!= 1) {
               echo "<br><br>Unauthorized Access";
               exit();
            }
            ?>
    <head>
        <title>Listings database</title>
        <style>
            .breadcrumb{
                background: none;
                text-align: left;
            }
            .navbar-brand, .nav{
                font-family: 'Helvetica Neue', serif;
                font-weight: lighter;

            }
            body{padding-top:0%;}
            .top-container{
                margin-top: 80px;
                /*                background-color:#e5e5e5;*/
                border-radius: 10px; 

            }
            .transbox{
                background:rgba(0, 0, 0, .07);
                border-radius: 10px; 
                box-shadow: 1px 7px 36px -5px;
            }
            body { padding-bottom: 50px; }
            h4 {text-align: center;}
        </style>
    </head>
    <body>
        <br>
        <br>
        <br>
            <div class="container top-container transbox">
                <div class="container text-center">
                    <h1>My Listings</h1> 
                </div>
                </div>
                <?php
                realtor_display_table($_SESSION['id']);
                ?><br> 
            

        </body>
        <div class="footer" style="background-color: #e7e7e7; border-color: #777; width: 100%; position: fixed;bottom: 0">
            <h4>This is for demonstration purposes only. CSC648/848 San Francisco State University Team02 Milestone Properties</h4>
        </div>
    </html>

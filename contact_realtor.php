<html lang="en">
<?php require 'navbar.php'; ?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contact realtor</title>
        <style>
            .jumbotron {

                color: #000;
                border-radius: 0px;
            }
            .jumbotron-sm { padding-top: 24px;
                            padding-bottom: 24px; }
            .jumbotron small {
                color: #000;
            }
            .h1 {
                text-align: center;
                font-size: 20px;
            }
            .h2 {
                text-align: center;
                font-size: 16px;
            }
			h4 {text-align: center;}
        </style>
    </head>

    <?php
        if(isset($_POST['contact'])) {
            contact_realtor();
        }
    ?>
    
    <body>
        <div class="jumbotron jumbotron-sm">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <h1 class="h1">
                            Thank you for your interest in our property </h1>
                        <h2 class="h2">Our realtors will be in contact with you shortly</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-8 center-block" >
                    <div class="well well-sm">
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Enter name" required="required" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '' ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
                                            </span>
                                            <input type="email" class="form-control" name="email" placeholder="Enter email" required="required" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span>
                                            </span>
                                            <input type="phone" class="form-control" name="phone" placeholder="Enter phone number" required="required" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : '' ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="message">Message</label>
                                        <textarea name="message" maxlength="300" class="form-control" rows="9" cols="25" required="required" <?php if(!isset($_POST['message'])) { echo "placeholder=\"Please let us know if you have any questions (300 characters max)\"";}?>><?php echo isset($_POST['message']) ? $_POST['message'] : '' ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" name="contact" value="<?php echo '' . $_POST['idListing'] . ''; ?>" class="btn btn-primary pull-right">
                                        Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <form>
                        <legend><span class="glyphicon glyphicon-globe"></span>Our office</legend>
                        <address>
                            <strong>Milestone Properties,</strong><br>
                            1600 Holloway Avenue<br>
                            San Francisco, CA 94132<br>
                            <abbr title="Phone">
                                P:</abbr>
                            (123) 456-7890
                        </address>
                    </form>
                </div>
            </div>
        </div>

        <div class="footer" style="background-color: #e7e7e7; border-color: #777; width: 100%; position: fixed;bottom: 0">
            <h4>This is for demonstration purposes only. CSC648/848 San Francisco State University Team02 Milestone Properties</h4>
        </div>
		
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    </body>
</html>

<?php
    function contact_realtor() {
        $connection = connect_to_mysql();
        $query = "INSERT INTO touched (idListing, name, email, phone, message) VALUES('";
        $query .= $_POST['contact'] . "','";
        $query .= $_POST['name'] . "','";
        $query .= $_POST['email'] . "','";
        $query .= $_POST['phone'] . "','";
        $query .= $_POST['message'] . "')";
        mysqli_query($connection, $query);
        
        echo "<script type='text/javascript'>alert('Request sent to realtor!');</script>";
    }
?>
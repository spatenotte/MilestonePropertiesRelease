<html lang="en">
<?php require 'navbar.php'; ?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>About Us Page</title>
        <style>
            .jumbotron {
				margin-top: 10px;
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
                font-family: 'Helvetica Neue', serif;
                font-weight: lighter;
            }
            .h2 {
                font-family: 'Helvetica Neue', serif;
                font-weight: lighter;
                text-align: center;
                font-size: 18px
            }
                        .navbar-brand, .nav{
                font-family: 'Helvetica Neue', serif;
                font-weight: lighter;

            }
			h4 { text-align: center;}
        </style>
    </head>

    <body>
        <div class="jumbotron jumbotron-sm">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <h1 class="h1">
                            Contact us </h1>
                        <h2 class="h2">Feel free to contact us</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-8 center-block" >
                    <div class="well well-sm">
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">
                                            Name</label>
                                        <input type="text" class="form-control" id="name" placeholder="Enter name" required="required" />
                                    </div>
                                    <div class="form-group">
                                        <label for="email">
                                            Email Address</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
                                            </span>
                                            <input type="email" class="form-control" id="email" placeholder="Enter email" required="required" /></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">
                                            Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span>
                                            </span>
                                            <input type="phone" class="form-control" id="phone" placeholder="Enter phone number" required="required" /></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">
                                            Message</label>
                                        <textarea name="message" id="message" class="form-control" rows="9" cols="25" required="required"
                                                  placeholder="Description"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary pull-right" id="btnContactUs">
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

    </body>
</html>
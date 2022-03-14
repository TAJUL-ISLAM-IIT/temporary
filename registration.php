<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form_registration'])) {

    $error_message = '';
    $success_message = '';
    $valid = 1;
    $hash = md5(time());
    $cust_name = strip_tags($_POST['cust_name']);
    $cust_phone = strip_tags($_POST['cust_phone']);
    $cust_email = strip_tags($_POST['cust_email']);
    $cust_password = strip_tags($_POST['cust_password']);

    if ($cust_name == '') {
        $valid = 0;
        $error_message = 'Name can not be empty<br>';
    }
    if ($cust_phone == '') {
        $valid = 0;
        $error_message = 'Phone Address can not be empty<br>';
    }
    if ($cust_email == '') {
        $valid = 0;
        $error_message = 'Email Address can not be empty<br>';
    } else {
        if (!filter_var($cust_email, FILTER_VALIDATE_EMAIL)) {
            $valid = 0;
            $error_message = 'Email Address is invalid<br>';
        }
    }

    if ($cust_password == '') {
        $valid = 0;
        $error_message = 'Password can not be empty<br>';
    }
    $q = $pdo->prepare("SELECT count(cust_email) FROM customer WHERE cust_email = ?");
    $q->execute([$cust_email]);
    $res = $q->fetchAll();
    foreach ($res as $row) {
        if ($row['count(cust_email)'] > 0) {
            $valid = 0;
            $error_message = 'Email is already is use!' . '<br>';
            break;
        }
    }


    if ($valid == 1) {
        $q = $pdo->prepare("INSERT INTO customer (
                    cust_name,
                    cust_phone,
                    cust_email,
                    cust_password,
                    cust_hash,
                    cust_active
                ) 
                VALUES (?,?,?,?,?,?)");
        $q->execute([
            $cust_name,
            $cust_phone,
            $cust_email,
            md5($cust_password),
            $hash, 0
        ]);

        $success_message .= 'Registered successfully!';
    }
}
?>

<!-- Parallax Effect -->
<script type="text/javascript">
$(document).ready(function() {
    $('#parallax-pagetitle').parallax("50%", -0.55);
});
</script>

<section class="parallax-effect">
    <div id="parallax-pagetitle" style="background-image: url(images/parallax/parallax-01.jpg);">
        <div class="color-overlay">
            <!-- Page title -->
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <ol class="breadcrumb">
                            <li><a href="index.php">Home</a></li>
                            <li class="active">Registration</li>
                        </ol>
                        <h1>Registration</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <div class="row">
        <!-- Contact form -->
        <section id="contact-form" class="mt20">
            <div class="col-md-7">


                <?php if ($success_message) {
                    echo '<div class="alert alert-success">' . $success_message . '</div>';
                    $success_message = '';
                    $error_message = '';
                } else if ($error_message) {
                    echo '<div class="alert alert-danger">' . $error_message . '</div>';
                    $success_message = '';
                    $error_message = '';
                }
                ?>

                <form class="clearfix mt5" method="post" action="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name"><span class="required">*</span> Name</label>
                                <input name="cust_name" type="text" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name"> Phone Number</label>
                                <input name="cust_phone" type="text" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name"><span class="required">*</span> Email Address</label>
                                <input name="cust_email" type="text" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name"><span class="required">*</span> Password</label>
                                <input name="cust_password" type="password" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn  btn-lg btn-primary" name="form_registration">Regisater
                        Now!</button>
                </form>




            </div>
        </section>
    </div>
</div>


<?php require_once('footer.php'); ?>
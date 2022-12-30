<?php
$User = new User();

Alerts::displayError();
Alerts::displaySuccess();
?>
<div class="container py-5">
    <div class="row">
        <div class="col-lg-5 mx-auto">
            <div class="card py-4">
                <div class="card-body">
                    <h4 class="mb-3">Mail Pigeon</h4>
                    <hr class="pb-3">

                    <form action="controllers/fly.php" method="post">
                        <div class="row gy-3">
                            <div class="col-lg-7">
                                <label for="subject" class="form-label">Email Subject</label>
                                <input type="text" name="subject" class="form-control" id="subject" aria-describedby="subjectHelp">
                                <div id="subjectHelp" class="form-text">Enter the subject of the email</div>
                            </div>
                            <div class="col-lg-5">
                                <label for="from" class="form-label">From</label>
                                <input type="email" name="from" class="form-control" id="from" aria-describedby="emailFromHelp">
                                <div id="emailFromHelp" class="form-text d-none">Enter email your are sending from</div>
                            </div>
                            <div class="col-lg-12">
                                <label for="receivers" class="form-label">Receiver(s)</label>
                                <textarea class="form-control" name="receivers" id="receivers" rows="3" aria-describedby="receiversHelp"></textarea>
                                <div id="receiversHelp" class="form-text">Comma Seperated</div>
                            </div>
                            <div class="col-lg-12">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control summernote" name="message" id="message" rows="3"></textarea>
                            </div>
                            <div class="col-lg-12">
                                <input type="hidden" name="token" value="<?= Token::generate(); ?>">
                                <button type="submit" class="btn px-3 btn-primary">Fly Bird, Fly</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
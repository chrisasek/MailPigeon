<?php
$User = new User();

$form_data = Session::exists('form_data') ? Session::get('form_data') : null;

Alerts::displayError();
Alerts::displaySuccess();
?>
<div class="container py-5">
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card py-4">
                <div class="card-body">
                    <h4 class="mb-3">Mail Pigeon</h4>
                    <hr class="pb-3">

                    <form action="controllers/fly.php" method="post">
                        <div class="row gy-3">
                            <div class="col-lg-12">
                                <label for="subject" class="form-label">Email Subject</label>
                                <input type="text" name="subject" value="<?= $form_data ? $form_data['subject'] : null; ?>" class="form-control" id="subject" aria-describedby="subjectHelp">
                                <div id="subjectHelp" class="form-text">Enter the subject of the email</div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="from_name" class="form-label">From</label>
                                <div class="input-group">
                                    <span class="input-group-text">Text</span>
                                    <input type="text" name="from_name" value="<?= $form_data ? $form_data['from_name'] : null; ?>" class="form-control" placeholder="Favour from Mail Pigeon" aria-label="text" required>
                                    <span class="input-group-text">Link</span>
                                    <input type="text" name="from_email" value="<?= $form_data ? $form_data['from_email'] : null; ?>" class="form-control" placeholder="favour@mailpigeon.com" aria-label="link" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label for="receivers" class="form-label">Receiver(s)</label>
                                <textarea class="form-control" name="receivers" id="receivers" rows="3" aria-describedby="receiversHelp"><?= $form_data ? $form_data['receivers'] : null; ?></textarea>
                                <div id="receiversHelp" class="form-text">Comma Seperated</div>
                            </div>
                            <div class="col-lg-12">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control summernote" name="message" id="message" rows="3"><?= $form_data ? $form_data['message'] : null; ?></textarea>
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
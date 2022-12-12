<?php

declare(strict_types=1);

use CliffordVickrey\FecReporter\App\Response\Response;

header('Content-Type: text/html; charset=UTF-8');

$response = $response ?? new Response();

$content = $response->getAttribute('content', '');
$js = $response->getAttribute(Response::ATTR_JS, false);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width,initial-scale=1" name="viewport">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>FEC Reporter</title>
</head>
<body>
<div class="container-fluid my-3">
    <div class="row">
        <div class="col-12">
            <div class="col-12 mt-3">
                <div class="card">
                    <h5 class="card-header">FEC Reporter</h5>
                    <div class="card-body">
                        <!-- content -->
                        <?= $content; ?>
                        <!-- /content -->
                    </div>
                    <div class="card-footer">
                        <small>Copyright &copy; 2022 Clifford Vickrey. All rights
                            reserved, all wrongs <em>avenged</em></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if ($js) { ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
            crossorigin="anonymous"></script>
    <!-- Credit: https://github.com/gch1p/bootstrap-5-autocomplete -->
    <!--suppress HtmlUnknownTarget -->
    <script src="js/typeahead.js"></script>
    <!--suppress HtmlUnknownTarget -->
    <script src="js/fec.js?version=1"></script>
<?php } ?>
</body>
</html>

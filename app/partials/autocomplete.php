<?php

declare(strict_types=1);

use CliffordVickrey\FecReporter\App\Response\Response;
use CliffordVickrey\FecReporter\App\View\View;

$response = $response ?? new Response();
$view = $view ?? new View();

$id = $view->htmlEncode($response->getAttribute('id', ''));
$name = $view->htmlEncode($response->getAttribute('name', ''));
$payload = $view->htmlEncode(json_encode($response['options']) ?: '[]');
$label = $view->htmlEncode((string)$response->getAttribute('label', ''));
$text = $view->htmlEncode((string)$response->getAttributeNullable('text', ''));
$value = isset($response['value']) ? $response['value'] : null;

if (is_scalar($value)) {
    $value = (string)$value;
} else {
    $value = '';
}

?>

<div class="col-12 col-lg-6">
    <div class="input-group">
            <span class="input-group-text" id="<?= $id; ?>-addon">
                <?= $label; ?>
            </span>
        <input id="<?= $id; ?>-search" data-payload="<?= $payload; ?>" data-autocomplete="1"
               aria-describedby="<?= $id; ?>-addon" aria-label="<?= $label; ?>" data-bound-to="<?= $id; ?>"
               class="form-control"<?= '' === $text ? '' : sprintf(' value="%s"', $text); ?> autocomplete="off">
    </div>
</div>
<div class="col-12 col-lg-6">
    <button class="btn btn-secondary mt-3 mt-lg-0" data-clear="1" data-bound-to="<?= $id; ?>">Clear</button>
</div>
<input id=<?= $id; ?> name="<?= $name; ?>" type="hidden"
       autocomplete="off"<?= '' === $value ? '' : sprintf(' value="%s"', $value); ?>/>

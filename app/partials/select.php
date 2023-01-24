<?php

declare(strict_types=1);

use CliffordVickrey\FecReporter\App\Response\Response;
use CliffordVickrey\FecReporter\App\View\View;

$response = $response ?? new Response();
$view = $view ?? new View();

$hasBlank = $response->getAttribute('hasBlank', false);
$id = $response->getAttribute('id', '');
$name = $response->getAttribute('name', '');
$label = $response->getAttribute('label', '');

$options = $hasBlank ? ['' => ''] : [];

$options += $response->getAttribute('options', []);
$value = isset($response['value']) ? $response['value'] : null;

if (is_scalar($value)) {
    $value = (string)$value;
} else {
    $value = '';
}

?>
<div class="input-group">
    <span class="input-group-text" id="<?= $view->htmlEncode($id); ?>-addon"><?= $view->htmlEncode($label); ?></span>
    <select id="<?= $view->htmlEncode($id); ?>" class="form-select" autocomplete="off"
            aria-label="<?= $view->htmlEncode($label); ?>" aria-describedby="<?= $view->htmlEncode($id); ?>-addon"
            name="<?= $view->htmlEncode($name); ?>" data-dropdown="1">
        <?php foreach ($options as $k => $v) {
            $selected = $k === $value ? ' selected="selected"' : '';
            ?>
            <option value="<?= $view->htmlEncode($k); ?>"<?= $selected; ?>><?= $view->htmlEncode($v); ?></option>
        <?php } ?>
    </select>
</div>

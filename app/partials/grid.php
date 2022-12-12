<?php

declare(strict_types=1);

use CliffordVickrey\FecReporter\App\Response\Response;
use CliffordVickrey\FecReporter\App\View\View;
use CliffordVickrey\FecReporter\Infrastructure\Grid\AbstractGrid;
use CliffordVickrey\FecReporter\Infrastructure\Grid\GridColumnFormat;
use CliffordVickrey\FecReporter\Infrastructure\Utility\CastingUtilities;

$response = $response ?? new Response();
$view = $view ?? new View();

$numberFormatter = new NumberFormatter('en_US', NumberFormatter::DECIMAL);
$currencyFormatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
$intlDateFormatter = new IntlDateFormatter('en_US', IntlDateFormatter::SHORT, IntlDateFormatter::NONE);
$percentFormatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
$percentFormatter->setAttribute(NumberFormatter::FRACTION_DIGITS, 2);

$grid = $response->getObject(AbstractGrid::class);

$metaColSpans = $grid->getMetaColSpans();
$colWidths = $grid->getColWidths();
$values = $grid->getValues();

?>
<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <colgroup>
            <?php foreach ($colWidths as $colWidth) { ?>
                <col style="width: <?= $view->htmlEncode($percentFormatter->format($colWidth)); ?>;">
            <?php } ?>
        </colgroup>
        <thead>
        <?php if (0 !== count($metaColSpans)) { ?>
            <tr>
                <?php foreach ($metaColSpans as $metaColspan) { ?>
                    <th class="text-center"<?= $metaColspan['colSpan'] > 1
                        ? sprintf(' colspan="%d"', $metaColspan['colSpan'])
                        : '';
                    ?>><?= $view->htmlEncode($metaColspan['title']); ?></th>
                <?php } ?>
            </tr>
        <?php } ?>
        <tr>
            <?php foreach ($grid as $column) { ?>
                <th class="text-center"><?= $view->htmlEncode($column->title); ?></th>
            <?php } ?>
        </tr>
        </thead>
        <tbody>
        <?php if (0 === count($values)) { ?>
            <tr>
                <td class="text-muted text-center"<?= count($grid) > 1
                    ? sprintf(' colspan="%d"', count($grid))
                    : '';
                ?>>There is no data to display.
                </td>
            </tr>
        <?php } else { ?>
            <?php foreach ($values as $row) { ?>
                <tr>
                    <?php foreach ($row as $columnId => $value) {
                        $col = $grid[$columnId];
                        $class = $col->getClass();

                        $format = (string)$col->format;

                        $formattedValue = $value;

                        if (null !== $value && '' !== $value) {
                            switch ($format) {
                                case GridColumnFormat::FORMAT_CURRENCY:
                                    $valueFloat = CastingUtilities::toFloat($value);
                                    $formattedValue = $currencyFormatter->format($valueFloat);
                                    break;
                                case GridColumnFormat::FORMAT_DATE:
                                    $valueDt = CastingUtilities::toDateTimeImmutable($value);

                                    if (null === $valueDt) {
                                        $formattedValue = '';
                                    } else {
                                        $formattedValue = $intlDateFormatter->format($valueDt);
                                    }

                                    break;
                                case GridColumnFormat::FORMAT_NUMBER:
                                    $valueInt = CastingUtilities::toUnsignedInt($value);
                                    $formattedValue = $numberFormatter->format($valueInt);
                                    break;
                                case GridColumnFormat::FORMAT_PERCENT:
                                    $valueFloat = CastingUtilities::toFloat($value);
                                    $formattedValue = $percentFormatter->format($valueFloat);
                                    break;
                            }
                        }

                        ?>
                        <td class="<?= $view->htmlEncode($class); ?>"><?= $view->htmlEncode($formattedValue); ?></td>
                    <?php } ?>
                </tr>
            <?php }
        } ?>
        </tbody>
    </table>
</div>


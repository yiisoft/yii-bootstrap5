<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

/**
 * Html is an enhanced version of {@see \Yiisoft\Html\Html} helper class dedicated to the Bootstrap needs.
 * This class inherits all functionality available at {@see \Yiisoft\Html\Html} and can be used as substitute.
 *
 * Attention: do not confuse {@see \Yiisoft\Yii\Bootstrap4\Html} and {@see \Yiisoft\Html\Html}, be careful in which
 * class you are using inside your views.
 */
class Html extends \Yiisoft\Html\Html
{
    /**
     * Renders Bootstrap static form control.
     *
     * @param string $value static control value.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as the attributes of
     * the resulting tag. There are also a special options:
     *
     * @return string generated HTML
     *
     * {@see https://getbootstrap.com/docs/4.2/components/forms/#readonly-plain-text}
     */
    public static function staticControl(string $value, array $options = []): string
    {
        static::addCssClass($options, 'form-control-plaintext');

        $value = (string)$value;
        $options['readonly'] = true;

        return static::input('text', null, $value, $options);
    }

    /**
     * Generates a Bootstrap radiolist.
     *
     * @param string $name
     * @param null $selection
     * @param array $items
     * @param array $options
     *
     * @return string
     */
    public static function radioList(string $name, $selection = null, array $items = [], array $options = []): string
    {
        if (!isset($options['item'])) {
            $itemOptions = ArrayHelper::remove($options, 'itemOptions', []);
            $encode = ArrayHelper::getValue($options, 'encode', true);
            $options['item'] = static function ($label, $name, $checked, $value) use ($itemOptions, $encode) {
                $options = \array_merge([
                    'class' => 'form-check-input',
                    'label' => $encode ? static::encode($label) : $label,
                    'labelOptions' => ['class' => 'form-check-label'],
                    'value' => $value
                ], $itemOptions);

                return '<div class="form-check">' . static::radio($name, $checked, $options) . '</div>';
            };
        }

        return parent::radioList($name, $selection, $items, $options);
    }

    /**
     * Generates a Bootstrap radiolist.
     *
     * @param string $name
     * @param null $selection
     * @param array $items
     * @param array $options
     *
     * @return string
     */
    public static function checkboxList(string $name, $selection = null, array $items = [], array $options = []): string
    {
        if (!isset($options['item'])) {
            $itemOptions = ArrayHelper::remove($options, 'itemOptions', []);
            $encode = ArrayHelper::getValue($options, 'encode', true);
            $options['item'] = function ($label, $name, $checked, $value) use ($itemOptions, $encode) {
                $options = \array_merge([
                    'class' => 'form-check-input',
                    'label' => $encode ? static::encode($label) : $label,
                    'labelOptions' => ['class' => 'form-check-label'],
                    'value' => $value
                ], $itemOptions);

                return '<div class="form-check">' . Html::checkbox($name, $checked, $options) . '</div>';
            };
        }

        return parent::checkboxList($name, $selection, $items, $options);
    }

    /**
     * Generate booleanInput.
     *
     * @param string $type
     * @param string $name
     * @param bool $checked
     * @param array $options
     *
     * @return string
     */
    protected static function booleanInput(string $type, string $name, bool $checked = false, array $options = []): string
    {
        $options['checked'] = (bool)$checked;
        $value = \array_key_exists('value', $options) ? $options['value'] : '1';
        if (isset($options['uncheck'])) {
            // add a hidden field so that if the checkbox is not selected, it still submits a value
            $hiddenOptions = [];
            if (isset($options['form'])) {
                $hiddenOptions['form'] = $options['form'];
            }
            $hidden = static::hiddenInput($name, $options['uncheck'], $hiddenOptions);
            unset($options['uncheck']);
        } else {
            $hidden = '';
        }
        if (isset($options['label'])) {
            $label = $options['label'];
            $labelOptions = $options['labelOptions'] ?? [];
            unset($options['label'], $options['labelOptions']);

            if (!isset($options['id'])) {
                $options['id'] = static::getId();
            }

            $input = static::input($type, $name, $value, $options);

            if (!empty($labelOptions['wrapInput'])) {
                unset($labelOptions['wrapInput']);
                $content = static::label($input . $label, $options['id'], $labelOptions);
            } else {
                $content = $input . "\n" . static::label($label, $options['id'], $labelOptions);
            }

            return $hidden . $content;
        }

        return $hidden . static::input($type, $name, $value, $options);
    }
}

<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use JsonException;
use RuntimeException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

use function is_array;
use function is_string;

/**
 * Nav renders a nav HTML component.
 *
 * For example:
 *
 * ```php
 *    if ($user->getId() !== null) {
 *        $menuItems = [
 *            [
 *                'label' => 'About',
 *                'url' => '/about',
 *            ],
 *            [
 *                'label' => 'Contact',
 *                'url' => '/contact',
 *            ],
 *            [
 *                'label' => 'Logout' . ' ' . '(' . $user->getUsername() . ')',
 *                'url' => '/logout'
 *            ],
 *        ];
 *    } else {
 *        $menuItems = [
 *            [
 *                'label' => 'About',
 *                'url' => '/about',
 *            ],
 *            [
 *                'label' => 'Contact',
 *                'url' => '/contact',
 *            ],
 *            [
 *                'label' => 'Login',
 *                'url' => '/login',
 *            ],
 *        ];
 *    }
 *
 *    echo Nav::widget()
 *        ->currentPath($currentPath)
 *        ->items($menuItems)
 *        ->options([
 *            'class' => 'navbar-nav float-right ml-auto'
 *        ]);
 *
 * Note: Multilevel dropdowns beyond Level 1 are not supported in Bootstrap 3.
 * Note: $currentPath it must be injected from each controller to the main controller.
 *
 * SiteController.php
 *
 * ```php
 *
 *    public function index(ServerRequestInterface $request): ResponseInterface
 *    {
 *        $response = $this->responseFactory->createResponse();
 *        $currentPath = $request->getUri()->getPath();
 *        $output = $this->render('index', ['currentPath' => $currentPath]);
 *        $response->getBody()->write($output);
 *
 *        return $response;
 *    }
 * ```
 *
 * Controller.php
 *
 * ```php
 *    private function renderContent($content, array $parameters = []): string
 *    {
 *        $user = $this->user->getIdentity();
 *        $layout = $this->findLayoutFile($this->layout);
 *
 *        if ($layout !== null) {
 *            return $this->view->renderFile(
 *                $layout,
 *                    [
 *                        'aliases' => $this->aliases,
 *                        'content' => $content,
 *                        'user' => $user,
 *                        'params' => $this->params,
 *                        'currentPath' => !isset($parameters['currentPath']) ?: $parameters['currentPath']
 *                    ],
 *                $this
 *            );
 *        }
 *
 *        return $content;
 *    }
 * ```
 *
 * {@see http://getbootstrap.com/components/#dropdowns}
 * {@see http://getbootstrap.com/components/#nav}
 */
class Nav extends Widget
{
    private array $items = [];
    private bool $encodeLabels = true;
    private bool $activateItems = true;
    private bool $activateParents = false;
    private ?string $currentPath = null;
    private array $params = [];
    private string $dropdownClass = Dropdown::class;
    private array $options = [];
    private string $label = '';

    protected function run(): string
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-nav";
        }

        Html::addCssClass($this->options, ['widget' => 'nav']);

        return $this->renderItems();
    }

    /**
     * Renders widget items.
     *
     * @throws RuntimeException|JsonException
     *
     * @return string
     */
    public function renderItems(): string
    {
        $items = [];

        foreach ($this->items as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }

            $items[] = $this->renderItem($item);
        }

        return Html::tag('ul', implode("\n", $items), $this->options);
    }

    /**
     * Renders a widget's item.
     *
     * @param array|string $item the item to render.
     *
     * @throws RuntimeException|JsonException
     *
     * @return string the rendering result.
     */
    public function renderItem($item): string
    {
        if (is_string($item)) {
            return $item;
        }

        if (!isset($item['label'])) {
            throw new RuntimeException("The 'label' option is required.");
        }

        $encodeLabel = $item['encode'] ?? $this->encodeLabels;
        $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
        $options = ArrayHelper::getValue($item, 'options', []);
        $items = ArrayHelper::getValue($item, 'items');
        $url = ArrayHelper::getValue($item, 'url', '#');
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
        $disabled = ArrayHelper::getValue($item, 'disabled', false);
        $active = $this->isItemActive($item);

        if (empty($items)) {
            $items = '';
        } else {
            $linkOptions['data-toggle'] = 'dropdown';

            Html::addCssClass($options, ['widget' => 'dropdown']);
            Html::addCssClass($linkOptions, ['widget' => 'dropdown-toggle']);

            if (is_array($items)) {
                $items = $this->isChildActive($items, $active);
                $items = $this->renderDropdown($items, $item);
            }
        }

        Html::addCssClass($options, 'nav-item');
        Html::addCssClass($linkOptions, 'nav-link');

        if ($disabled) {
            ArrayHelper::setValue($linkOptions, 'tabindex', '-1');
            ArrayHelper::setValue($linkOptions, 'aria-disabled', 'true');
            Html::addCssClass($linkOptions, 'disabled');
        } elseif ($this->activateItems && $active) {
            Html::addCssClass($linkOptions, 'active');
        }

        return Html::tag('li', Html::a($label, $url, $linkOptions) . $items, $options);
    }

    /**
     * Renders the given items as a dropdown.
     *
     * This method is called to create sub-menus.
     *
     * @param array $items the given items. Please refer to {@see Dropdown::items} for the array structure.
     * @param array $parentItem the parent item information. Please refer to {@see items} for the structure of this
     * array.
     *
     * @return string the rendering result.
     */
    protected function renderDropdown(array $items, array $parentItem): string
    {
        $dropdownClass = $this->dropdownClass;

        return $dropdownClass::widget()
            ->enableClientOptions(false)
            ->encodeLabels($this->encodeLabels)
            ->items($items)
            ->options(ArrayHelper::getValue($parentItem, 'dropdownOptions', []))
            ->render();
    }

    /**
     * Check to see if a child item is active optionally activating the parent.
     *
     * @param array $items
     * @param bool $active should the parent be active too
     *
     * @return array
     *
     * {@see items}
     */
    protected function isChildActive(array $items, bool &$active): array
    {
        foreach ($items as $i => $child) {
            if (is_array($child) && !ArrayHelper::getValue($child, 'visible', true)) {
                continue;
            }

            if ($this->isItemActive($child)) {
                ArrayHelper::setValue($items[$i], 'active', true);
                if ($this->activateParents) {
                    $active = true;
                }
            }

            if (is_array($child) && ($childItems = ArrayHelper::getValue($child, 'items')) && is_array($childItems)) {
                $activeParent = false;
                $items[$i]['items'] = $this->isChildActive($childItems, $activeParent);

                if ($activeParent) {
                    $items[$i]['options'] ??= [];
                    Html::addCssClass($items[$i]['options'], 'active');
                    $active = true;
                }
            }
        }

        return $items;
    }

    /**
     * Checks whether a menu item is active.
     *
     * This is done by checking if {@see currentPath} match that specified in the `url` option of the menu item. When
     * the `url` option of a menu item is specified in terms of an array, its first element is treated as the
     * currentPath for the item and the rest of the elements are the associated parameters. Only when its currentPath
     * and parameters match {@see currentPath}, respectively, will a menu item be considered active.
     *
     * @param array|string $item the menu item to be checked
     *
     * @return bool whether the menu item is active
     */
    protected function isItemActive($item): bool
    {
        if (isset($item['active'])) {
            return ArrayHelper::getValue($item, 'active', false);
        }

        return (bool) (isset($item['url']) && $this->currentPath !== '/' && $item['url'] === $this->currentPath && $this->activateItems)



         ;
    }

    /**
     * List of items in the nav widget. Each array element represents a single  menu item which can be either a string
     * or an array with the following structure:
     *
     * - label: string, required, the nav item label.
     * - url: optional, the item's URL. Defaults to "#".
     * - visible: bool, optional, whether this menu item is visible. Defaults to true.
     * - linkOptions: array, optional, the HTML attributes of the item's link.
     * - options: array, optional, the HTML attributes of the item container (LI).
     * - active: bool, optional, whether the item should be on active state or not.
     * - dropdownOptions: array, optional, the HTML options that will passed to the {@see Dropdown} widget.
     * - items: array|string, optional, the configuration array for creating a {@see Dropdown} widget, or a string
     *   representing the dropdown menu. Note that Bootstrap does not support sub-dropdown menus.
     * - encode: bool, optional, whether the label will be HTML-encoded. If set, supersedes the $encodeLabels option for
     *   only this item.
     *
     * If a menu item is a string, it will be rendered directly without HTML encoding.
     *
     * @param array $value
     *
     * @return $this
     */
    public function items(array $value): self
    {
        $this->items = $value;

        return $this;
    }

    /**
     * Whether the nav items labels should be HTML-encoded.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function encodeLabels(bool $value): self
    {
        $this->encodeLabels = $value;

        return $this;
    }

    public function label(string $value): self
    {
        $this->label = $value;

        return $this;
    }

    /**
     * Whether to automatically activate items according to whether their currentPath matches the currently requested.
     *
     * @param bool $value
     *
     * @return $this
     *
     * {@see isItemActive}
     */
    public function activateItems(bool $value): self
    {
        $this->activateItems = $value;

        return $this;
    }

    /**
     * Whether to activate parent menu items when one of the corresponding child menu items is active.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function activateParents(bool $value): self
    {
        $this->activateParents = $value;

        return $this;
    }

    /**
     * Allows you to assign the current path of the url from request controller.
     *
     * @param string|null $value
     *
     * @return $this
     */
    public function currentPath(?string $value): self
    {
        $this->currentPath = $value;

        return $this;
    }

    /**
     * The parameters used to determine if a menu item is active or not. If not set, it will use `$_GET`.
     *
     * @param array $value
     *
     * @return $this
     *
     * {@see currentPath}
     * {@see isItemActive}
     */
    public function params(array $value): self
    {
        $this->params = $value;

        return $this;
    }

    /**
     * Name of a class to use for rendering dropdowns within this widget. Defaults to {@see Dropdown}.
     *
     * @param string $value
     *
     * @return $this
     */
    public function dropdownClass(string $value): self
    {
        $this->dropdownClass = $value;

        return $this;
    }

    /**
     * The HTML attributes for the widget container tag. The following special options are recognized.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return $this
     */
    public function options(array $value): self
    {
        $this->options = $value;

        return $this;
    }
}

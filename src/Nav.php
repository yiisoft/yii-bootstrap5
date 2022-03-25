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
 *    $menuItems = [
 *        [
 *            'label' => 'About',
 *            'url' => '/about',
 *        ],
 *        [
 *            'label' => 'Contact',
 *            'url' => '/contact',
 *        ],
 *        [
 *            'label' => 'Login',
 *            'url' => '/login',
 *            'visible' => $user->getId() === null,
 *        ],
 *        [
 *            'label' => 'Logout' . ' ' . '(' . $user->getUsername() . ')',
 *            'url' => '/logout',
 *            'visible' => $user->getId() !== null,
 *        ],
 *    ];
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
final class Nav extends Widget
{
    private array $items = [];
    private bool $encodeLabels = true;
    private bool $encodeTags = false;
    private bool $activateItems = true;
    private bool $activateParents = false;
    private ?string $activeClass = null;
    private string $currentPath = '';
    private string $dropdownClass = Dropdown::class;
    private array $options = [];
    private array $itemOptions = [];
    private array $linkOptions = [];
    private array $dropdownOptions = [];

    protected function run(): string
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-nav";
        }

        Html::addCssClass($this->options, ['widget' => 'nav']);

        return $this->renderItems();
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
     * @return self
     */
    public function items(array $value): self
    {
        $new = clone $this;
        $new->items = $value;

        return $new;
    }

    /**
     * When tags Labels HTML should not be encoded.
     *
     * @return self
     */
    public function withoutEncodeLabels(): self
    {
        $new = clone $this;
        $new->encodeLabels = false;

        return $new;
    }

    /**
     * Disable activate items according to whether their currentPath.
     *
     * @return self
     *
     * {@see isItemActive}
     */
    public function withoutActivateItems(): self
    {
        $new = clone $this;
        $new->activateItems = false;

        return $new;
    }

    /**
     * Whether to activate parent menu items when one of the corresponding child menu items is active.
     *
     * @return self
     */
    public function activateParents(): self
    {
        $new = clone $this;
        $new->activateParents = true;

        return $new;
    }

    /**
     * Additional CSS class for active item. Like "bg-success", "bg-primary" etc
     *
     * @param string|null $className
     *
     * @return self
     */
    public function activeClass(?string $className): self
    {
        if ($this->activeClass === $className) {
            return $this;
        }

        $new = clone $this;
        $new->activeClass = $className;

        return $new;
    }

    /**
     * Allows you to assign the current path of the url from request controller.
     *
     * @param string $value
     *
     * @return self
     */
    public function currentPath(string $value): self
    {
        $new = clone $this;
        $new->currentPath = $value;

        return $new;
    }

    /**
     * Name of a class to use for rendering dropdowns within this widget. Defaults to {@see Dropdown}.
     *
     * @param string $value
     *
     * @return self
     */
    public function dropdownClass(string $value): self
    {
        $new = clone $this;
        $new->dropdownClass = $value;

        return $new;
    }

    /**
     * Options for dropdownClass if not present in current item
     *
     * {@see Nav::renderDropdown()} for details on how this options will be used
     *
     * @param array $options
     *
     * @return self
     */
    public function dropdownOptions(array $options): self
    {
        $new = clone $this;
        $new->dropdownOptions = $options;

        return $new;
    }

    /**
     * The HTML attributes for the widget container tag. The following special options are recognized.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return self
     */
    public function options(array $value): self
    {
        $new = clone $this;
        $new->options = $value;

        return $new;
    }

    /**
     * Options for each item if not present in self
     *
     * @param array $options
     *
     * @return self
     */
    public function itemOptions(array $options): self
    {
        $new = clone $this;
        $new->itemOptions = $options;

        return $new;
    }

    /**
     * Options for each item link if not present in current item
     *
     * @param array $options
     *
     * @return self
     */
    public function linkOptions(array $options): self
    {
        $new = clone $this;
        $new->linkOptions = $options;

        return $new;
    }

    /**
     * Renders widget items.
     *
     * @throws JsonException|RuntimeException
     *
     * @return string
     */
    private function renderItems(): string
    {
        $items = [];

        foreach ($this->items as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }

            $items[] = $this->renderItem($item);
        }

        return Html::tag('ul', implode("\n", $items), $this->options)
            ->encode($this->encodeTags)
            ->render();
    }

    /**
     * Renders a widget's item.
     *
     * @param array|string $item the item to render.
     *
     * @throws JsonException|RuntimeException
     *
     * @return string the rendering result.
     */
    private function renderItem($item): string
    {
        if (is_string($item)) {
            return $item;
        }

        if (!isset($item['label'])) {
            throw new RuntimeException("The 'label' option is required.");
        }

        $encodeLabel = $item['encode'] ?? $this->encodeLabels;
        $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
        $options = ArrayHelper::getValue($item, 'options', $this->itemOptions);
        $items = ArrayHelper::getValue($item, 'items');
        $url = ArrayHelper::getValue($item, 'url', '#');
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', $this->linkOptions);
        $disabled = ArrayHelper::getValue($item, 'disabled', false);
        $active = $this->isItemActive($item);

        if (empty($items)) {
            $items = '';
        } else {
            $linkOptions['data-bs-toggle'] = 'dropdown';

            Html::addCssClass($options, ['widget' => 'dropdown']);
            Html::addCssClass($linkOptions, ['widget' => 'dropdown-toggle']);

            if (is_array($items)) {
                $items = $this->isChildActive($items, $active);
                $items = $this->renderDropdown($items, $item);
            }
        }

        Html::addCssClass($options, ['nav' => 'nav-item']);
        Html::addCssClass($linkOptions, ['linkOptions' => 'nav-link']);

        if ($disabled) {
            $linkOptions['tabindex'] = '-1';
            $linkOptions['aria-disabled'] = 'true';
            Html::addCssClass($linkOptions, ['disabled' => 'disabled']);
        } elseif ($this->activateItems && $active) {
            Html::addCssClass($linkOptions, ['active' => rtrim('active ' . $this->activeClass)]);
        }

        return Html::tag(
            'li',
            Html::a($label, $url, $linkOptions)->encode($this->encodeTags) . $items,
            $options
        )->encode($this->encodeTags)->render();
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
    private function renderDropdown(array $items, array $parentItem): string
    {
        $dropdownClass = $this->dropdownClass;

        $dropdown = $dropdownClass::widget()
            ->items($items)
            ->options(ArrayHelper::getValue($parentItem, 'dropdownOptions', $this->dropdownOptions));

        if ($this->encodeLabels === false) {
            $dropdown->withoutEncodeLabels();
        }

        return $dropdown->render();
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
    private function isChildActive(array $items, bool &$active): array
    {
        foreach ($items as $i => $child) {
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
                    $items[$i]['linkOptions'] ??= [];
                    Html::addCssClass($items[$i]['linkOptions'], ['active' => 'active']);
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
    private function isItemActive($item): bool
    {
        if (isset($item['active'])) {
            return ArrayHelper::getValue($item, 'active', false);
        }

        return isset($item['url'])
            && $this->currentPath !== '/'
            && $item['url'] === $this->currentPath
            && $this->activateItems;
    }
}

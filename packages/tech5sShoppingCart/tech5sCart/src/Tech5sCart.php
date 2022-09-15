<?php
namespace Tech5sShoppingCart\Tech5sCart;
use Carbon\Carbon;
use Closure;
use Tech5sShoppingCart\Tech5sCart\Contracts\Buyable;
use Tech5sShoppingCart\Tech5sCart\Exceptions\CartAlreadyStoredException;
use Tech5sShoppingCart\Tech5sCart\Exceptions\InvalidRowIDException;
use Tech5sShoppingCart\Tech5sCart\Exceptions\UnknownModelException;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\DatabaseManager;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;
class Tech5sCart
{
    use Macroable;
    const DEFAULT_INSTANCE = 'default';
    const SESSION_IDENTIFIER_KEY = 'tech5sCart.identifier';

    /**
     * Instance of the session manager.
     *
     * @var \Illuminate\Session\SessionManager
     */
    private $session;
    /**
     * Instance of the event dispatcher.
     *
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    private $events;
    /**
     * Holds the current cart identifier.
     *
     * @var string
     */
    private $instance;
    /**
     * Holds the creation date of the tech5sCart.
     *
     * @var mixed
     */
    private $created_at;
    /**
     * Holds the update date of the tech5sCart.
     *
     * @var mixed
     */
    private $updated_at;
    /**
     * Defines the discount percentage.
     *
     * @var float
     */
    private $discount = 0;
    /**
     * Defines the tax rate.
     *
     * @var float
     */
    private $taxRate = 0;
    /**
     * Cart constructor.
     *
     * @param \Illuminate\Session\SessionManager      $session
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     */
    public function __construct(SessionManager $session, Dispatcher $events)
    {
        $this->session = $session;
        $this->events = $events;
        $this->taxRate = config('tech5sCart.tax');
        $this->instance(self::DEFAULT_INSTANCE);
    }
    /**
     * Set the current cart instance.
     *
     * @param string|null $instance
     *
     * @return \Tech5sShoppingCart\Tech5sCart\Cart
     */
    public function instance($instance = null)
    {
        $instance = $instance ?: self::DEFAULT_INSTANCE;
        $this->instance = 'tech5sCart.'.$instance;
        return $this;
    }

    /**
     * Set the current cart identifier.
     *
     * @param string|null $instance
     *
     * @return \Tech5sShoppingCart\Tech5sCart\Cart
     */
    public function identifier($identifier = null)
    {
        $this->session->put(self::SESSION_IDENTIFIER_KEY,$identifier);
        return $this;
    }

    /**
     * Get the current cart identifier.
     *
     * @return string
     */
    public function currentIdentifier()
    {
        return $this->session->get(self::SESSION_IDENTIFIER_KEY);
    }
    /**
     * Get the current cart instance.
     *
     * @return string
     */
    public function currentInstance()
    {
        return str_replace('tech5sCart.', '', $this->instance);
    }
    /**
     * Add an item to the tech5sCart.
     *
     * @param mixed     $id
     * @param mixed     $name
     * @param int|float $qty
     * @param float     $price
     * @param float     $weight
     * @param array     $options
     *
     * @return \Tech5sShoppingCart\Tech5sCart\CartItem
     */
    public function add($id, $name = null, $qty = null, $price = null, $weight = 0, array $options = [])
    {
        if ($this->isMulti($id)) {
            return array_map(function ($item) {
                return $this->add($item);
            }, $id);
        }
        $cartItem = $this->createCartItem($id, $name, $qty, $price, $weight, $options);
        return $this->addCartItem($cartItem);
    }
    /**
     * Add an item to the tech5sCart.
     *
     * @param \Tech5sShoppingCart\Tech5sCart\CartItem $item          Item to add to the Cart
     * @param bool                              $keepDiscount  Keep the discount rate of the Item
     * @param bool                              $keepTax       Keep the Tax rate of the Item
     * @param bool                              $dispatchEvent
     *
     * @return \Tech5sShoppingCart\Tech5sCart\CartItem The CartItem
     */
    public function addCartItem($item, $keepDiscount = false, $keepTax = false, $dispatchEvent = true)
    {
        if (!$keepDiscount) {
            $item->setDiscountRate($this->discount);
        }
        if (!$keepTax) {
            $item->setTaxRate($this->taxRate);
        }
        $content = $this->getContent();
        if ($content->has($item->rowId)) {
            $item->qty += $content->get($item->rowId)->qty;
        }
        $content->put($item->rowId, $item);
        if ($dispatchEvent) {
            $this->events->dispatch('tech5sCart.adding', $item);
        }
        $this->session->put($this->instance, $content);
        if ($dispatchEvent) {
            $this->events->dispatch('tech5sCart.added', $item);
        }
        $this->store();
        return $item;
    }
    /**
     * Update the cart item with the given rowId.
     *
     * @param string $rowId
     * @param mixed  $qty
     *
     * @return \Tech5sShoppingCart\Tech5sCart\CartItem
     */
    public function update($rowId, $qty , $isStore = true)    {
        $cartItem = $this->get($rowId);
        if ($qty instanceof Buyable) {
            $cartItem->updateFromBuyable($qty);
        } elseif (is_array($qty)) {
            $cartItem->updateFromArray($qty);
        } else {
            $cartItem->qty = $qty;
        }
        $content = $this->getContent();
        if ($rowId !== $cartItem->rowId) {
            $itemOldIndex = $content->keys()->search($rowId);
            $content->pull($rowId);
            if ($content->has($cartItem->rowId)) {
                $existingCartItem = $this->get($cartItem->rowId);
                $cartItem->setQuantity($existingCartItem->qty + $cartItem->qty);
            }
        }
        if ($cartItem->qty <= 0) {
            $this->remove($cartItem->rowId);
            return;
        } else {
            if (isset($itemOldIndex)) {
                $content = $content->slice(0, $itemOldIndex)
                    ->merge([$cartItem->rowId => $cartItem])
                    ->merge($content->slice($itemOldIndex));
            } else {
                $content->put($cartItem->rowId, $cartItem);
            }
        }
        $this->events->dispatch('tech5sCart.updating', $cartItem);
        $this->session->put($this->instance, $content);
        $this->events->dispatch('tech5sCart.updated', $cartItem);
        if ($isStore) {
            $this->store(); 
        }
        return $cartItem;
    }
    /**
     * Remove the cart item with the given rowId from the tech5sCart.
     *
     * @param string $rowId
     *
     * @return void
     */
    public function remove($rowId)
    {
        $cartItem = $this->get($rowId);
        $content = $this->getContent();
        $content->pull($cartItem->rowId);
        $this->events->dispatch('tech5sCart.removing', $cartItem);
        $this->session->put($this->instance, $content);
        $this->events->dispatch('tech5sCart.removed', $cartItem);
        $this->store(); 
    }
    /**
     * Get a cart item from the cart by its rowId.
     *
     * @param string $rowId
     *
     * @return \Tech5sShoppingCart\Tech5sCart\CartItem
     */
    public function get($rowId)
    {
        $content = $this->getContent();
        if (!$content->has($rowId)) {
            throw new InvalidRowIDException("The cart does not contain rowId {$rowId}.");
        }
        return $content->get($rowId);
    }
    /**
     * Destroy the current cart instance.
     *
     * @return void
     */
    public function destroy()
    {
        $this->session->remove($this->instance);
        $identifier = $this->currentIdentifier();
        if (!isset($identifier)) return;
        $this->getConnection()->table($this->getTableName())->where('identifier',$identifier)->where('instance',$this->currentInstance())->delete();
    }
    /**
     * Get the content of the tech5sCart.
     *
     * @return \Illuminate\Support\Collection
     */
    public function content()
    {
        if (is_null($this->session->get($this->instance))) {
            return new Collection([]);
        }
        return $this->session->get($this->instance);
    }
    /**
     * Get the total quantity of all CartItems in the tech5sCart.
     *
     * @return int|float
     */
    public function count()
    {
        return $this->getContent()->sum('qty');
    }
    /**
     * Get the amount of CartItems in the Cart.
     * Keep in mind that this does NOT count quantity.
     *
     * @return int|float
     */
    public function countItems()
    {
        return $this->getContent()->count();
    }
    /**
     * Get the total price of the items in the tech5sCart.
     *
     * @return float
     */
    public function totalFloat()
    {
        return $this->getContent()->reduce(function ($total, CartItem $cartItem) {
            return $total + $cartItem->total;
        }, 0);
    }
    /**
     * Get the total price of the items in the cart as formatted string.
     *
     * @param int    $decimals
     * @param string $decimalPoint
     * @param string $thousandSeperator
     *
     * @return string
     */
    public function total($decimals = null, $decimalPoint = null, $thousandSeperator = null)
    {
        return $this->numberFormat($this->totalFloat(), $decimals, $decimalPoint, $thousandSeperator);
    }
    /**
     * Get the total tax of the items in the tech5sCart.
     *
     * @return float
     */
    public function taxFloat()
    {
        return $this->getContent()->reduce(function ($tax, CartItem $cartItem) {
            return $tax + $cartItem->taxTotal;
        }, 0);
    }
    /**
     * Get the total tax of the items in the cart as formatted string.
     *
     * @param int    $decimals
     * @param string $decimalPoint
     * @param string $thousandSeperator
     *
     * @return string
     */
    public function tax($decimals = null, $decimalPoint = null, $thousandSeperator = null)
    {
        return $this->numberFormat($this->taxFloat(), $decimals, $decimalPoint, $thousandSeperator);
    }
    /**
     * Get the subtotal (total - tax) of the items in the tech5sCart.
     *
     * @return float
     */
    public function subtotalFloat()
    {
        return $this->getContent()->reduce(function ($subTotal, CartItem $cartItem) {
            return $subTotal + $cartItem->subtotal;
        }, 0);
    }
    /**
     * Get the subtotal (total - tax) of the items in the cart as formatted string.
     *
     * @param int    $decimals
     * @param string $decimalPoint
     * @param string $thousandSeperator
     *
     * @return string
     */
    public function subtotal($decimals = null, $decimalPoint = null, $thousandSeperator = null)
    {
        return $this->numberFormat($this->subtotalFloat(), $decimals, $decimalPoint, $thousandSeperator);
    }
    /**
     * Get the discount of the items in the tech5sCart.
     *
     * @return float
     */
    public function discountFloat()
    {
        return $this->getContent()->reduce(function ($discount, CartItem $cartItem) {
            return $discount + $cartItem->discountTotal;
        }, 0);
    }
    /**
     * Get the discount of the items in the cart as formatted string.
     *
     * @param int    $decimals
     * @param string $decimalPoint
     * @param string $thousandSeperator
     *
     * @return string
     */
    public function discount($decimals = null, $decimalPoint = null, $thousandSeperator = null)
    {
        return $this->numberFormat($this->discountFloat(), $decimals, $decimalPoint, $thousandSeperator);
    }
    /**
     * Get the price of the items in the cart (not rounded).
     *
     * @return float
     */
    public function initialFloat()
    {
        return $this->getContent()->reduce(function ($initial, CartItem $cartItem) {
            return $initial + ($cartItem->qty * $cartItem->price);
        }, 0);
    }
    /**
     * Get the price of the items in the cart as formatted string.
     *
     * @param int    $decimals
     * @param string $decimalPoint
     * @param string $thousandSeperator
     *
     * @return string
     */
    public function initial($decimals = null, $decimalPoint = null, $thousandSeperator = null)
    {
        return $this->numberFormat($this->initialFloat(), $decimals, $decimalPoint, $thousandSeperator);
    }
    /**
     * Get the price of the items in the cart (previously rounded).
     *
     * @return float
     */
    public function priceTotalFloat()
    {
        return $this->getContent()->reduce(function ($initial, CartItem $cartItem) {
            return $initial + $cartItem->priceTotal;
        }, 0);
    }
    /**
     * Get the price of the items in the cart as formatted string.
     *
     * @param int    $decimals
     * @param string $decimalPoint
     * @param string $thousandSeperator
     *
     * @return string
     */
    public function priceTotal($decimals = null, $decimalPoint = null, $thousandSeperator = null)
    {
        return $this->numberFormat($this->priceTotalFloat(), $decimals, $decimalPoint, $thousandSeperator);
    }
    /**
     * Get the total weight of the items in the tech5sCart.
     *
     * @return float
     */
    public function weightFloat()
    {
        return $this->getContent()->reduce(function ($total, CartItem $cartItem) {
            return $total + ($cartItem->qty * $cartItem->weight);
        }, 0);
    }
    /**
     * Get the total weight of the items in the tech5sCart.
     *
     * @param int    $decimals
     * @param string $decimalPoint
     * @param string $thousandSeperator
     *
     * @return string
     */
    public function weight($decimals = null, $decimalPoint = null, $thousandSeperator = null)
    {
        return $this->numberFormat($this->weightFloat(), $decimals, $decimalPoint, $thousandSeperator);
    }
    /**
     * Search the cart content for a cart item matching the given search closure.
     *
     * @param \Closure $search
     *
     * @return \Illuminate\Support\Collection
     */
    public function search(Closure $search)
    {
        return $this->getContent()->filter($search);
    }
    /**
     * Associate the cart item with the given rowId with the given model.
     *
     * @param string $rowId
     * @param mixed  $model
     *
     * @return void
     */
    public function associate($rowId, $model)
    {
        if (is_string($model) && !class_exists($model)) {
            throw new UnknownModelException("The supplied model {$model} does not exist.");
        }
        $cartItem = $this->get($rowId);
        $cartItem->associate($model);
        $content = $this->getContent();
        $content->put($cartItem->rowId, $cartItem);
        $this->session->put($this->instance, $content);
        $this->store();
    }
    /**
     * Set the tax rate for the cart item with the given rowId.
     *
     * @param string    $rowId
     * @param int|float $taxRate
     *
     * @return void
     */
    public function setTax($rowId, $taxRate)
    {
        $cartItem = $this->get($rowId);
        $cartItem->setTaxRate($taxRate);
        $content = $this->getContent();
        $content->put($cartItem->rowId, $cartItem);
        $this->session->put($this->instance, $content);
        $this->store();
    }
    /**
     * Set the global tax rate for the tech5sCart.
     * This will set the tax rate for all items.
     *
     * @param float $discount
     */
    public function setGlobalTax($taxRate)
    {
        $this->taxRate = $taxRate;
        $content = $this->getContent();
        if ($content && $content->count()) {
            $content->each(function ($item, $key) {
                $item->setTaxRate($this->taxRate);
            });
        }
    }
    /**
     * Set the discount rate for the cart item with the given rowId.
     *
     * @param string    $rowId
     * @param int|float $taxRate
     *
     * @return void
     */
    public function setDiscount($rowId, $discount)
    {
        $cartItem = $this->get($rowId);
        $cartItem->setDiscountRate($discount);
        $content = $this->getContent();
        $content->put($cartItem->rowId, $cartItem);
        $this->session->put($this->instance, $content);
        $this->store();
    }
    /**
     * Set the global discount percentage for the tech5sCart.
     * This will set the discount for all cart items.
     *
     * @param float $discount
     *
     * @return void
     */
    public function setGlobalDiscount($discount)
    {
        $this->discount = $discount;
        $content = $this->getContent();
        if ($content && $content->count()) {
            $content->each(function ($item, $key) {
                $item->setDiscountRate($this->discount);
            });
        }
    }
    /**
     * Store an the current instance of the tech5sCart.
     *
     * @param mixed $identifier
     *
     * @return void
     */
    public function store()
    {
        $content = $this->getContent();
        $identifier = $this->currentIdentifier();
        if (!isset($identifier)) return;
        $instance = $this->currentInstance();
        $idCartStored = 0;
        if (!$this->storedCartInstanceWithIdentifierExists($instance, $identifier)) {
            $dataCartDatabase = [
                'identifier'          => $identifier,
                'instance'         => $instance,
                'created_at'       => $this->created_at ?: Carbon::now(),
                'updated_at'       => Carbon::now(),
            ];
            $idCartStored = $this->getConnection()->table($this->getTableName())->insertGetId($dataCartDatabase);
        }else{
            $stored = $this->getConnection()->table($this->getTableName())->where('identifier',$identifier)->where('instance',$instance)->first();
            $idCartStored = $stored->id;
            $this->getConnection()->table($this->getTableName())->where('identifier',$identifier)->where('instance',$instance)->update(['updated_at'=>now()]);

        }
        $arrRowIdCurrent = [];
        foreach ($this->content() as $itemCart) {
            array_push($arrRowIdCurrent, $itemCart->rowId);
            $dataCart['associatedId'] = $itemCart->id;
            $dataCart['name'] = $itemCart->name;
            $dataCart['price'] = $itemCart->price;
            $dataCart['weight'] = $itemCart->weight;
            $dataCart['options'] = $itemCart->options->toJson();
            $dataCart['qty'] = $itemCart->qty;
            $dataCart['taxRate'] = $itemCart->taxRate;
            $dataCart['associatedModel'] = $itemCart->associatedModel;
            $dataCart['discountRate'] = $itemCart->discountRate;
            $dataCart['created_at'] = now();
            $dataCart['updated_at'] = now();
            $this->getConnection()->table($this->getTableItemName())->updateOrInsert(['tech5s_cart_id'=>$idCartStored,'row_id'=>$itemCart->rowId],$dataCart);
        }
        $this->getConnection()->table($this->getTableItemName())->where('tech5s_cart_id',$idCartStored)->whereNotIn('row_id',$arrRowIdCurrent)->delete();
        $this->events->dispatch('tech5sCart.stored');
    }
    /**
     * Restore the cart with the given identifier.
     *
     * @param mixed $identifier
     *
     * @return void
     */
    public function restore($identifier)
    {
        $this->identifier($identifier);
        $storeds = $this->getConnection()->table($this->getTableName())
            ->where('identifier',$identifier)->orderBy('updated_at','asc')->get();
        foreach ($storeds as $key => $itemStored) {
            $mergeOnRestore = config('tech5sCart.database.merge_current_on_restore');
            $this->instance($itemStored->instance);
            if ($mergeOnRestore) {
                $content = $this->getContent();
            }else{
                $content = new Collection();
            }
            $listItemCart = $this->getConnection()->table($this->getTableItemName())->where('tech5s_cart_id',$itemStored->id)->get();
            foreach ($listItemCart as $key => $itemDb) {
                $model = null;
                if ($itemDb->associatedModel != null) {
                    $model = $itemDb->associatedModel::select($itemDb->associatedModel::FIELD_SELECT_FOR_ADDCART)
                    ->where('id', $itemDb->associatedId)
                    ->first();
                }
                $cartItem = $this->createCartItem($itemDb->associatedId,$itemDb->name,$itemDb->qty,$itemDb->price,$itemDb->weight,\Support::extractJson($itemDb->options));
                if ($model != null) {
                    $cartItem->associate($itemDb->associatedModel);
                }
                $itemOldIndex = $content->keys()->search($cartItem->rowId);
                if (is_numeric($itemOldIndex)) {
                    $currentItem = $this->get($cartItem->rowId);
                    $currentItem->qty += $cartItem->qty;
                    $content->put($currentItem->rowId, $currentItem);
                }else{
                    $content->put($cartItem->rowId, $cartItem);
                }
            }
            $this->session->put($this->instance, $content);
            if ($key+1 == count($storeds)) {
                $this->created_at = $itemStored->created_at;
                $this->updated_at = $itemStored->updated_at;
            }
        }
        $this->events->dispatch('tech5sCart.restored');
        $this->store();
    }
    /**
     * Erase the cart with the given identifier.
     *
     * @param mixed $identifier
     *
     * @return void
     */
    public function erase($identifier)
    {
        $instance = $this->currentInstance();
        if (!$this->storedCartInstanceWithIdentifierExists($instance, $identifier)) {
            return;
        }
        $this->getConnection()->table($this->getTableName())->where(['identifier' => $identifier, 'instance' => $instance])->delete();
        $this->events->dispatch('tech5sCart.erased');
    }
    /**
     * Merges the contents of another cart into this tech5sCart.
     *
     * @param mixed $identifier   Identifier of the Cart to merge with.
     * @param bool  $keepDiscount Keep the discount of the CartItems.
     * @param bool  $keepTax      Keep the tax of the CartItems.
     * @param bool  $dispatchAdd  Flag to dispatch the add events.
     *
     * @return bool
     */
    public function merge($identifier, $keepDiscount = false, $keepTax = false, $dispatchAdd = true, $instance = self::DEFAULT_INSTANCE)
    {
        if (!$this->storedCartInstanceWithIdentifierExists($instance, $identifier)) {
            return false;
        }
        $stored = $this->getConnection()->table($this->getTableName())
            ->where(['identifier'=> $identifier, 'instance'=> $instance])->first();
        $storedContent = unserialize($stored->content);
        foreach ($storedContent as $cartItem) {
            $this->addCartItem($cartItem, $keepDiscount, $keepTax, $dispatchAdd);
        }
        $this->events->dispatch('tech5sCart.merged');
        return true;
    }
    /**
     * Magic method to make accessing the total, tax and subtotal properties possible.
     *
     * @param string $attribute
     *
     * @return float|null
     */
    public function __get($attribute)
    {
        switch ($attribute) {
            case 'total':
                return $this->total();
            case 'tax':
                return $this->tax();
            case 'subtotal':
                return $this->subtotal();
            default:
                return;
        }
    }
    /**
     * Get the carts content, if there is no cart content set yet, return a new empty Collection.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getContent()
    {
        if ($this->session->has($this->instance)) {
            return $this->session->get($this->instance);
        }
        return new Collection();
    }
    /**
     * Create a new CartItem from the supplied attributes.
     *
     * @param mixed     $id
     * @param mixed     $name
     * @param int|float $qty
     * @param float     $price
     * @param float     $weight
     * @param array     $options
     *
     * @return \Tech5sShoppingCart\Tech5sCart\CartItem
     */
    private function createCartItem($id, $name, $qty, $price, $weight, array $options)
    {
        if ($id instanceof Buyable) {
            $cartItem = CartItem::fromBuyable($id, $qty ?: []);
            $cartItem->setQuantity($name ?: 1);
            $cartItem->associate($id);
        } elseif (is_array($id)) {
            $cartItem = CartItem::fromArray($id);
            $cartItem->setQuantity($id['qty']);
        } else {
            $cartItem = CartItem::fromAttributes($id, $name, $price, $weight, $options);
            $cartItem->setQuantity($qty);
        }
        return $cartItem;
    }
    /**
     * Check if the item is a multidimensional array or an array of Buyables.
     *
     * @param mixed $item
     *
     * @return bool
     */
    private function isMulti($item)
    {
        if (!is_array($item)) {
            return false;
        }
        return is_array(head($item)) || head($item) instanceof Buyable;
    }
    /**
     * @param $identifier
     *
     * @return bool
     */
    private function storedCartInstanceWithIdentifierExists($instance, $identifier)
    {
        return $this->getConnection()->table($this->getTableName())->where(['identifier' => $identifier, 'instance'=> $instance])->exists();
    }
    /**
     * Get the database connection.
     *
     * @return \Illuminate\Database\Connection
     */
    private function getConnection()
    {
        return app(DatabaseManager::class)->connection($this->getConnectionName());
    }
    /**
     * Get the database table name.
     *
     * @return string
     */
    private function getTableName()
    {
        return config('tech5sCart.database.table', 'tech5s_carts');
    }
    /**
     * Get the database table item name.
     *
     * @return string
     */
    private function getTableItemName()
    {
        return config('tech5sCart.database.table_item', 'tech5s_cart_items');
    }
    /**
     * Get the database connection name.
     *
     * @return string
     */
    private function getConnectionName()
    {
        $connection = config('tech5sCart.database.connection');
        return is_null($connection) ? config('database.default') : $connection;
    }
    /**
     * Get the Formatted number.
     *
     * @param $value
     * @param $decimals
     * @param $decimalPoint
     * @param $thousandSeperator
     *
     * @return string
     */
    private function numberFormat($value, $decimals, $decimalPoint, $thousandSeperator)
    {
        if (is_null($decimals)) {
            $decimals = config('tech5sCart.format.decimals', 2);
        }
        if (is_null($decimalPoint)) {
            $decimalPoint = config('tech5sCart.format.decimal_point', '.');
        }
        if (is_null($thousandSeperator)) {
            $thousandSeperator = config('tech5sCart.format.thousand_separator', ',');
        }
        return number_format($value, $decimals, $decimalPoint, $thousandSeperator);
    }
    /**
     * Get the creation date of the cart (db context).
     *
     * @return \Carbon\Carbon|null
     */
    public function created_at()
    {
        return $this->created_at;
    }
    /**
     * Get the lats update date of the cart (db context).
     *
     * @return \Carbon\Carbon|null
     */
    public function updated_at()
    {
        return $this->updated_at;
    }
}

<?php

namespace Tech5sShoppingCart\Tech5sCart\Contracts;

use Tech5sShoppingCart\Tech5sCart\CartItem;

interface Calculator
{
    public static function getAttribute(string $attribute, CartItem $cartItem);
}

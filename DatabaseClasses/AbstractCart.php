<?php

/***Class primarly used to render user selected products in cart***/
abstract class AbstractCart
{

    abstract static function showCart();
    abstract static function showCartConfirmation();
}

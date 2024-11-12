<?php

abstract class MenuItem
{
    protected string $foodName;
    protected float $price;

    protected function __construct(string $foodName, float $price)
    {
        $this->foodName = $foodName;
        $this->price = $price;
    }

    public function getFoodName()
    {
        return $this->foodName;
    }
}

class Appetizer extends MenuItem
{
    public function __construct(string $foodName, float $price)
    {
        parent::__construct($foodName, $price);
    }
}

class MainCourse extends MenuItem
{
    public function __construct(string $foodName, float $price)
    {
        parent::__construct($foodName, $price);
    }
}

class Deserts extends MenuItem
{
    public function __construct(string $foodName, float $price)
    {
        parent::__construct($foodName, $price);
    }
}

class Restaurant
{
    private array $menu;

    public function __construct()
    {
        $this->menu = [];
    }

    public function addMenuItem(MenuItem $menuItem)
    {
        array_push($this->menu, $menuItem);
    }

    public function getMenuItemByName(string $foodName)
    {
        foreach ($this->menu as $item) {
            if ($item->getFoodName() === $foodName) {
                return $item;
            }
        }
        return null;
    }
}

class Customer
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}

class Order
{
    public Customer $customer;
    public Restaurant $restaurant;
    private array $items;

    public function __construct(Customer $customer, Restaurant $restaurant)
    {
        $this->customer = $customer;
        $this->restaurant = $restaurant;
        $this->items = [];
    }

    public function addItem(string $foodName)
    {
        $menuItem = $this->restaurant->getMenuItemByName($foodName);

        array_push($this->items, $menuItem);
    }

    public function deliver()
    {
        print("Your order for");
        foreach ($this->items as $item) {
            $name = $item->getFoodName();
            print(" '$name'");
        }
        print(" is on its way!!\n");
    }
}

$customer = new Customer("Jahid");

$restaurant = new Restaurant();

$restaurant->addMenuItem(new MainCourse("Burger", 10.99));

$order = new Order($customer, $restaurant);

$order->addItem("Burger");
$order->deliver();

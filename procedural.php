<?php

$inventory = [
    [ "name" => "Laptop", "variants" => [
            ["model" => "X123", "color" => "Silver", "size" => "15-inch", "quantity" => 5, "price" => 700],
            ["model" => "X124", "color" => "Black", "size" => "13-inch", "quantity" => 3, "price" => 650],
        ],
        "in_stock" => true,
    ],
    [
        "name" => "Mouse",
        "variants" => [
            ["model" => "M001", "color" => "Black", "size" => "Standard", "quantity" => 10, "price" => 25],
            ["model" => "M002", "color" => "White", "size" => "Compact", "quantity" => 5, "price" => 30],
        ],
        "in_stock" => true,
    ],
    [
        "name" => "Keyboard",
        "variants" => [
            ["model" => "K001", "color" => "Black", "size" => "Full", "quantity" => 0, "price" => 30],
            ["model" => "K002", "color" => "White", "size" => "Compact", "quantity" => 2, "price" => 28],
        ],
        "in_stock" => false,
    ],
    [
        "name" => "Monitor",
        "variants" => [
            ["model" => "M001", "color" => "Black", "size" => "24-inch", "quantity" => 2, "price" => 150],
            ["model" => "M002", "color" => "Silver", "size" => "27-inch", "quantity" => 4, "price" => 180],
        ],
        "in_stock" => true,
    ],
    [
        "name" => "USB Cable",
        "variants" => [
            ["model" => "U001", "color" => "Black", "size" => "1m", "quantity" => 15, "price" => 5],
            ["model" => "U002", "color" => "White", "size" => "2m", "quantity" => 20, "price" => 6],
        ],
        "in_stock" => true,
    ],
];

function checkStockStatus($inventory)
{
    foreach ($inventory as $product) {
        foreach ($product['variants'] as $v) {
            if ($v['quantity'] > 0) {
                print("{$product['name']} {$v['model']} {$v['color']} {$v['size']} is in stock with {$v['quantity']} units available\n");
            } else {
                print("{$product['name']} {$v['model']} {$v['color']} {$v['size']} is out of stock\n");
            }
        }
    }
    print PHP_EOL;
}

function calculateInventoryValue($inventory)
{
    $totalInventoryValue = 0;
    foreach ($inventory as $product) {
        foreach ($product['variants'] as $v) {
            $totalInventoryValue += $v['price'] * $v['quantity'];
        }
    }
    print("The total value of items in stock is $$totalInventoryValue\n\n");
}

function findLowStockVariants($inventory)
{
    $lowStockVariantsDetails = [];

    foreach ($inventory as $product) {
        foreach ($product['variants'] as $v) {
            if ($v['quantity'] < 5) {
                $details = "{$product['name']} {$v['model']} {$v['color']} {$v['size']} with {$v['quantity']} units";
                array_push($lowStockVariantsDetails, $details);
            }
        }
    }

    print("Low stock variants: \n");
    foreach ($lowStockVariantsDetails as $details) {
        print("- {$details}\n");
    }
    print PHP_EOL;
}

function increaseInventoryQuantities($inventory, $increaseAmount)
{
    foreach ($inventory as $product) {
        foreach ($product['variants'] as $v) {
            $v['quantity'] += $increaseAmount;
            print("{$product['name']} {$v['model']} {$v['color']} {$v['size']} now has {$v['quantity']}\n");
        }
    }
    print PHP_EOL;
}

function calculateAveragePricePerProduct($inventory)
{
    foreach ($inventory as $product) {
        $totalPrice = 0;
        $variantCount = 0;
        foreach ($product['variants'] as $v) {
            $totalPrice += $v['price'];
            $variantCount++;
        }
        $averagePrice = $totalPrice / $variantCount;
        print("The average of variants for {$product['name']} is \${$averagePrice}\n");
    }

    print PHP_EOL;
}

checkStockStatus($inventory);
calculateInventoryValue($inventory);
findLowStockVariants($inventory);
increaseInventoryQuantities($inventory, 2);
calculateAveragePricePerProduct($inventory);

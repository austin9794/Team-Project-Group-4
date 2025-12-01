<?php

class BasketController
{
    //show basket page nd work out totals

    public function index()
    {
        session_start();
        
        $items = [] ;
        $total = 0;

        //if basket isnt empty, build the items array
        if (!empty($_SESSION['basket'])) {
            $productModel = new Product();
            
            foreach ($_SESSION['basket'] as $id => $qty) {
                
                $product = $productModel->find($id);

                if ($product) {
                    $lineTotal = $product['price'] * $qty;

                    $items[] = [
                        'id'       => $id,
                        'name'     => $product['name'],
                        'price'    => $product['price'],
                        'quantity' => $qty,
                        'total'    => $lineTotal
                    ];

                    $total += $lineTotal;
                }
            }
        }

        //load basket page
        require __DIR__ . '/../../templates/customer/basket.php';
    }

    // add item to basket from product page
    public function add()
    {
        session_start();
        
        $productId = $_POST['product_id'] ?? null;


        //if for some reason no id came through just go back
        if ($productId === null) {
            header('Location: /products');
            exit;
        }
        
        if (!isset($_SESSION['basket'])) {
            $_SESSION['basket'] = [];
        }

        if (isset($_SESSION['basket'][$productId])) {
            $_SESSION['basket'][$productId]++;
        } else {
            $_SESSION['basket'][$productId] = 1;
        }

        header('Location: /products');
        exit;
    }

    //update quantity from basket page (or remove if 0 or less)
    public function update()
    {
        session_start();
        
        $productId = $_POST['product_id'] ?? null;
        $quantity  = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

        if ($productId === null) {
            header('Location: /basket');
            exit;
        }

        if ($quantity <= 0) {
            unset($_SESSION['basket'][$productId]);
        } else {
            $_SESSION['basket'][$productId] = $quantity;
        }

        header('Location: /basket');
        exit;
    }

    //completely remove item from basket
    public function remove()
    {
        session_start();
        
        $productId = $_POST['product_id'] ?? null;

        if ($productId !== null && isset($_SESSION['basket'][$productId])) {
            unset($_SESSION['basket'][$productId]);
        }
        
        header('Location: /basket');
        exit;
    }
}

?>
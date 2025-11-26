<?php

class OrderController
{
    //place order nd clear basket
    public function place()
    {
        session_start() ;

        //clear basket after order
         unset($_SESSION['basket']);

        echo 'order placed successfully';
     }
}

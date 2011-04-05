<?php
    require 'PetPurchase.php';
    optimizePurchase();

    function optimizePurchase() {
        set_time_limit(300);
        $result = PetPurchase::findMostFit(20000, 30);
        $result[0]->printMe();
        echo $result[1].' generations';
    }
?>


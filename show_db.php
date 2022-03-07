<?php

function display_table($table,$role){
    echo "<table>";
    echo "<tr class='table-heading'>";
    $num_field = pg_num_fields($table);
    for ($i=0;$i<$num_field;$i++){
        $field_name = pg_field_name($table,$i);
        if ($field_name == 'shop_name')
        echo "<th>Shop</th>";
    else if ($field_name == 'product_id')
        echo "<th>Product ID</th>";
    else if ($field_name == 'product_name')
        echo "<th>Product Name</th>";
    else if ($field_name == 'price')
        echo "<th>Price</th>";
    else echo "<th>Amount</th>";
    }
    //echo "<th></th><th></th>";
    
    echo "</tr>";

    if ($role != "director"){
        
        echo "<tr>";
        echo "<form action='' method='post'>";
        for ($i=0;$i<$num_field;$i++){
            $field_name = pg_field_name($table,$i);
            if ($field_name=='shop_name')
                echo "<td class='sticky'><input type='text' name=$field_name value=$role readonly></td>";
            else echo "<td class='sticky'><input type='text' name=$field_name></td>";
        }
        echo "<td class='sticky'> <input class='button' type='submit' value='Add' name='insert'></td><td class='sticky'></td>";
        echo "</form>";
        echo "</tr>";
    }
    $num_row=pg_num_rows($table);
    for ($j=0;$j<$num_row;$j++){
        $row=pg_fetch_array($table,$j);
        echo "<tr>";
        echo "<form action='' method='post'>";
        for ($i=0;$i<$num_field;$i++){
            $field_name = pg_field_name($table,$i);
            $field_value=$row[$field_name];
            if ($role == "director")
                echo "<td><input type='text' name=$field_name value=$field_value readonly></td>"; 
            else{
                if ($field_name=='product_id' || $field_name=='shop_name')
                echo "<td><input type='text' name=$field_name value=$field_value readonly></td>";
            else
                echo "<td><input type='text' name=$field_name value=$field_value></td>"; 
            }       
        }
        if ($role != "director"){
            echo "<td><input class='button' type='submit' value='Edit' name='edit'></td>";
            echo "<td><input class='button' type='submit' value='Delete' name='delete'></td>";
        }
        
        echo "</form>";
        echo "</tr>";
    }
    echo "</table>";
}

    ?>

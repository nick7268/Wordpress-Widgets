Les paso un widget para poder colocar el porcentaje de descuento de un producto de la siguiente manera, funciona para cualquier builder, yo lo he usado en oxygen y bricks

<?php
/**
 * show sale porcentage
 */

function show_sale_percentage_loop() {
	global $product;
	
	if (!isset($product) || !$product) {return;}

   
   if ( ! $product->is_on_sale() ) return;
	
   if ( $product->is_type( 'simple' ) ) {
      $max_percentage = ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100;
   } elseif ( $product->is_type( 'variable' ) ) {
      $max_percentage = 0;
      foreach ( $product->get_children() as $child_id ) {
         $variation = wc_get_product( $child_id );
         $price = $variation->get_regular_price();
         $sale = $variation->get_sale_price();
         if ( $price != 0 && ! empty( $sale ) ) $percentage = ( $price - $sale ) / $price * 100;
         if ( $percentage > $max_percentage ) {
            $max_percentage = $percentage;
         }
      }
   }
   if ( $max_percentage > 0 ) return '-' . round($max_percentage). '%';
}


// IN BRICKS BUILDER, add a code block and paste: 	echo show_sale_percentage_loop()
?>
Luego en el loop se agrega un modulo de código y se agrega esto 
<?php
    echo show_sale_percentage_loop()
?>

<?php 
function build_dropdown_category(){
  global $wp_query, $woocommerce;
  include_once( $woocommerce->plugin_path() . '/classes/walkers/class-product-cat-dropdown-walker.php' );

	$r = array();
	$r['pad_counts']    = 1;
	$r['hierarchical']  = 1;
	$r['hide_empty']    = 0;
	$r['show_count']    = 0;
	$r['exclude_tree'] = array(16,18,19);
	//$r['parent'] = array(16,18,19);
	//$r['selected'] = 'wow-stock';

	$terms = get_terms( 'product_cat', $r );

	$dropdown  = "<select name='product_cat' id='dropdown_product_cat'>";
	$dropdown .= '<option value="" ' .  selected( isset( $_GET['product_cat'] ) ? $_GET['product_cat'] : '', '', false ) . '>'.__( 'Select a category', 'woocommerce' ).'</option>';
	$dropdown .= woocommerce_walk_category_dropdown_tree( $terms, 0, $r );
	$dropdown .="</select>";
	return $dropdown;


}

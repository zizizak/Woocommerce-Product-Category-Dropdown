<?php

add_action("wp_ajax_woocommerce_cate_filter", "woocommerce_cate_filter");
add_action("wp_ajax_nopriv_woocommerce_cate_filter", "woocommerce_cate_filter");

function woocommerce_cate_filter(){
					$term_id = term_exists( $_POST['parent'], 'product_cat' );
					
					$r = array();
					$r['pad_counts']    = 1;
					$r['hierarchical']  = 1;
					$r['hide_empty']    = 0;
					$r['show_count']    = 0;
					$r['parent'] = $term_id['term_id'];
					$r['selected']      = ( isset( $wp_query->query['product_cat'] ) ) ? $wp_query->query['product_cat'] : '';

					$terms = get_terms( 'product_cat', $r );

					$dropdown  = "<select name='product_cat' id='dropdown_product_cat'  onclick='dropdown_change(this)'>";
					$dropdown .= '<option value="" ' .  selected( isset( $_GET['product_cat'] ) ? $_GET['product_cat'] : '', '', false ) . '>'.__( 'Select a sub category', 'woocommerce' ).'</option>';
					$dropdown .= woocommerce_walk_category_dropdown_tree( $terms, 0, $r );
					$dropdown .="</select>";

					echo $dropdown;
					die;

}



add_action('woocommerce_before_shop_loop', 'woocommerce_category_filter_1',100);

//add new options to $sortby var passed into filter
function woocommerce_category_filter_1() {
    
    				global $wp_query, $woocommerce;
				   //include_once( $woocommerce->plugin_path() . '/classes/walkers/class-product-cat-dropdown-walker.php' );
					$current_category = get_queried_object();
					$parent_1 = get_term($current_category->parent,'product_cat');
					//$parent_1_slug = $parent_1->slug;
					$current_cate = $current_category->slug;

					//var_dump($wp_query->query['product_cat']);
					$r = array();
					$r['pad_counts']    = 1;
					$r['hierarchical']  = 1;
					$r['hide_empty']    = 0;
					$r['show_count']    = 0;
					$r['include'] = array(29,30);
					$r['selected']      = $parent_1->slug;

					//$r['parent'] = array(16,18,19);
					//$r['selected'] = 'wow-stock';

					$terms = get_terms( 'product_cat', $r );

					$dropdown  = "<select name='product_cat' id='dropdown_product_cat1'>";
					$dropdown .= '<option value="" ' .  selected( isset( $_GET['product_cat'] ) ? $_GET['product_cat'] : '', '', false ) . '>'.__( 'Select a category', 'woocommerce' ).'</option>';
					$dropdown .= woocommerce_walk_category_dropdown_tree( $terms, 0, $r );
					$dropdown .="</select>";
					$terms = array();
					if(in_array($current_category->parent,array(29,30))) {

						$r = array();
						$r['pad_counts']    = 1;
						$r['hierarchical']  = 1;
						$r['hide_empty']    = 0;
						$r['show_count']    = 0;
						$r['parent'] = $current_category->parent;
						$r['selected']      = $current_cate;

						//$r['parent'] = array(16,18,19);
						//$r['selected'] = 'wow-stock';
						$terms = get_terms( 'product_cat', $r );
					}
					

					$dropdown1  = "<span id='dropdown_product_cat_wrap'><select name='product_cat' id='dropdown_product_cat'>";
					$dropdown1 .= '<option value="" ' .  selected( isset( $_GET['product_cat'] ) ? $_GET['product_cat'] : '', '', false ) . '>'.__( 'Select a sub category', 'woocommerce' ).'</option>';
					$dropdown1 .= woocommerce_walk_category_dropdown_tree( $terms, 0, $r );
					$dropdown1 .="</select></span>";

					echo '<div class="product_category_filter">';
					echo $dropdown;
					echo $dropdown1;
					echo '</div>';

					?>
			<script type='text/javascript'>
			/* <![CDATA[ */
			
				jQuery(document).ready( function() {

				   jQuery("#dropdown_product_cat1").change( function() {

				   	  //alert(jQuery(this).val());
				   	  //return false;
				      parent = jQuery(this).val();
				      nonce = jQuery(this).attr("data-nonce");

				      jQuery.ajax({
				         type : "post",
				         dataType : "html",
				         url : '<?php echo admin_url( 'admin-ajax.php' ); ?>',
				         data : {action: "woocommerce_cate_filter", parent : parent, nonce: nonce},
				         success: function(response) {
				         	//console.log(response);
				            jQuery("#dropdown_product_cat_wrap").html(response);
				         }
				      });   

				   });

				});

				function dropdown_change (sef) {
					//console.log(sef.value);
					if(sef.value != 0) {
					 	location.href = "<?php echo home_url(); ?>/?product_cat="+sef.value;
					}
					return false;
				}

			/* ]]> */
			</script>
			

					<?php

}

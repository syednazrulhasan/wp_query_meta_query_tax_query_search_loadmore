# WP_Query Meta_Query Tax_Query Date_Query with jQuery & Ajax
This repo contains code that helps to learn about WP_Query Meta_Query Tax_Query Date_Query Search Pagination using Ajax & jQuery 
===================================

### Intro
Wordpress provides a very fine way to organize data through Custom Post Types and Custom Taxonomy you can learn more by viewing a YT video here https://youtu.be/JLWx3vJSjoM?feature=shared 

The purpose of the video mentioned above or this repo to provide an easy understanding ot Meta_Query Tax_Query Date_Query Search which are used within WP_Query and that too with  Load More using Ajax Calls with jQuery. For Date_Query you can take a look at example code from [this](https://github.com/syednazrulhasan/wp-load-more-plugin) repo

***NOTE :- PLEASE MAKE SURE TO INCLUDE WP_NOUNCE FOR SECURITY PURPOSE IN AJAX CALLS SINCE THIS CODE IS FOR BEGINNERS SO IT HAS BEEN EXCLUDED FROM THE CODE TO HELP THEM LEARN AJAX CALLS IN WORDPRESS*** 

**Step 1** Here is the code break down needed to achieve same for this we have created a custom post type `products` and custom taxonomy `product-brand` linked to this custom post type and placed the code in active theme's `functions.php` which is as below.
 

```
// Register Custom Post Type
function custom_post_type() {

    $labels = array(
        'name'                  => _x( 'Products', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Product', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Product', 'text_domain' ),
        'name_admin_bar'        => __( 'Products', 'text_domain' ),
        'archives'              => __( 'Item Archives', 'text_domain' ),
        'attributes'            => __( 'Item Attributes', 'text_domain' ),
        'parent_item_colon'     => __( '', 'text_domain' ),
        'all_items'             => __( 'All Products', 'text_domain' ),
        'add_new_item'          => __( 'Add New Product', 'text_domain' ),
        'add_new'               => __( 'Add Product', 'text_domain' ),
        'new_item'              => __( 'New Product', 'text_domain' ),
        'edit_item'             => __( 'Edit Product', 'text_domain' ),
        'update_item'           => __( 'Update Product', 'text_domain' ),
        'view_item'             => __( 'View Product', 'text_domain' ),
        'view_items'            => __( 'View Products', 'text_domain' ),
        'search_items'          => __( 'Search Product', 'text_domain' ),
        'not_found'             => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
        'items_list'            => __( 'Items list', 'text_domain' ),
        'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Product', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail' ),
        'taxonomies'            => array( 'product-category', 'product-brand' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 10,
        'menu_icon'             => 'dashicons-products',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'products', $args );

}
add_action( 'init', 'custom_post_type', 0 );


// Register Custom Taxonomy
function product_brand() {

    $labels = array(
        'name'                       => _x( 'Brands', 'Taxonomy General Name', 'as' ),
        'singular_name'              => _x( 'Brand', 'Taxonomy Singular Name', 'as' ),
        'menu_name'                  => __( 'Brands', 'as' ),
        'all_items'                  => __( 'All Brands', 'as' ),
        'parent_item'                => __( 'Parent Item', 'as' ),
        'parent_item_colon'          => __( 'Parent Item:', 'as' ),
        'new_item_name'              => __( 'New Brand', 'as' ),
        'add_new_item'               => __( 'Add Brand', 'as' ),
        'edit_item'                  => __( 'Edit Brand', 'as' ),
        'update_item'                => __( 'Update Brand', 'as' ),
        'view_item'                  => __( 'View Brand', 'as' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'as' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'as' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'as' ),
        'popular_items'              => __( 'Popular Items', 'as' ),
        'search_items'               => __( 'Search Items', 'as' ),
        'not_found'                  => __( 'Not Found', 'as' ),
        'no_terms'                   => __( 'No items', 'as' ),
        'items_list'                 => __( 'Items list', 'as' ),
        'items_list_navigation'      => __( 'Items list navigation', 'as' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'product-brand', array( 'products' ), $args );

}
add_action( 'init', 'product_brand', 0 );
```



**Step 2** We need to enqueue our code in functions.php of active theme and also localize the script so that we are able to pass alng php variables to the script to be utilized there as an javascript objects here we are passing `ajaxurl` and `templatedirectory` to `filter.js`

```

function filter_enqueue_scripts(){


    wp_enqueue_style('customfilter', get_template_directory_uri() . '/css/filter.css', array(), '1.0', 'all');

    wp_enqueue_script('customfilter', get_template_directory_uri(). '/js/filter.js', array('jquery'),rand(),true);

    wp_localize_script( 'customfilter', 'themeData', array(

        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'templatedirectory' => get_template_directory_uri(),

    ));

}
add_action( 'wp_enqueue_scripts', 'filter_enqueue_scripts' );

```
**Step 3** We write down our `filter.js`  to facilitate ajax calls to appropriate hooks in `functions.php` the hooks to receive ajax request from `filter.js` is as below with `filter_product`  being sent as action value from `filter.js` and further its combiled to hooks in  `wp-includes/admin-ajax.php`  to form an action as `wp_ajax_filter_product`  and `wp_ajax_nopriv_filter_product`

```
function filter_product_callback(){ 

/*Array
(
    [action] => filter_product
    [category] => 
    [brand] => 24,
    [searchtext] => dell
    [pageno] => 1
)
*/

    $brand       = sanitize_text_field($_POST['brand']);
    $category    = sanitize_text_field(trim($_POST['category'])) ;
    $paged       = sanitize_text_field($_POST['pageno']);
    $searchtext  = sanitize_text_field($_POST['searchtext']);


    if (!empty($brand)) {
        $brand = explode(',', $brand);
        $brand = array_filter($brand);
    }

    $tax_query  = array();
    $meta_query = array();

    if($brand){
        $tax_query[] = array(
            'taxonomy'  => 'product-brand',
            'field'     => 'term_id',
            'terms'     => $brand,
        );
    }

    if($category){
        $meta_query[] = array(
            'key'     => 'product_type',
            'value'   => $category,
            'compare' => '='
        );
    }


    if( !empty($tax_query) || !empty($category) || !empty($searchtext) ){
        
        $args = array(
            'post_type'      => 'products',
            'post_status'    => 'publish',
            'posts_per_page' => 1,
            'paged'          => $paged,
            'tax_query'      => $tax_query,
            'meta_query'     => $meta_query,
            's'              => $searchtext,
        );

        if(empty($args['tax_query'])){
            unset($args['tax_query']);
        }

        if(empty($args['meta_query'])){
            unset($args['meta_query']);
        }

        if(empty($args['s'])){
            unset($args['s']);
        }
    }else{
        $args = array(
            'post_type'      => 'products',
            'post_status'    => 'publish',
            'posts_per_page' => 1,
            'paged'          => $paged,
            's'              => $searchtext,
        );

        if(empty($searchtext)){
            unset($args['s']);
        }
    }


    $loop = new WP_Query($args);

    if($loop->have_posts()){
        while($loop->have_posts()){
            $loop->the_post();
            $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium');

            $imageurl = is_array($thumbnail) ?  $thumbnail[0] : 'https://picsum.photos/200';

    ?>
    <div class="col-sm-12 col-md-6 col-lg-4 center-cards">
        <div class=" card-width ">
            <img src="<?php echo $imageurl; ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?php the_title(); ?></h5>
                <!-- <p class="card-text"><?php the_title(); ?></p> -->
                <a href="<?php the_permalink(); ?>" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    </div>
    <?php
        }
    }


    die; 
}
add_action('wp_ajax_filter_product', 'filter_product_callback');
add_action('wp_ajax_nopriv_filter_product', 'filter_product_callback');

```

**Step 4** We will write down further a shortcode to house all HTML elements to pull the interactive html elements on the page and based on their interactivity it will trigger further ajax calls.

```
function filter_product_shortcode(){

    $brands = get_terms(array(
        'taxonomy' => 'product-brand', 
        'hide_empty' => false,

    ));
    $brandslist = '';


    $i = 1; 
    foreach ($brands as $brand) {
    $brandslist .=  
    '<li>
        <input class="form-check-input tax1" type="checkbox" value="'.$brand->term_id.'" id="option'.$i.'">
        <label class="form-check-label" for="option'.$i.'">'.$brand->name.'</label>
      </li>';

    $i++; 
    }

    $j = 1;
    $categorylist ='';
    $field = get_field_object('field_65b6f58db81fa');
    $choices = $field['choices']; 
    foreach ($choices as $key => $val) {
    $categorylist .=  
    '<li>
        <input name="category" class="form-check-input tax2" type="radio" value="'.$key.'" id="option'.$j.'">
        <label class="form-check-label" for="option'.$j.'">'.$val.'</label>
      </li>';

    $j++; 
    }


    $var = '    <div class="container  mx-auto  content">
        <div class="row my-4">

           <div class="col-sm-12 col-md-6 col-lg-3">
            <input class="form-control w-100 py-2 mb-4 custom-search-input" placeholder="Search" id="searchtext" />

           </div>

           <!-- DROPDOWN1 -->
           <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="dropdown mb-4">
                <button class="btn btn-custom dropdown-toggle w-100" type="button" id="multiSelectDropdown1" data-bs-toggle="dropdown" aria-expanded="false">
                  Select Options
                </button>
                <ul class="dropdown-menu px-2 w-100" aria-labelledby="multiSelectDropdown1" id="multiSelectDropdown1">'.$brandslist.'
                  <!-- Add more options as needed -->
                </ul>
              </div>
           </div>


            <!-- DROPDOWN 2 -->
           <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="dropdown mb-4">
                <button class="btn btn-custom dropdown-toggle w-100" type="button" id="multiSelectDropdown2" data-bs-toggle="dropdown" aria-expanded="false">
                  Select Options
                </button>
                <ul class="dropdown-menu px-2 w-100" aria-labelledby="multiSelectDropdown2" id="multiSelectDropdown2">'.$categorylist.'
                    <!-- Add more options as needed -->
                </ul>
              </div>
           </div>
          <!-- TEST DROP -->

          <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="elementor-button-wrapper2">
                    <a id="reset" class="btn btn-success" href="javascript:void(0);">
                        Start Over
                    </a>
                </div>
          </div>


         
        </div>

        <!-- CARD SECTION -->
        <div class="row " id="products">

        </div>
        <div class="loadmore" style="text-align:center;">
            <a href="javascript:void(0);" class="btn btn-primary" id="loadmore">Load More</a>
            <input type="hidden" value="1" id="pageno" />
        </div>
    </div>'; 

    return $var; 

}

add_shortcode('filter_product', 'filter_product_shortcode');
```

**Step 5** Finally we create a page template and assign it to page and we also include the shortcode.

```
<?php /* Template Name: Page Filter Template */


get_header();
?>

<?php 

echo do_shortcode('[filter_product]'); ?>

<?php get_footer(); ?>
```
<?php
/**
 * Fresh Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Fresh_Theme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function fresh_theme_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Fresh Theme, use a find and replace
		* to change 'fresh-theme' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'fresh-theme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'fresh-theme' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'fresh_theme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'fresh_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function fresh_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'fresh_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'fresh_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function fresh_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'fresh-theme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'fresh-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);


	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar 2', 'fresh-theme' ),
			'id'            => 'sidebar-2',
			'description'   => esc_html__( 'Add widgets here.', 'fresh-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'fresh_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function fresh_theme_scripts() {
	wp_enqueue_style( 'fresh-theme-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'fresh-theme-style', 'rtl', 'replace' );

	wp_enqueue_script( 'fresh-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'fresh_theme_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

#add_action('wp_print_footer_scripts', 'your_function_name');
function your_function_name(){
?>
<script type="text/javascript">

	setTimeout(() => {
	  alert('adasd');
	}, "3000");

	

</script>
<?php
}

// Execute a function after the admin bar is rendered.
add_action('wp_after_admin_bar_render', 'your_function_name2');

function your_function_name2() {
    // Your custom code here.
    echo '<div style="background-color: red; color: white; padding: 10px;">This is just a testing admin panel!</div>';
}





/*Rest API Endpoint to pull Accomodation and Restaurants*/
function faq_json_endpoint_init() {
    add_action('rest_api_init', 'stayeat_json_endpoint_register');
}

// Register the stayeat route
function stayeat_json_endpoint_register() {
    register_rest_route('faq/v1', '/posts', array(
        'methods'  => 'GET',
        'callback' => 'stayeat_json_endpoint_callback',
    ));
}

// Callback function for your stayeat endpoint
function stayeat_json_endpoint_callback($request) {



    $args = array(
        'post_type'      => 'faq',
        'posts_per_page' => -1 ,
        'post_status'    => 'publish'

    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $i =1; 
        while ($query->have_posts()) {
            $query->the_post();

              $restaurants[] =  array(
                    "row"                   => $i,
                    "id"              => get_the_ID(),
                    "title"           => get_the_title(),
                    
                );
            $i++; 
        }
        
        wp_reset_postdata(); 
    } else {
        
    }

        $data = array(
        "faqposts" => $restaurants,
        "requeststatus" => array(
            "pagesize" => "250",
            "pagenum" => "1",
            "results" => $query->post_count,
            "errors" => array(),
            "haserrors" => "0"
        )
    );



    $response = new WP_REST_Response($data);
    $response->set_status(200);

    return $response;
}

// Initialize the custom JSON endpoint
faq_json_endpoint_init();




function change_date_format($content) {
    $pattern = '/(<p>)*(2024)(\.?)<\/p>/i';
    $replacement = 'The year is $2.';
    return preg_replace($pattern, $replacement, $content);
}
add_filter('the_content', 'change_date_format');




function custom_excerpt_length( $length ) {
    return 15;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


function custom_excerpt_more( $more ) {
    return ' Read More';
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );






function schedule_publish_new_post_event() {
    if (!wp_next_scheduled('publish_new_post_event')) {
        wp_schedule_event(time(), 'minute', 'publish_new_post_event');
    }
}
add_action('wp', 'schedule_publish_new_post_event');

function publish_new_post_event_handler() {
    // Your code to publish a new post goes here
    $post_title = 'Your post title';
    $post_content = 'Your post content';
    $post_status = 'publish';
    $post_data = array(
        'post_title'    => $post_title,
        'post_content' => $post_content,
        'post_status'   => $post_status,
        'post_author'   => 1,
    );
    wp_insert_post($post_data);
}
add_action('publish_new_post_event', 'publish_new_post_event_handler');


/*===================================*/

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


/*===================================*/


function filter_enqueue_scripts(){

 
     wp_enqueue_style('bs502','https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
     wp_enqueue_script('bs502','https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js',array('jquery'));

    wp_enqueue_style('customfilter', get_template_directory_uri() . '/css/filter.css', array(), '1.0', 'all');

    wp_enqueue_script('customfilter', get_template_directory_uri(). '/js/filter.js', array('jquery'),rand(),true);

    wp_localize_script( 'customfilter', 'themeData', array(

        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'templatedirectory' => get_template_directory_uri(),

    ));

}
add_action( 'wp_enqueue_scripts', 'filter_enqueue_scripts' );


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

    // echo '<pre>';
    // print_r($args);


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
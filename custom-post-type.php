<?php
/*
Plugin Name: Custom Post Types
Description: Add post types for custom articles
Author: Lux
*/
// Hook ht_custom_post_custom_article() to the init action hook
add_action( 'init', 'ht_custom_post_custom_article' );
// The custom function to register a custom article post type
function ht_custom_post_custom_article() {
    // Set the labels. This variable is used in the $args array
    $labels = array(
        'Title'               => __( 'Title' ),
        'Content'      => __( 'Article Content ' ),
        'featured_image'     => 'Poster',
        'set_featured_image' => 'Add Poster'
    );
// The arguments for our post type, to be entered as parameter 2 of register_post_type()
    $args = array(
        'labels'            => $labels,
        'description'       => 'Holds our custom article post specific data',
        'public'            => true,
        'menu_position'     => 5,
        'supports'          => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
        'has_archive'       => true,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'query_var'         => true,
    );
    // Call the actual WordPress function
    // Parameter 1 is a name for the post type
    // Parameter 2 is the $args array
    register_post_type('article', $args);
}

// Add meta box 
add_action("add_meta_boxes", "add_author_meta_box");
function add_author_meta_box()
{
    add_meta_box(
    "author_meta_box", // Meta box ID
    "Author Details", // Meta box title
    "author_meta_box_callback", // Meta box callback function
    "article", // The custom post type parameter 1
    "side", // Meta box location in the edit screen
    "high" // Meta box priority
); 
}
function author_meta_box_callback()
{ 
  wp_nonce_field(‘author-nonce’, ‘meta-box-nonce’);
global $post;
placeholder
?>
	  <th><label for="athor_name_field">Author Name</label><th>
	  <td><input 
    type="text"
    id="author_name" 
    class="regular-text" 
    name=“Author_Name” 
    value=“” 
	/> 
		<td> 
		<th><label for="author_id_field">Author ID</label><th>
	  <td><input 
	type="text" 
	id="author_id" 
	class="regular-text"
	name=“Author_ID”
	Value=””
	/> 
		<td> 
<?php
// Save meta box data
add_action ( 'save_post', 'author_save_postdata');
function author_save_postdata( $post_id ) {
// If this is an autosave, our form has not been submitted
if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
return $post_id;
  // Retrieve post id
  If (‘article’ !== get_post_type() ) {
    return $post_id
}
   // Check the user's permissions
     if ( 'page' == $_POST['post_type'] ) {
  
if ( ! current_user_can( 'edit_page', $post_id ) )
return $post_id;
  
} else {
  
if ( ! current_user_can( 'edit_post', $post_id ) )
return $post_id;
}
  
/* OK, it is safe to save the data now. */
  
// Sanitize user input.
$mydata = sanitize_text_field( $_POST['Author_Name'] );
$mydata = sanitize_text_field( $_POST['Author_ID'] );
  
// Update the meta field in the database.
update_post_meta( $post_id, 'Author_Name', $_POST['Author_Name'] ); 
update_post_meta( $post_id, 'Author_ID', $_POST['Author_ID'] ); 
 }
}
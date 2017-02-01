<?php
/**
 * Shortcode register.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_register_shortcode' ) ) {
	function k2t_register_shortcode( $atts, $content ) {
		$html = $title = $username = $password = $email = $website = $first_name = $last_name = $bio = $submit = '';
		extract( shortcode_atts( array( 'title'=>'','username' => '','password'=> '','email'=> '','website'=> '','last_name'=> '','last_name'=> '','bio'=> '', 'submit' => esc_html__( 'Register', 'k2t') ), $atts ) );
		$fields = array( 'username' => $username,'password'=> $password,'email'=> $email,'website'=> $website,'first_name'=> $first_name,'last_name'=> $last_name,'bio'=> $bio, 'submit' => $submit );
	$class =  array();
	if ( is_user_logged_in() ) {
		$class[] = 'user-login,';
	}
	ob_start();
	if ( isset($_POST['submit'] ) ) {
        registration_validation(
	        $_POST['username'],
	        $_POST['password'],
	        $_POST['email'],
	        $_POST['website'],
	        $_POST['fname'],
	        $_POST['lname'],
	        $_POST['nickname'],
	        $_POST['bio']
        );

	    // sanitize user form input
	    global $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio;
	    $username   =   sanitize_user( $_POST['username'] );
	    $password   =   esc_attr( $_POST['password'] );
	    $email      =   sanitize_email( $_POST['email'] );
	    $website    =   esc_url( $_POST['website'] );
	    $first_name =   sanitize_text_field( $_POST['fname'] );
	    $last_name  =   sanitize_text_field( $_POST['lname'] );
	    $nickname   =   sanitize_text_field( $_POST['nickname'] );
	    $bio        =   esc_textarea( $_POST['bio'] );
		// call @function complete_registration to create the user
		// only when no WP_error is found
	    complete_registration(
	        $username,
	        $password,
	        $email,
	        $website,
	        $first_name,
	        $last_name,
	        $nickname,
	        $bio
	    );
	}
 
    registration_form(
        $username,
        $password,
        $email,
        $website,
        $first_name,
        $last_name,
        $nickname,
        $bio,
        $submit,
        $fields
    );
		//Apply filters return
	$html = ob_get_clean();
	$html = apply_filters( 'k2t_register_shortcode_return', $html );

		return $html;
	}
}

function registration_form( $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio, $submit , $fields ) {
	$form ='<form class="k2t-register"  action="' . $_SERVER['REQUEST_URI'] . '" method="post">';
	//username
	$form .=  '<div>
				    <label for="username">Username <strong>*</strong></label>
				    <input type="text" name="username" value="' . ( isset( $_POST['username'] ) ? $username : null ) . '">
			   </div>';
    //password
	$form .= '<div>
			    <label for="password">Password <strong>*</strong></label>
			    <input type="password" name="password" value="' . ( isset( $_POST['password'] ) ? $password : null ) . '">
		      </div>';
    //email
	$form .=  '<div>
			    <label for="email">Email <strong>*</strong></label>
			    <input type="text" name="email" value="' . ( isset( $_POST['email']) ? $email : null ) . '">
			   </div>';
	//website   
    if ( $fields['website'] )
	$form .=    '<div>
				    <label for="website">Website</label>
				    <input type="text" name="website" value="' . ( isset( $_POST['website']) ? $website : null ) . '">
			    </div>';
	//first name   
    if ( $fields['first_name'] )
	$form .=    '<div>
				    <label for="firstname">First Name</label>
				    <input type="text" name="fname" value="' . ( isset( $_POST['fname']) ? $first_name : null ) . '">
			    </div>';
    //last name 
    if ( $fields['last_name'] )
	$form .=    '<div>
					<label for="lname">Last Name</label>
					<input type="text" name="lname" value="' . ( isset( $_POST['lname']) ? $last_name : null ) . '">
				</div>';
	//nickname 
	if ( $fields['nickname'] )
	$form .=    '<div>
				    <label for="nickname">Nickname</label>
				    <input type="text" name="nickname" value="' . ( isset( $_POST['nickname']) ? $nickname : null ) . '">
			    </div>';
	//bio
    if ( $fields['bio'] ) 
    $form .=	'<div>
				    <label for="bio">About / Bio</label>
				    <textarea name="bio">' . ( isset( $_POST['bio']) ? $bio : null ) . '</textarea>
				</div>';
   	$form .= 	'<input type="submit" class="btn-submit k2t-element-hover" name="submit" value="' . $submit .'"/>';
    $form .= '</form>';
    echo $form;
}

function registration_validation( $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio )  {
	global $reg_errors;
	$reg_errors = new WP_Error;
	if ( empty( $username ) || empty( $password ) || empty( $email ) ) {
	    $reg_errors->add('field', esc_html__( 'Required form field is missing', 'k2t' ) );
	}
	if ( 4 > strlen( $username ) ) {
	    $reg_errors->add( 'username_length', esc_html__( 'Username too short. At least 4 characters is required', 'k2t' ));
	}
	if ( username_exists( $username ) )
    	$reg_errors->add('user_name', esc_html__( 'Sorry, that username already exists!', 'k2t') );
    if ( ! validate_username( $username ) ) {
	    $reg_errors->add( 'username_invalid', esc_html__( 'Sorry, the username you entered is not valid', 'k2t' ));
	}
	if ( 5 > strlen( $password ) ) {
        $reg_errors->add( 'password', esc_html__( 'Password length must be greater than 5', 'k2t' ) );
    }
    if ( !is_email( $email ) ) {
	    $reg_errors->add( 'email_invalid', esc_html__( 'Email is not valid', 'k2t' ) );
	}
	if ( email_exists( $email ) ) {
	    $reg_errors->add( 'email', esc_html__( 'Email Already in use', 'k2t' ) );
	}
	if ( ! empty( $website ) ) {
	    if ( ! filter_var( $website, FILTER_VALIDATE_URL ) ) {
	        $reg_errors->add( 'website', esc_html__( 'Website is not a valid URL' , 'k2t') );
	    }
	}
	if ( is_wp_error( $reg_errors ) ) {
 
	    foreach ( $reg_errors->get_error_messages() as $error ) {
	     
	        echo '<div class="k2t-register-err"><p>';
	        echo '<strong> ' . esc_html__( 'ERROR', 'k2t' ) . '</strong>:';
	        echo '<span> ' .$error . '</span></p>';
	        echo '</div>';
	         
	    }

	}
}

function complete_registration() {
    global $reg_errors, $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio;
    if ( 1 > count( $reg_errors->get_error_messages() ) ) {
        $userdata = array(
        'user_login'    =>   $username,
        'user_email'    =>   $email,
        'user_pass'     =>   $password,
        'user_url'      =>   $website,
        'first_name'    =>   $first_name,
        'last_name'     =>   $last_name,
        'nickname'      =>   $nickname,
        'description'   =>   $bio,
        'role'			=>   'customer'
        );
        $user = wp_insert_user( $userdata );
        echo '<p class="register-success">Registration complete. Goto <a href="' . get_site_url() . '/wp-login.php">login page</a>.</p>';   
    }
}